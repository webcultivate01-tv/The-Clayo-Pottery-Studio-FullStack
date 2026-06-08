<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Model;

final class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updateLastLogin(int $id, string $ip): void
    {
        $stmt = $this->db()->prepare(
            'UPDATE users SET last_login_at = NOW(), last_login_ip = :ip, failed_attempts = 0 WHERE id = :id'
        );
        $stmt->execute(['ip' => $ip, 'id' => $id]);
    }

    public function recordFailedAttempt(int $id): void
    {
        $stmt = $this->db()->prepare(
            'UPDATE users SET failed_attempts = failed_attempts + 1, last_failed_at = NOW() WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
    }

    public function isLocked(array $user): bool
    {
        $max     = \Calyo\Core\App::config('security.login_max_attempts', 5);
        $lockout = \Calyo\Core\App::config('security.login_lockout_seconds', 900);
        if (($user['failed_attempts'] ?? 0) < $max) return false;
        $last = strtotime($user['last_failed_at'] ?? '1970-01-01');
        return (time() - $last) < $lockout;
    }

    public function paginate(array $f, int $page, int $perPage = 20): array
    {
        [$where, $params] = $this->buildWhere($f);
        $offset = max(0, ($page - 1) * $perPage);

        $countStmt = $this->db()->prepare("SELECT COUNT(*) FROM users $where");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $stmt = $this->db()->prepare(
            "SELECT id, name, email, role, is_active, phone, last_login_at, created_at
             FROM users $where ORDER BY created_at DESC LIMIT $perPage OFFSET $offset"
        );
        $stmt->execute($params);

        return [
            'data'     => $stmt->fetchAll(),
            'total'    => $total,
            'pages'    => max(1, (int) ceil($total / $perPage)),
            'page'     => $page,
            'per_page' => $perPage,
        ];
    }

    public function emailExists(string $email, ?int $exceptId = null): bool
    {
        $sql = 'SELECT id FROM users WHERE email = :email';
        $params = ['email' => $email];
        if ($exceptId !== null) {
            $sql .= ' AND id <> :id';
            $params['id'] = $exceptId;
        }
        $stmt = $this->db()->prepare($sql . ' LIMIT 1');
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    private function buildWhere(array $f): array
    {
        $cond   = [];
        $params = [];

        if (!empty($f['search'])) {
            $cond[] = '(name LIKE :s1 OR email LIKE :s2 OR phone LIKE :s3)';
            $term   = '%' . $f['search'] . '%';
            $params += [':s1' => $term, ':s2' => $term, ':s3' => $term];
        }
        if (!empty($f['role'])) {
            $cond[]         = 'role = :role';
            $params[':role'] = $f['role'];
        }
        if ($f['is_active'] !== '' && $f['is_active'] !== null) {
            $cond[]            = 'is_active = :is_active';
            $params[':is_active'] = (int) $f['is_active'];
        }

        $where = $cond ? 'WHERE ' . implode(' AND ', $cond) : '';
        return [$where, $params];
    }

    public static function initials(array $u): string
    {
        $parts = preg_split('/\s+/', trim($u['name'] ?? ''));
        $first = strtoupper(substr($parts[0] ?? '', 0, 1));
        $last  = strtoupper(substr($parts[1] ?? '', 0, 1));
        return ($first . $last) ?: 'US';
    }
}
