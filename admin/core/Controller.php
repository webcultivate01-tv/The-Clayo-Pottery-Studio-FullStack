<?php
declare(strict_types=1);

namespace Calyo\Core;

abstract class Controller
{
    protected function view(string $view, array $data = [], ?string $layout = 'app'): void
    {
        View::display($view, $data, $layout);
    }

    protected function redirect(string $path, int $status = 302): never
    {
        Response::redirect($path, $status);
    }

    protected function json(mixed $data, int $status = 200): never
    {
        Response::json($data, $status);
    }

    protected function back(): never
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? App::basePath('/');
        Response::redirect($referer);
    }
}
