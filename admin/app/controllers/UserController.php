<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\User;

final class UserController extends Controller
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index(Request $request): void
    {
        $filters = $this->readFilters($request);
        $page    = max(1, (int) $request->input('page', 1));
        $result  = $this->model->paginate($filters, $page);

        $this->view('users.index', [
            'title'   => 'Admin Management',
            'result'  => $result,
            'filters' => $filters,
        ]);
    }

    public function store(Request $request): void
    {
        $data = $this->readInput($request);

        if ($data['name'] === '' || $data['email'] === '') {
            Session::flash('error', 'Name and email are required.');
            $this->redirect('/users');
        }

        $password = (string) $request->input('password', '');
        if (strlen($password) < 8) {
            Session::flash('error', 'Password must be at least 8 characters.');
            $this->redirect('/users');
        }

        if ($this->model->emailExists($data['email'])) {
            Session::flash('error', 'A user with that email already exists.');
            $this->redirect('/users');
        }

        $data['password'] = password_hash($password, PASSWORD_BCRYPT);

        $this->model->create($data);
        Session::flash('success', 'Admin user added successfully.');
        $this->redirect('/users');
    }

    public function update(Request $request, string $id): void
    {
        $userId = (int) $id;
        $user   = $this->model->find($userId);
        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('/users');
        }

        $data = $this->readInput($request);

        if ($data['name'] === '' || $data['email'] === '') {
            Session::flash('error', 'Name and email are required.');
            $this->redirect('/users');
        }

        if ($this->model->emailExists($data['email'], $userId)) {
            Session::flash('error', 'Another user already uses that email.');
            $this->redirect('/users');
        }

        // Prevent an admin from demoting / deactivating themselves
        $current = current_user();
        if ($current && (int) $current['id'] === $userId) {
            $data['role']      = 'admin';
            $data['is_active'] = 1;
        }

        $password = (string) $request->input('password', '');
        if ($password !== '') {
            if (strlen($password) < 8) {
                Session::flash('error', 'Password must be at least 8 characters.');
                $this->redirect('/users');
            }
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->model->update($userId, $data);
        Session::flash('success', 'User updated successfully.');
        $this->redirect('/users');
    }

    public function destroy(Request $request, string $id): void
    {
        $userId = (int) $id;
        $user   = $this->model->find($userId);
        if (!$user) {
            Session::flash('error', 'User not found.');
            $this->redirect('/users');
        }

        $current = current_user();
        if ($current && (int) $current['id'] === $userId) {
            Session::flash('error', 'You cannot delete your own account.');
            $this->redirect('/users');
        }

        $this->model->delete($userId);
        Session::flash('success', 'User deleted.');
        $this->redirect('/users');
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function readFilters(Request $request): array
    {
        return [
            'search'    => clean((string) $request->input('search', '')),
            'role'      => clean((string) $request->input('role', '')),
            'is_active' => clean((string) $request->input('is_active', '')),
        ];
    }

    private function readInput(Request $request): array
    {
        $role = clean((string) $request->input('role', 'staff'));
        if (!in_array($role, ['admin', 'staff'], true)) {
            $role = 'staff';
        }

        return [
            'name'      => clean((string) $request->input('name', '')),
            'email'     => clean((string) $request->input('email', '')),
            'phone'     => clean((string) $request->input('phone', '')),
            'role'      => $role,
            'is_active' => (int) (bool) $request->input('is_active', 1),
        ];
    }
}
