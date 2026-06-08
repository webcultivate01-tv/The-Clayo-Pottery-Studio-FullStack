<?php
declare(strict_types=1);

namespace Calyo\Core;

final class Response
{
    public static function redirect(string $path, int $status = 302): never
    {
        $url = str_starts_with($path, 'http') ? $path : App::basePath($path);
        header('Location: ' . $url, true, $status);
        exit;
    }

    public static function json(mixed $data, int $status = 200): never
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
