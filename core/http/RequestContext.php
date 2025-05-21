<?php
class RequestContext {
    public array|object|int|null $user = null;
    public string $method;
    public string $path;
    public array $headers = [];

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->headers = getallheaders();
    }

    public function json(): ?array {
        $body = file_get_contents('php://input');
        return json_decode($body, true);
    }

    public function query(string $key, $default = null): mixed {
        return $_GET[$key] ?? $default;
    }

    public function form_input(string $key, $default = null): mixed {
        return $_POST[$key] ?? $default;
    }
}