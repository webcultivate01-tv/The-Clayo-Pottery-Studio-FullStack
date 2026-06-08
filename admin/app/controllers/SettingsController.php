<?php
declare(strict_types=1);

namespace Calyo\Controllers;

use Calyo\Core\Controller;
use Calyo\Core\Database;
use Calyo\Core\Request;
use Calyo\Core\Session;
use Calyo\Models\Setting;
use Calyo\Models\User;
use Throwable;

final class SettingsController extends Controller
{
    private User $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function index(Request $request): void
    {
        $me = current_user();
        $fresh = $me ? $this->users->find((int) $me['id']) : null;

        $tab = (string) $request->input('tab', 'profile');
        if (!in_array($tab, ['profile', 'password', 'studio', 'appearance', 'security'], true)) {
            $tab = 'profile';
        }

        $this->view('settings.index', [
            'title'    => 'Settings',
            'tab'      => $tab,
            'me'       => $fresh ?? $me ?? [],
            'settings' => Setting::all(),
            'recent'   => $this->recentActivity((int) ($me['id'] ?? 0)),
        ]);
    }

    public function updateProfile(Request $request): void
    {
        $me = current_user();
        if (!$me) {
            $this->redirect('/login');
        }
        $id = (int) $me['id'];

        $name  = clean((string) $request->input('name', ''));
        $email = clean((string) $request->input('email', ''));
        $phone = clean((string) $request->input('phone', ''));

        if ($name === '' || $email === '') {
            Session::flash('error', 'Name and email are required.');
            $this->redirect('/settings?tab=profile');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Please enter a valid email address.');
            $this->redirect('/settings?tab=profile');
        }

        if ($this->users->emailExists($email, $id)) {
            Session::flash('error', 'That email is already in use by another user.');
            $this->redirect('/settings?tab=profile');
        }

        $this->users->update($id, [
            'name'  => $name,
            'email' => $email,
            'phone' => $phone !== '' ? $phone : null,
        ]);

        $this->refreshSession($id);
        $this->audit($id, 'settings.profile.updated', $request);

        Session::flash('success', 'Profile updated successfully.');
        $this->redirect('/settings?tab=profile');
    }

    public function updatePassword(Request $request): void
    {
        $me = current_user();
        if (!$me) {
            $this->redirect('/login');
        }
        $id = (int) $me['id'];

        $current = (string) $request->input('current_password', '');
        $new     = (string) $request->input('new_password', '');
        $confirm = (string) $request->input('confirm_password', '');

        if ($current === '' || $new === '' || $confirm === '') {
            Session::flash('error', 'All password fields are required.');
            $this->redirect('/settings?tab=password');
        }

        if (strlen($new) < 8) {
            Session::flash('error', 'New password must be at least 8 characters.');
            $this->redirect('/settings?tab=password');
        }

        if ($new !== $confirm) {
            Session::flash('error', 'New password and confirmation do not match.');
            $this->redirect('/settings?tab=password');
        }

        if ($current === $new) {
            Session::flash('error', 'New password must be different from the current one.');
            $this->redirect('/settings?tab=password');
        }

        $row = $this->users->find($id);
        if (!$row || !bcrypt_verify($current, $row['password'])) {
            $this->audit($id, 'settings.password.failed', $request, ['reason' => 'bad_current']);
            Session::flash('error', 'Current password is incorrect.');
            $this->redirect('/settings?tab=password');
        }

        $this->users->update($id, ['password' => bcrypt_hash($new)]);
        Session::regenerate();
        $this->audit($id, 'settings.password.changed', $request);

        Session::flash('success', 'Password changed successfully.');
        $this->redirect('/settings?tab=password');
    }

    public function updateStudio(Request $request): void
    {
        $this->ensureAdmin();

        $name    = clean((string) $request->input('studio_name', ''));
        $email   = clean((string) $request->input('studio_email', ''));
        $phone   = clean((string) $request->input('studio_phone', ''));
        $address = clean((string) $request->input('studio_address', ''));
        $hours   = clean((string) $request->input('studio_hours', ''));
        $about   = clean((string) $request->input('studio_about', ''));

        if ($name === '') {
            Session::flash('error', 'Studio name is required.');
            $this->redirect('/settings?tab=studio');
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::flash('error', 'Please enter a valid studio email address.');
            $this->redirect('/settings?tab=studio');
        }

        Setting::setMany([
            'studio_name'    => $name,
            'studio_email'   => $email,
            'studio_phone'   => $phone,
            'studio_address' => $address,
            'studio_hours'   => $hours,
            'studio_about'   => $about,
        ], 'general');

        $me = current_user();
        $this->audit((int) ($me['id'] ?? 0), 'settings.studio.updated', $request);

        Session::flash('success', 'Studio details saved.');
        $this->redirect('/settings?tab=studio');
    }

    public function updateAppearance(Request $request): void
    {
        $this->ensureAdmin();

        $theme = clean((string) $request->input('theme', 'light'));
        if (!in_array($theme, ['light', 'dark'], true)) {
            $theme = 'light';
        }

        $brandColor = clean((string) $request->input('brand_color', ''));
        if ($brandColor !== '' && !preg_match('/^#([0-9a-f]{6})$/i', $brandColor)) {
            Session::flash('error', 'Brand color must be a valid hex code like #4f46e5.');
            $this->redirect('/settings?tab=appearance');
        }

        Setting::setMany([
            'theme'       => $theme,
            'brand_color' => $brandColor,
        ], 'appearance');

        Session::flash('success', 'Appearance updated.');
        $this->redirect('/settings?tab=appearance');
    }

    // ── helpers ──────────────────────────────────────────────────────────────

    private function ensureAdmin(): void
    {
        if (!user_has_role('admin')) {
            Session::flash('error', 'You do not have permission to change studio settings.');
            $this->redirect('/settings');
        }
    }

    private function refreshSession(int $id): void
    {
        $row = $this->users->find($id);
        if (!$row) return;

        Session::put('user', [
            'id'    => (int) $row['id'],
            'name'  => $row['name'],
            'email' => $row['email'],
            'role'  => $row['role'],
        ]);
    }

    private function recentActivity(int $userId): array
    {
        if ($userId <= 0) return [];

        try {
            $stmt = Database::connection()->prepare(
                'SELECT action, ip_address, user_agent, created_at
                 FROM audit_logs
                 WHERE user_id = :uid
                 ORDER BY created_at DESC
                 LIMIT 8'
            );
            $stmt->execute([':uid' => $userId]);
            return $stmt->fetchAll() ?: [];
        } catch (Throwable $e) {
            return [];
        }
    }

    private function audit(int $userId, string $action, Request $request, array $meta = []): void
    {
        try {
            $stmt = Database::connection()->prepare(
                'INSERT INTO audit_logs (user_id, action, ip_address, user_agent, meta, created_at)
                 VALUES (:uid, :action, :ip, :ua, :meta, NOW())'
            );
            $stmt->execute([
                ':uid'    => $userId > 0 ? $userId : null,
                ':action' => $action,
                ':ip'     => $request->ip(),
                ':ua'     => $request->userAgent(),
                ':meta'   => $meta ? json_encode($meta) : null,
            ]);
        } catch (Throwable $e) {
            error_log('settings audit failed: ' . $e->getMessage());
        }
    }
}
