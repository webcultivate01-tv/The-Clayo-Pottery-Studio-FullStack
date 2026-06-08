<?php
declare(strict_types=1);

namespace Calyo\Middleware;

use Calyo\Core\Request;
use Calyo\Core\Response;
use Calyo\Core\Session;

final class AuthMiddleware implements MiddlewareInterface
{
    public function handle(Request $request): void
    {
        if (!Session::has('user')) {
            Session::flash('error', 'Please log in to continue.');
            Response::redirect('/login');
        }
    }
}
