<?php

function startSession(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function basePath(): string
{
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $base = rtrim(str_replace('/index.php', '', $scriptName), '/');
    return $base === '' ? '' : $base;
}

function url(string $path = ''): string
{
    if (preg_match('#^(https?://|mailto:|tel:)#', $path)) {
        return $path;
    }

    if ($path === '') {
        return basePath() ?: '/';
    }

    if ($path[0] !== '/') {
        $path = '/' . $path;
    }

    return basePath() . $path;
}

function asset(string $path): string
{
    return url('/assets/' . ltrim($path, '/'));
}

function redirect(string $url): void
{
    header('Location: ' . url($url));
    exit;
}

function back(string $fallback = '/home'): void
{
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? url($fallback)));
    exit;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function currentUserId(): ?int
{
    startSession();
    return isset($_SESSION['usuario_id']) ? (int) $_SESSION['usuario_id'] : null;
}

function currentUserType(): ?string
{
    startSession();
    return $_SESSION['tipo_usuario'] ?? null;
}

function requireLogin(): void
{
    if (!currentUserId()) {
        redirect('/login');
    }
}

function requireUserType(string $type): void
{
    requireLogin();

    if (currentUserType() !== $type) {
        http_response_code(403);
        echo 'Acesso permitido apenas para ' . e($type) . 'es.';
        exit;
    }
}

function view(string $template, array $data = []): void
{
    extract($data);
    require __DIR__ . '/../views/' . $template . '.php';
}

function modalidadeBanco(string $value): string
{
    return $value;
}

function modalidadeLabel(?string $value): string
{
    return $value ?? '';
}
