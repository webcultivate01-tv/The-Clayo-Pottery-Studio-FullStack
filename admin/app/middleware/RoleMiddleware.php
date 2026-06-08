<?php
declare(strict_types=1);

namespace Calyo\Middleware;

use Calyo\Core\Exceptions\HttpException;
use Calyo\Core\Request;
use Calyo\Core\Session;

abstract class RoleMiddleware implements MiddlewareInterface
{
    abstract protected function allowedRoles(): array;

    public function handle(Request $request): void
    {
        $user = Session::get('user');
        if (!$user || !in_array($user['role'] ?? '', $this->allowedRoles(), true)) {
            throw new HttpException(403, 'Forbidden');
        }
    }
}
