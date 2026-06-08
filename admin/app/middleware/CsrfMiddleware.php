<?php
declare(strict_types=1);

namespace Calyo\Middleware;

use Calyo\Core\App;
use Calyo\Core\Exceptions\HttpException;
use Calyo\Core\Request;

final class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): void
    {
        if (!$request->isPost()) return;

        $name  = App::config('security.csrf_token_name', '_csrf');
        $token = $_POST[$name] ?? null;

        if (!csrf_verify($token)) {
            throw new HttpException(419, 'CSRF token mismatch');
        }
    }
}
