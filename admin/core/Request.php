<?php
declare(strict_types=1);

namespace Calyo\Core;

final class Request
{
    public string $method;
    public string $path;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $uri  = $_SERVER['REQUEST_URI'] ?? '/';
        $base = App::config('base_path', '');
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        if ($base && strpos($path, $base) === 0) {
            $path = substr($path, strlen($base));
        }
        $this->path = '/' . trim($path, '/');
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($_GET, $_POST);
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function ip(): string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }

    public function userAgent(): string
    {
        return substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255);
    }
}
