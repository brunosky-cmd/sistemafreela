<?php

return [
    'GET' => [
        '/' => [HomeController::class, 'index'],
        '/home' => [HomeController::class, 'index'],
        '/vagas' => [HomeController::class, 'index'],

        '/login' => [AuthController::class, 'login'],
        '/cadastro' => [AuthController::class, 'register'],
        '/logout' => [AuthController::class, 'logout'],

        '/vagas/criar' => [ServiceController::class, 'create'],
        '/vagas/editar' => [ServiceController::class, 'edit'],
        '/vagas/excluir' => [ServiceController::class, 'delete'],
        '/vagas/detalhes' => [ServiceController::class, 'show'],
        '/vagas/minhas' => [ServiceController::class, 'mine'],

        '/candidaturas' => [ApplicationController::class, 'index'],
        '/candidaturas/criar' => [ApplicationController::class, 'create'],
        '/candidaturas/aceitar' => [ApplicationController::class, 'accept'],
        '/candidaturas/cancelar' => [ApplicationController::class, 'reject'],
        '/candidaturas/recusar' => [ApplicationController::class, 'reject'],
        '/candidaturas/finalizar' => static function (): void {
            http_response_code(404);
            echo 'Funcionalidade de finalizar candidatura nao implementada.';
        },

        '/perfil' => [ProfileController::class, 'show'],
        '/perfil/editar' => [ProfileController::class, 'edit'],
        '/perfil/excluir' => [ProfileController::class, 'delete'],

        '/notificacoes' => static function (): void {
            http_response_code(404);
            echo 'Funcionalidade de notificacoes nao implementada.';
        },
        '/avaliacoes' => static function (): void {
            http_response_code(404);
            echo 'Funcionalidade de avaliacoes nao implementada.';
        },
        '/admin' => static function (): void {
            http_response_code(404);
            echo 'Area administrativa nao implementada.';
        },
        '/admin/usuarios' => static function (): void {
            http_response_code(404);
            echo 'Administracao de usuarios nao implementada.';
        },
        '/admin/vagas' => static function (): void {
            http_response_code(404);
            echo 'Administracao de vagas nao implementada.';
        },
        '/admin/relatorios' => static function (): void {
            http_response_code(404);
            echo 'Relatorios administrativos nao implementados.';
        },
    ],
    'POST' => [
        '/login' => [AuthController::class, 'login'],
        '/cadastro' => [AuthController::class, 'register'],
        '/vagas/criar' => [ServiceController::class, 'create'],
        '/vagas/editar' => [ServiceController::class, 'edit'],
        '/perfil/editar' => [ProfileController::class, 'edit'],
    ],
];
