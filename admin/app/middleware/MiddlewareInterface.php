<?php
declare(strict_types=1);

namespace Calyo\Middleware;

use Calyo\Core\Request;

interface MiddlewareInterface
{
    public function handle(Request $request): void;
}
