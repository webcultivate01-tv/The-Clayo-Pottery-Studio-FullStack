<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Popup;
use Calyo\Services\ImageUploader;
use Throwable;

final class PopupController extends Controller
{
    private Popup $model;
    private ImageUploader $uploader;

    public function __construct()
    {
        $this->model    = new Popup();
        $this->uploader = new ImageUploader();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('popups.index', [
            'title'   => 'Popups',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/popups');
        }

        try {
            $imagePath = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/popups',
                $data['title']
            );
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/popups');
        }

        $row = [
            'title'        => $data['title'],
            'subtitle'     => $data['subtitle'],
            'description'  => $data['description'],
            'image_path'   => $imagePath,
            'button_label' => $data['button_label'],
            'button_url'   => $data['button_url'],
            'starts_at'    => $data['starts_at'],
            'expires_at'   => $data['expires_at'],
            'sort_order'   => $data['sort_order'],
            'is_active'    => $data['is_active'],
            'created_by'   => current_user()['id'] ?? null,
        ];

        $this->model->create($row);
        Session::flash('success', 'Popup added successfully.');
        $this->redirect('/popups');
    }

    public function update(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Popup not found.');
            $this->redirect('/popups');
        }

        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/popups');
        }

        $imagePath = $existing['image_path'];
        try {
            $newImage = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/popups',
                $data['title']
            );
            if ($newImage !== null) {
                $this->uploader->delete($existing['image_path']);
                $imagePath = $newImage;
            }
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/popups');
        }

        $row = [
            'title'        => $data['title'],
            'subtitle'     => $data['subtitle'],
            'description'  => $data['description'],
            'image_path'   => $imagePath,
            'button_label' => $data['button_label'],
            'button_url'   => $data['button_url'],
            'starts_at'    => $data['starts_at'],
            'expires_at'   => $data['expires_at'],
            'sort_order'   => $data['sort_order'],
            'is_active'    => $data['is_active'],
        ];

        $this->model->update((int) $id, $row);
        Session::flash('success', 'Popup updated successfully.');
        $this->redirect('/popups');
    }

    public function destroy(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Popup not found.');
            $this->redirect('/popups');
        }

        $this->uploader->delete($existing['image_path']);
        $this->model->delete((int) $id);

        Session::flash('success', 'Popup deleted.');
        $this->redirect('/popups');
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        return [
            'search'    => clean((string) $request->input('search', '')),
            'is_active' => clean((string) $request->input('is_active', '')),
            'when'      => clean((string) $request->input('when', '')),
        ];
    }

    private function readInput(Request $request): array
    {
        return [
            'title'        => clean((string) $request->input('title', '')),
            'subtitle'     => clean((string) $request->input('subtitle', '')),
            'description'  => clean((string) $request->input('description', '')),
            'button_label' => clean((string) $request->input('button_label', '')),
            'button_url'   => clean((string) $request->input('button_url', '')),
            'starts_at'    => $this->normalizeDate((string) $request->input('starts_at', '')),
            'expires_at'   => $this->normalizeDate((string) $request->input('expires_at', '')),
            'sort_order'   => (int) $request->input('sort_order', 0),
            'is_active'    => (int) (bool) $request->input('is_active', 1),
        ];
    }

    /** Normalize a date input to YYYY-MM-DD, or NULL when blank/invalid. */
    private function normalizeDate(string $value): ?string
    {
        $value = clean($value);
        return $value !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)
            ? $value
            : null;
    }
}
