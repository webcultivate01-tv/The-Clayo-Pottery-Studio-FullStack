<?php
declare(strict_types=1);

namespace Calyo\Core;

use Calyo\Core\Exceptions\HttpException;

final class Router
{
    /** @var array<int, array{method:string,path:string,handler:array{0:string,1:string},middleware:array<int,string>}> */
    private array $routes = [];

    public function get(string $path, array $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, array $handler, array $middleware): void
    {
        $this->routes[] = [
            'method'     => $method,
            'path'       => '/' . trim($path, '/'),
            'handler'    => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(Request $request): void
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method) continue;
            $params = [];
            if (!$this->matches($route['path'], $request->path, $params)) continue;

            foreach ($route['middleware'] as $mwClass) {
                /** @var \Calyo\Middleware\MiddlewareInterface $mw */
                $mw = new $mwClass();
                $mw->handle($request);
            }

            [$controllerClass, $action] = $route['handler'];
            $controller = new $controllerClass();
            $controller->$action($request, ...array_values($params));
            return;
        }

        throw new HttpException(404, 'Not Found');
    }

    private function matches(string $pattern, string $path, array &$params): bool
    {
        $regex = preg_replace('#\{([a-zA-Z_]+)\}#', '(?P<$1>[^/]+)', $pattern);
        if (!preg_match('#^' . $regex . '$#', $path, $matches)) {
            return false;
        }
        foreach ($matches as $k => $v) {
            if (!is_int($k)) $params[$k] = $v;
        }
        return true;
    }
}
