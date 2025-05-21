<?php
require_once __DIR__.'/../http/RequestContext.php';

class RouteMetadata {
    public string $method;
    public string $path;
    public $handler;
    public array $middleware;


    private string $pattern;
    private array $paramNames = [];

    public function __construct(string $method, string $path, callable $handler, array &$middleware = []) {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
        $this->middleware = &$middleware;

        $this->compilePattern($path);
    }

    private function compilePattern($path) {
        // Replace {param} with regex capture group and store param names
        $pattern = preg_replace_callback('/\{(\w+)\}/', function($matches) {
            $this->paramNames[] = $matches[1];
            return '([^\/]+)';
        }, preg_quote($path, '/'));

        $this->pattern = '/^' . $pattern . '$/';
    }

    public function matches(string $uri, array &$paramsOut): bool {
        if (preg_match($this->pattern, $uri, $matches)) {
            array_shift($matches); // first element is full match
            $paramsOut = array_combine($this->paramNames, $matches);
            return true;
        }
        return false;
    }

    public function execute(array $params = [], RequestContext $ctx) {

        foreach ($this->middleware as $mw) {
            if (!$mw($ctx)) {
                return;
            }
        }

        $ref = new ReflectionFunction($this->handler);
        $args = [];

        foreach ($ref->getParameters() as $param) {
            $name = $param->getName();

            // Match against route param first, then fallback to context
            if (array_key_exists($name, $params)) {
                $args[] = $params[$name];
            } else {
                $args[] = $ctx; // default: pass RequestContext
            }
        }

        echo $ref->invokeArgs($args);

    }
}
