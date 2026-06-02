<?php

class ProfileController
{
    private User $users;

    public function __construct()
    {
        $this->users = new User();
    }

    public function show(): void
    {
        requireLogin();

        $usuario_id_logado = currentUserId();
        $tipo_usuario_logado = currentUserType();
        $id = (int) ($_GET['id'] ?? $usuario_id_logado);
        $usuario = $this->users->findById($id);

        if (!$usuario) {
            http_response_code(404);
            echo 'Perfil não encontrado.';
            return;
        }

        $perfil = $this->users->getProfile($id, $usuario['tipo_usuario']);
        view('profiles/show', compact('usuario', 'perfil', 'usuario_id_logado', 'tipo_usuario_logado', 'id'));
    }

    public function editPrestador(): void
    {
        requireUserType('prestador');

        $usuario_id = currentUserId();
        $mensagem = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->profileData();
            $this->users->updateName($usuario_id, $_POST['nome'] ?? '');
            $ok = $this->users->updatePrestadorProfile($usuario_id, $data);
            $_SESSION['nome'] = $_POST['nome'] ?? '';
            $mensagem = $ok ? 'Perfil atualizado com sucesso!' : 'Erro ao atualizar o perfil.';
        }

        $dados = $this->users->getProfile($usuario_id, 'prestador');
        $usuario_nome = $this->users->findById($usuario_id)['nome'] ?? '';
        view('profiles/edit_prestador', compact('mensagem', 'dados', 'usuario_nome', 'usuario_id'));
    }

    public function edit(): void
    {
        if (currentUserType() === 'prestador') {
            $this->editPrestador();
            return;
        }

        $this->editBuscador();
    }

    public function editBuscador(): void
    {
        requireUserType('buscador');

        $usuario_id = currentUserId();
        $msg = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->profileData() + [
                'trabalho' => $_POST['trabalho'] ?? '',
                'valor_hora' => $_POST['valor_hora'] ?? '',
                'salario' => $_POST['salario'] ?? '',
            ];
            $this->users->updateName($usuario_id, $_POST['nome'] ?? '');
            $ok = $this->users->updateBuscadorProfile($usuario_id, $data);
            $_SESSION['nome'] = $_POST['nome'] ?? '';
            $msg = $ok ? 'Perfil atualizado com sucesso!' : 'Erro ao atualizar.';
        }

        $perfil = $this->users->getProfile($usuario_id, 'buscador');
        $usuario_nome = $this->users->findById($usuario_id)['nome'] ?? '';
        view('profiles/edit_buscador', compact('msg', 'perfil', 'usuario_nome', 'usuario_id'));
    }

    public function delete(): void
    {
        requireLogin();

        $this->users->delete(currentUserId());
        session_destroy();
        redirect('/home');
    }

    private function profileData(): array
    {
        return [
            'telefone' => $_POST['telefone'] ?? '',
            'cep' => $_POST['cep'] ?? '',
            'rua' => $_POST['rua'] ?? '',
            'bairro' => $_POST['bairro'] ?? '',
            'cidade' => $_POST['cidade'] ?? '',
            'categoria' => $_POST['categoria'] ?? '',
            'quem_sou' => $_POST['quem_sou'] ?? '',
        ];
    }
}
