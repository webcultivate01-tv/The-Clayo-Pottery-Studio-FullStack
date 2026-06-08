<?php
declare(strict_types=1);

namespace Calyo\Services;

use Calyo\Core\Database;
use Calyo\Core\Session;
use Calyo\Models\User;

final class AuthService
{
    public function attempt(string $email, string $password, string $ip, string $userAgent): array
    {
        $users = new User();
        $user  = $users->findByEmail($email);

        if (!$user) {
            $this->audit(null, 'login.failed', $ip, $userAgent, ['email' => $email, 'reason' => 'not_found']);
            return ['ok' => false, 'message' => 'Invalid credentials.'];
        }

        if (!(int) ($user['is_active'] ?? 0)) {
            $this->audit((int) $user['id'], 'login.failed', $ip, $userAgent, ['reason' => 'inactive']);
            return ['ok' => false, 'message' => 'Account is disabled.'];
        }

        if ($users->isLocked($user)) {
            $this->audit((int) $user['id'], 'login.failed', $ip, $userAgent, ['reason' => 'locked']);
            return ['ok' => false, 'message' => 'Too many failed attempts. Try again later.'];
        }

        if (!bcrypt_verify($password, $user['password'])) {
            $users->recordFailedAttempt((int) $user['id']);
            $this->audit((int) $user['id'], 'login.failed', $ip, $userAgent, ['reason' => 'bad_password']);
            return ['ok' => false, 'message' => 'Invalid credentials.'];
        }

        Session::regenerate();
        Session::put('user', [
            'id'    => (int) $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ]);

        $users->updateLastLogin((int) $user['id'], $ip);
        $this->audit((int) $user['id'], 'login.success', $ip, $userAgent);

        return ['ok' => true];
    }

    public function logout(string $ip, string $userAgent): void
    {
        $user = Session::get('user');
        if ($user) {
            $this->audit((int) $user['id'], 'logout', $ip, $userAgent);
        }
        Session::destroy();
    }

    private function audit(?int $userId, string $action, string $ip, string $userAgent, array $meta = []): void
    {
        try {
            $stmt = Database::connection()->prepare(
                'INSERT INTO audit_logs (user_id, action, ip_address, user_agent, meta, created_at)
                 VALUES (:uid, :action, :ip, :ua, :meta, NOW())'
            );
            $stmt->execute([
                'uid'    => $userId,
                'action' => $action,
                'ip'     => $ip,
                'ua'     => $userAgent,
                'meta'   => $meta ? json_encode($meta) : null,
            ]);
        } catch (\Throwable $e) {
            error_log('audit failed: ' . $e->getMessage());
        }
    }
}
