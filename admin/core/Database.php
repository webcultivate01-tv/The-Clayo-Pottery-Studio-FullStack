<?php
declare(strict_types=1);

namespace Calyo\Core;

use PDO;
use RuntimeException;

final class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $cfg = require ROOT_PATH . '/config/database.php';
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $cfg['host'], $cfg['port'], $cfg['database'], $cfg['charset']
        );

        try {
            self::$pdo = new PDO($dsn, $cfg['username'], $cfg['password'], $cfg['options']);
        } catch (\PDOException $e) {
            throw new RuntimeException('Database connection failed: ' . $e->getMessage(), 0, $e);
        }

        return self::$pdo;
    }
}
