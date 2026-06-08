<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\GalleryCategory;
use Calyo\Models\GalleryImage;
use Calyo\Services\ImageUploader;
use Throwable;

final class GalleryController extends Controller
{
    private GalleryImage $model;
    private GalleryCategory $categories;
    private ImageUploader $uploader;

    public function __construct()
    {
        $this->model      = new GalleryImage();
        $this->categories = new GalleryCategory();
        $this->uploader   = new ImageUploader();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('gallery.index', [
            'title'        => 'Gallery',
            'result'       => $result,
            'filters'      => $filters,
            'categories'   => $this->categories->ordered(),
            'categoryMap'  => GalleryCategory::map(),
            'imageCounts'  => $this->categories->imageCounts(),
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/gallery');
        }

        [$sourceType, $imagePath, $imageUrl] = $this->resolveImage($request, $data, null);

        $this->model->create([
            'title'       => $data['title'],
            'category'    => $data['category'],
            'source_type' => $sourceType,
            'image_path'  => $imagePath,
            'image_url'   => $imageUrl,
            'sort_order'  => $data['sort_order'],
            'is_active'   => $data['is_active'],
            'created_by'  => current_user()['id'] ?? null,
        ]);

        Session::flash('success', 'Gallery image added.');
        $this->redirect('/gallery');
    }

    public function update(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Gallery image not found.');
            $this->redirect('/gallery');
        }

        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/gallery');
        }

        [$sourceType, $imagePath, $imageUrl] = $this->resolveImage($request, $data, $existing);

        $this->model->update((int) $id, [
            'title'       => $data['title'],
            'category'    => $data['category'],
            'source_type' => $sourceType,
            'image_path'  => $imagePath,
            'image_url'   => $imageUrl,
            'sort_order'  => $data['sort_order'],
            'is_active'   => $data['is_active'],
        ]);

