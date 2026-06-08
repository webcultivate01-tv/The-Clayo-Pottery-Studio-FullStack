<?php
declare(strict_types=1);

namespace Calyo\Core;

final class Autoloader
{
    private static array $map = [
        'Calyo\\Core\\'        => '/core/',
        'Calyo\\Controllers\\' => '/app/controllers/',
        'Calyo\\Models\\'      => '/app/models/',
        'Calyo\\Middleware\\'  => '/app/middleware/',
        'Calyo\\Services\\'    => '/app/services/',
    ];

    public static function register(): void
    {
        spl_autoload_register([self::class, 'load']);
    }

    public static function load(string $class): void
    {
        foreach (self::$map as $prefix => $dir) {
            if (strpos($class, $prefix) === 0) {
                $relative = substr($class, strlen($prefix));
                $path = ROOT_PATH . $dir . str_replace('\\', '/', $relative) . '.php';
                if (file_exists($path)) {
                    require $path;
                    return;
                }
            }
        }
    }
}
