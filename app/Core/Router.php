<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, array $handler): void
    {
        $this->routes[$method][rtrim($path, '/') ?: '/'] = $handler;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $path = $request->path();
        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            http_response_code(404);
            view('pages/404', ['meta' => default_meta('Page Not Found')]);
            return;
        }

        [$class, $action] = $handler;
        (new $class($request, new Response()))->$action();
    }
}
