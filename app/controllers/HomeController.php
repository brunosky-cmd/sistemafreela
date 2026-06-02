<?php

class HomeController
{
    public function index(): void
    {
        $titulo = 'Meu Site em PHP';
        $busca = trim($_GET['busca'] ?? '');
        $servicos = (new Service())->all($busca !== '' ? $busca : null);

        view('home/index', compact('titulo', 'busca', 'servicos'));
    }
}
