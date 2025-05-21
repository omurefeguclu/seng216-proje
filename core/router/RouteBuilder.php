<?php
class RouteBuilder {
    protected Router $router;
    protected array $sharedMiddleware = [];

    public function __construct(Router $router) {
        $this->router = $router;
    }

    public function middleware(array $middleware): static {
        foreach ($middleware as $m) {
            $this->sharedMiddleware[] = $m;
        }
        return $this;
    }

    public function get(string $path, callable $handler): static {
        $this->router->register('GET', $path, $handler, $this->sharedMiddleware);
        return $this;
    }

    public function post(string $path, callable $handler): static {
        $this->router->register('POST', $path, $handler, $this->sharedMiddleware);
        return $this;
    }

    // Add put(), delete(), etc. as needed
}
