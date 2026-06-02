<?php

class ApplicationController
{
    private Application $applications;
    private Service $services;

    public function __construct()
    {
        $this->applications = new Application();
        $this->services = new Service();
    }

    public function create(): void
    {
        requireUserType('buscador');

        $servicoId = (int) ($_GET['servico_id'] ?? 0);
        $servico = $this->services->find($servicoId);

        if ($servico && (int) $servico['usuario_id'] !== currentUserId()) {
            $this->applications->create($servicoId, currentUserId());
        }

        redirect('/vagas/detalhes?id=' . $servicoId);
    }

    public function index(): void
    {
        if (currentUserType() === 'prestador' && isset($_GET['servico_id'])) {
            $this->forService();
            return;
        }

        $this->mine();
    }

    public function forService(): void
    {
        requireUserType('prestador');

        $servico_id = (int) ($_GET['servico_id'] ?? 0);
        if (!$this->services->belongsTo($servico_id, currentUserId())) {
            http_response_code(403);
            echo 'Você não tem permissão para ver essas candidaturas.';
            return;
        }

        $candidaturas = $this->applications->forService($servico_id);
        view('applications/for_service', compact('candidaturas'));
    }

    public function mine(): void
    {
        requireUserType('buscador');

        $candidaturas = $this->applications->byBuscador(currentUserId());
        view('applications/mine', compact('candidaturas'));
    }

    public function accept(): void
    {
        requireUserType('prestador');
        $this->applications->updateStatusIfOwner((int) ($_GET['id'] ?? 0), currentUserId(), 'aceito');
        back('/vagas/minhas');
    }

    public function reject(): void
    {
        requireUserType('prestador');
        $this->applications->updateStatusIfOwner((int) ($_GET['id'] ?? 0), currentUserId(), 'recusado');
        back('/vagas/minhas');
    }
}
