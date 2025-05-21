<?php
require_once 'RouteMetadata.php';
require_once 'RouteGroup.php';
require_once 'RouteBuilder.php';

class Router {
    private $routes = ['GET' => [], 'POST' => []];

    public function register(string $method, string $path, callable $handler, array & $middleware = []): void {
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        $route = new RouteMetadata($method, $path, $handler, $middleware);
        $this->routes[$method][$path] = $route;
    }

    public function routes(): RouteBuilder
    {
        return new RouteBuilder($this);
    }

    public function group($prefix): RouteGroup
    {
        return new RouteGroup($this, $prefix);
    }



    public function dispatch(): void
    {
        $ctx = new RequestContext();

        // ✅ Normalize trailing slash (except for root)
        if ($ctx->path !== '/' && str_ends_with($ctx->path, '/')) {
            $ctx->path = rtrim($ctx->path, '/');
        }

        foreach ($this->routes[$ctx->method] ?? [] as $routeMeta) {
            $params = [];
            if ($routeMeta->matches($ctx->path, $params)) {
                $routeMeta->execute($params, $ctx);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

}
