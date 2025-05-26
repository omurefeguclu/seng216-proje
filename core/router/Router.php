<?php
namespace Core\Router;

use Core\Http\RequestContext;

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



    public function dispatch(RequestContext $requestContext): void
    {
        // ✅ Normalize trailing slash (except for root)
        if ($requestContext->path !== '/' && str_ends_with($requestContext->path, '/')) {
            $requestContext->path = rtrim($requestContext->path, '/');
        }

        foreach ($this->routes[$requestContext->method] ?? [] as $routeMeta) {
            $params = [];
            if ($routeMeta->matches($requestContext->path, $params)) {
                $routeMeta->execute($params, $requestContext);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

}
