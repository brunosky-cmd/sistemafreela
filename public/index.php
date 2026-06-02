<?php

require_once __DIR__ . '/../app/core/bootstrap.php';

$routes = require __DIR__ . '/../routes/web.php';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$basePath = basePath();

if ($basePath !== '' && strpos($requestPath, $basePath) === 0) {
    $requestPath = substr($requestPath, strlen($basePath)) ?: '/';
}

if ($requestPath === '/index.php') {
    $requestPath = '/';
}

$requestPath = '/' . trim($requestPath, '/');
$requestPath = $requestPath === '//' ? '/' : $requestPath;

$handler = $routes[$method][$requestPath] ?? $routes['GET'][$requestPath] ?? null;

if ($handler === null) {
    http_response_code(404);
    echo 'Rota nao encontrada.';
    exit;
}

if (is_array($handler)) {
    [$controller, $action] = $handler;
    (new $controller())->$action();
    exit;
}

$handler();