        Session::flash('success', 'Gallery image updated.');
        $this->redirect('/gallery');
    }

    public function destroy(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Gallery image not found.');
            $this->redirect('/gallery');
        }

        // Only uploaded files live on disk; external URLs need no cleanup.
        if (($existing['source_type'] ?? 'upload') === 'upload') {
            $this->uploader->delete($existing['image_path'] ?? null);
        }
        $this->model->delete((int) $id);

        Session::flash('success', 'Gallery image deleted.');
        $this->redirect('/gallery');
    }

    // ── categories ─────────────────────────────────────────────────────────

    public function storeCategory(Request $request): void
    {
        $data = $this->readCategoryInput($request, null);

        $this->categories->create([
            'slug'       => $data['slug'],
            'label'      => $data['label'],
            'sort_order' => $data['sort_order'],
            'is_active'  => $data['is_active'],
        ]);

        Session::flash('success', 'Category added.');
        $this->redirect('/gallery');
    }

    public function updateCategory(Request $request, string $id): void
    {
        $existing = $this->categories->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Category not found.');
            $this->redirect('/gallery');
        }

        $data = $this->readCategoryInput($request, $existing);

        // If the slug changed, re-point the images that referenced the old one
        // so they stay attached to this category.
        $this->categories->renameOnImages((string) $existing['slug'], $data['slug']);

        $this->categories->update((int) $id, [
            'slug'       => $data['slug'],
            'label'      => $data['label'],
            'sort_order' => $data['sort_order'],
            'is_active'  => $data['is_active'],
        ]);

        Session::flash('success', 'Category updated.');
        $this->redirect('/gallery');
    }

    public function destroyCategory(Request $request, string $id): void
    {
        $existing = $this->categories->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Category not found.');
            $this->redirect('/gallery');
        }

        $count = $this->categories->imageCount((string) $existing['slug']);
        if ($count > 0) {
            Session::flash('error', sprintf(
                'Cannot delete "%s" — %d image%s still use%s it. Reassign or delete those images first.',
                $existing['label'],
                $count,
                $count === 1 ? '' : 's',
                $count === 1 ? 's' : ''
            ));
            $this->redirect('/gallery');
        }

        $this->categories->delete((int) $id);

        Session::flash('success', 'Category deleted.');
        $this->redirect('/gallery');
    }

    /**
     * Read + validate a category form. The slug is taken from the slug field
     * when provided, otherwise derived from the label; it must be unique.
     * Validation failures redirect with a flash message (never returns).
     *
     * @return array{slug:string,label:string,sort_order:int,is_active:int}
     */
    private function readCategoryInput(Request $request, ?array $existing): array
    {
        $label = clean((string) $request->input('label', ''));
        $slugIn = (string) $request->input('slug', '');
        $slug   = GalleryCategory::slugify($slugIn !== '' ? $slugIn : $label);

        if ($label === '') {
            Session::flash('error', 'Category label is required.');
            $this->redirect('/gallery');
        }
        if ($slug === '') {
            Session::flash('error', 'Could not build a valid slug — use letters or numbers.');
            $this->redirect('/gallery');
        }

        // Enforce slug uniqueness (ignoring the row being edited).
        $clash = $this->categories->findBySlug($slug);
        if ($clash && (!$existing || (int) $clash['id'] !== (int) $existing['id'])) {
            Session::flash('error', "The slug \"$slug\" is already in use.");
            $this->redirect('/gallery');
        }

        return [
            'slug'       => $slug,
            'label'      => $label,
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active'  => (int) (bool) $request->input('is_active', 1),
        ];
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        return [
            'search'    => clean((string) $request->input('search', '')),
            'category'  => clean((string) $request->input('category', '')),
            'is_active' => clean((string) $request->input('is_active', '')),
        ];
    }

    private function readInput(Request $request): array
    {
        return [
            'title'       => clean((string) $request->input('title', '')),
            'category'    => GalleryImage::normalizeCategory((string) $request->input('category', 'studio')),
            'source'      => clean((string) $request->input('source', 'upload')),
            'image_url'   => trim((string) $request->input('image_url', '')),
            'sort_order'  => (int) $request->input('sort_order', 0),
            'is_active'   => (int) (bool) $request->input('is_active', 1),
        ];
    }

    /**
     * Work out the final image columns from the chosen source.
     *
     * Returns [source_type, image_path, image_url]. On create, $existing is
     * null. On update, an unchanged source keeps the existing values so the
     * form doesn't have to re-send the file / URL.
     *
     * Validation failures redirect with a flash message (never returns).
     *
     * @return array{0:string,1:?string,2:?string}
     */
    private function resolveImage(Request $request, array $data, ?array $existing): array
    {
        $source  = $data['source'] === 'url' ? 'url' : 'upload';
        $hasFile = isset($_FILES['image']) && ($_FILES['image']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;

        if ($source === 'url') {
            $url = $data['image_url'];
            if ($url === '' && $existing && ($existing['source_type'] ?? '') === 'url') {
                $url = (string) ($existing['image_url'] ?? '');
            }
            if ($url === '' || !filter_var($url, FILTER_VALIDATE_URL)) {
                Session::flash('error', 'Please enter a valid image URL (starting with http:// or https://).');
                $this->redirect('/gallery');
            }
            // Switching an uploaded image over to a URL — remove the old file.
            if ($existing && ($existing['source_type'] ?? '') === 'upload') {
                $this->uploader->delete($existing['image_path'] ?? null);
            }
            return ['url', null, $url];
        }

        // source === 'upload'
        if (!$hasFile) {
            // No new file. On update, keep the existing upload if there is one.
            if ($existing && ($existing['source_type'] ?? '') === 'upload' && !empty($existing['image_path'])) {
                return ['upload', $existing['image_path'], null];
            }
            Session::flash('error', 'Please choose an image file to upload.');
            $this->redirect('/gallery');
        }

        try {
            $path = $this->uploader->store($_FILES['image'], 'uploads/gallery', $data['title']);
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/gallery');
        }

        // Replace the previous uploaded file, if any.
        if ($existing && ($existing['source_type'] ?? '') === 'upload') {
            $this->uploader->delete($existing['image_path'] ?? null);
        }

        return ['upload', $path, null];
    }
}
