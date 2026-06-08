<?php
declare(strict_types=1);

namespace Calyo\Core;

final class Session
{
    public static function start(array $config): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;

        session_name($config['name']);
        session_set_cookie_params([
            'lifetime' => $config['lifetime'],
            'path'     => '/',
            'secure'   => $config['cookie_secure'],
            'httponly' => $config['cookie_httponly'],
            'samesite' => $config['cookie_samesite'],
        ]);
        session_start();

        if (!isset($_SESSION['_started_at'])) {
            $_SESSION['_started_at'] = time();
            session_regenerate_id(true);
        }
    }

    public static function put(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash(string $key, ?string $value = null): ?string
    {
        if ($value !== null) {
            $_SESSION['_flash'][$key] = $value;
            return null;
        }
        $msg = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }

    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    public static function destroy(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }
}
