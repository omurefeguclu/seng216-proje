<?php
namespace Core\Http;

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
        if (
            !isset($this->headers['Content-Type']) ||
            stripos($this->headers['Content-Type'], 'application/json') === false
        ) {
            return null;
        }

        $body = file_get_contents('php://input');
        if (empty($body)) return null;

        $json = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo 'Invalid JSON';
            return null;
        }

        return $json;
    }

    public function query(string $key, $default = null): mixed {
        return $_GET[$key] ?? $default;
    }

    public function form_input(string $key, $default = null): mixed {
        return $_POST[$key] ?? $default;
    }
}