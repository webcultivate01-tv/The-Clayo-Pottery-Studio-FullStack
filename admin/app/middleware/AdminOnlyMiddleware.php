<?php
declare(strict_types=1);

namespace Calyo\Middleware;

final class AdminOnlyMiddleware extends RoleMiddleware
{
    protected function allowedRoles(): array
    {
        return ['admin'];
    }
}
