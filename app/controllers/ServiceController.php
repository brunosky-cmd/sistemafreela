<?php

class ServiceController
{
    private Service $services;
    private Application $applications;

    public function __construct()
    {
        $this->services = new Service();
        $this->applications = new Application();
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $servico = $this->services->findWithOwner($id);

        if (!$servico) {
            http_response_code(404);
            echo 'Serviço não encontrado.';
            return;
        }

        $candidatura_status = '';
        if (currentUserId() && currentUserType() === 'buscador') {
            $candidatura_status = $this->applications->statusForServiceAndUser($id, currentUserId());
        }

        view('services/show', compact('servico', 'candidatura_status'));
    }

    public function create(): void
    {
        requireUserType('prestador');

        $mensagem = '';
        $tipo_mensagem = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ok = $this->services->create(currentUserId(), $this->serviceData());
            $mensagem = $ok ? 'Serviço publicado com sucesso!' : 'Erro ao publicar serviço.';
            $tipo_mensagem = $ok ? 'sucesso' : 'erro';
        }

        view('services/create', compact('mensagem', 'tipo_mensagem'));
    }

    public function mine(): void
    {
        requireUserType('prestador');

        $servicos = $this->services->byOwner(currentUserId());
        view('services/mine', compact('servicos'));
    }

    public function edit(): void
    {
        requireUserType('prestador');

        $id = (int) ($_GET['id'] ?? 0);
        $servico = $this->services->find($id);

        if (!$servico || (int) $servico['usuario_id'] !== currentUserId()) {
            http_response_code(403);
            echo 'Você não tem permissão para editar este serviço.';
            return;
        }

        $mensagem = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->serviceData();
            $ok = $this->services->update($id, currentUserId(), $data);
            $mensagem = $ok ? 'Serviço atualizado!' : 'Erro ao atualizar.';
            $servico = array_merge($servico, $data);
        }

        view('services/edit', compact('servico', 'mensagem'));
    }

    public function delete(): void
    {
        requireUserType('prestador');

        $this->services->delete((int) ($_GET['id'] ?? 0), currentUserId());
        redirect('/vagas/minhas');
    }

    private function serviceData(): array
    {
        return [
            'titulo' => $_POST['titulo'] ?? '',
            'descricao' => $_POST['descricao'] ?? '',
            'categoria' => $_POST['categoria'] ?? '',
            'modalidade' => modalidadeBanco($_POST['modalidade'] ?? ''),
            'preco' => $_POST['preco'] ?? '',
            'cidade' => $_POST['cidade'] ?? '',
            'uf' => $_POST['uf'] ?? '',
        ];
    }
}
