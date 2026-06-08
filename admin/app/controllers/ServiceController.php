<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Service;
use Calyo\Services\ImageUploader;
use Throwable;

final class ServiceController extends Controller
{
    private Service $model;
    private ImageUploader $uploader;

    public function __construct()
    {
        $this->model    = new Service();
        $this->uploader = new ImageUploader();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('services.index', [
            'title'   => 'Services & Workshops',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/services');
        }

        try {
            $imagePath = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/services',
                $data['title']
            );
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/services');
        }

        $row = [
            'type'        => $data['type'],
            'title'       => $data['title'],
            'slug'        => $this->model->uniqueSlug($data['title']),
            'description' => $data['description'],
            'image_path'  => $imagePath,
            'price'       => $data['price'],
            'duration'    => $data['duration'],
            'sort_order'  => $data['sort_order'],
            'is_active'   => $data['is_active'],
            'created_by'  => current_user()['id'] ?? null,
        ];

        $this->model->create($row);
        Session::flash('success', ucfirst($data['type']) . ' added successfully.');
        $this->redirect('/services');
    }

    public function update(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Item not found.');
            $this->redirect('/services');
        }

        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/services');
        }

        $imagePath = $existing['image_path'];
        try {
            $newImage = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/services',
                $data['title']
            );
            if ($newImage !== null) {
                $this->uploader->delete($existing['image_path']);
                $imagePath = $newImage;
            }
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/services');
        }

        $row = [
            'type'        => $data['type'],
            'title'       => $data['title'],
            'slug'        => $existing['title'] === $data['title']
                ? $existing['slug']
                : $this->model->uniqueSlug($data['title'], (int) $id),
            'description' => $data['description'],
            'image_path'  => $imagePath,
            'price'       => $data['price'],
            'duration'    => $data['duration'],
            'sort_order'  => $data['sort_order'],
            'is_active'   => $data['is_active'],
        ];

        $this->model->update((int) $id, $row);
        Session::flash('success', ucfirst($data['type']) . ' updated successfully.');
        $this->redirect('/services');
    }

    public function destroy(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Item not found.');
            $this->redirect('/services');
        }

        $this->uploader->delete($existing['image_path']);
        $this->model->delete((int) $id);

        Session::flash('success', 'Item deleted.');
        $this->redirect('/services');
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        return [
            'search'    => clean((string) $request->input('search', '')),
            'type'      => clean((string) $request->input('type', '')),
            'is_active' => clean((string) $request->input('is_active', '')),
        ];
    }

    private function readInput(Request $request): array
    {
        $type = clean((string) $request->input('type', 'service'));
        if (!in_array($type, Service::TYPES, true)) {
            $type = 'service';
        }

        return [
            'type'        => $type,
            'title'       => clean((string) $request->input('title', '')),
            'description' => clean((string) $request->input('description', '')),
            'price'       => clean((string) $request->input('price', '')),
            'duration'    => clean((string) $request->input('duration', '')),
            'sort_order'  => (int) $request->input('sort_order', 0),
            'is_active'   => (int) (bool) $request->input('is_active', 1),
        ];
    }
}
