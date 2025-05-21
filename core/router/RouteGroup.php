<?php
namespace Core\Router;

class RouteGroup extends RouteBuilder {
    private string $prefix;

    public function __construct(Router $router, string $prefix, array $middleware = []) {
        parent::__construct($router);
        $this->prefix = rtrim($prefix, '/');
        $this->sharedMiddleware = $middleware;
    }

    public function get(string $path, callable $handler): static {
        return parent::get($this->prefix . $path, $handler);
    }

    public function post(string $path, callable $handler): static {
        return parent::post($this->prefix . $path, $handler);
    }
}
