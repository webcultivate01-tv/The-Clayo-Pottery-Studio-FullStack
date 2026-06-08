<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Event;
use Calyo\Services\ImageUploader;
use Throwable;

final class EventController extends Controller
{
    private Event $model;
    private ImageUploader $uploader;

    public function __construct()
    {
        $this->model    = new Event();
        $this->uploader = new ImageUploader();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('events.index', [
            'title'   => 'Events',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/events');
        }

        try {
            $imagePath = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/events',
                $data['title']
            );
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/events');
        }

        $row = [
            'title'       => $data['title'],
            'slug'        => $this->model->uniqueSlug($data['title']),
            'description' => $data['description'],
            'image_path'  => $imagePath,
            'event_date'  => $data['event_date'],
            'event_time'  => $data['event_time'],
            'location'    => $data['location'],
            'price'       => $data['price'],
            'capacity'    => $data['capacity'],
            'sort_order'  => $data['sort_order'],
            'is_active'   => $data['is_active'],
            'created_by'  => current_user()['id'] ?? null,
        ];

        $this->model->create($row);
        Session::flash('success', 'Event added successfully.');
        $this->redirect('/events');
    }

    public function update(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Event not found.');
            $this->redirect('/events');
        }

        $data = $this->readInput($request);

        if ($data['title'] === '') {
            Session::flash('error', 'Title is required.');
            $this->redirect('/events');
        }

        $imagePath = $existing['image_path'];
        try {
            $newImage = $this->uploader->store(
                $_FILES['image'] ?? [],
                'uploads/events',
                $data['title']
            );
            if ($newImage !== null) {
                $this->uploader->delete($existing['image_path']);
                $imagePath = $newImage;
            }
        } catch (Throwable $e) {
            Session::flash('error', 'Image upload failed: ' . $e->getMessage());
            $this->redirect('/events');
        }

        $row = [
            'title'       => $data['title'],
            'slug'        => $existing['title'] === $data['title']
                ? $existing['slug']
                : $this->model->uniqueSlug($data['title'], (int) $id),
            'description' => $data['description'],
            'image_path'  => $imagePath,
            'event_date'  => $data['event_date'],
            'event_time'  => $data['event_time'],
            'location'    => $data['location'],
            'price'       => $data['price'],
            'capacity'    => $data['capacity'],
            'sort_order'  => $data['sort_order'],
            'is_active'   => $data['is_active'],
        ];

        $this->model->update((int) $id, $row);
        Session::flash('success', 'Event updated successfully.');
        $this->redirect('/events');
    }

    public function destroy(Request $request, string $id): void
    {
        $existing = $this->model->find((int) $id);
        if (!$existing) {
            Session::flash('error', 'Event not found.');
            $this->redirect('/events');
        }

        $this->uploader->delete($existing['image_path']);
        $this->model->delete((int) $id);

        Session::flash('success', 'Event deleted.');
        $this->redirect('/events');
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
        $eventDate = clean((string) $request->input('event_date', ''));
        // Normalize to YYYY-MM-DD or NULL
        $eventDate = $eventDate !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $eventDate)
            ? $eventDate
            : null;

        return [
            'title'       => clean((string) $request->input('title', '')),
            'description' => clean((string) $request->input('description', '')),
            'event_date'  => $eventDate,
            'event_time'  => clean((string) $request->input('event_time', '')),
            'location'    => clean((string) $request->input('location', '')),
            'price'       => clean((string) $request->input('price', '')),
            'capacity'    => clean((string) $request->input('capacity', '')),
            'sort_order'  => (int) $request->input('sort_order', 0),
            'is_active'   => (int) (bool) $request->input('is_active', 1),
        ];
    }
}
