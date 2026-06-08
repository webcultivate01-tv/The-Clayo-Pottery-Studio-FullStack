<?php
declare(strict_types=1);

namespace Calyo\Models;

use Calyo\Core\Database;

final class Setting
{
    public static function all(): array
    {
        $rows = Database::connection()
            ->query('SELECT key_name, value, group_name FROM settings')
            ->fetchAll();

        $out = [];
        foreach ($rows as $r) {
            $out[$r['key_name']] = $r['value'];
        }
        return $out;
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $stmt = Database::connection()->prepare(
            'SELECT value FROM settings WHERE key_name = :k LIMIT 1'
        );
        $stmt->execute([':k' => $key]);
        $v = $stmt->fetchColumn();
        return ($v === false || $v === null) ? $default : (string) $v;
    }

    public static function set(string $key, ?string $value, string $group = 'general'): void
    {
        $stmt = Database::connection()->prepare(
            'INSERT INTO settings (key_name, value, group_name)
             VALUES (:k, :v, :g)
             ON DUPLICATE KEY UPDATE value = VALUES(value), group_name = VALUES(group_name)'
        );
        $stmt->execute([':k' => $key, ':v' => $value, ':g' => $group]);
    }

    public static function setMany(array $pairs, string $group = 'general'): void
    {
        foreach ($pairs as $k => $v) {
            self::set((string) $k, $v === null ? null : (string) $v, $group);
        }
    }
}
