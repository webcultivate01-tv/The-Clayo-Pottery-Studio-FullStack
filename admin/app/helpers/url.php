<?php
declare(strict_types=1);

use Calyo\Core\App;

function url(string $path = ''): string
{
    return App::basePath($path);
}

function asset(string $path): string
{
    return App::basePath('public/' . ltrim($path, '/'));
}

/**
 * URL to a file under the project-root /public folder (one level above the
 * admin app's base path). Used for service/workshop images that are shared
 * with the public website.
 */
function public_url(string $path): string
{
    $base   = rtrim(App::basePath(''), '/');
    $parent = rtrim(str_replace('\\', '/', dirname($base)), '/');
    return $parent . '/public/' . ltrim($path, '/');
}

function old(string $key, ?string $default = ''): string
{
    $old = $_SESSION['_old'][$key] ?? $default;
    return (string) $old;
}

function flash(string $key): ?string
{
    return \Calyo\Core\Session::flash($key);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function user_has_role(string $role): bool
{
    $u = current_user();
    return $u !== null && ($u['role'] ?? null) === $role;
}
