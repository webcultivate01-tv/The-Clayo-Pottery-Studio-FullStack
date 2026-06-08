<?php
declare(strict_types=1);

use Calyo\Core\App;
use Calyo\Core\Session;

function csrf_token(): string
{
    $token = Session::get('_csrf_token');
    if (!$token) {
        $token = bin2hex(random_bytes(32));
        Session::put('_csrf_token', $token);
    }
    return $token;
}

function csrf_field(): string
{
    $name = App::config('security.csrf_token_name', '_csrf');
    return '<input type="hidden" name="' . e($name) . '" value="' . e(csrf_token()) . '">';
}

function csrf_verify(?string $token): bool
{
    $session = Session::get('_csrf_token');
    return is_string($token) && is_string($session) && hash_equals($session, $token);
}
