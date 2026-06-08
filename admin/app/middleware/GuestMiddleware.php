<?php
declare(strict_types=1);

namespace Calyo\Middleware;

use Calyo\Core\Request;
use Calyo\Core\Response;
use Calyo\Core\Session;

final class GuestMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): void
    {
        if (Session::has('user')) {
            Response::redirect('/dashboard');
        }
    }
}
