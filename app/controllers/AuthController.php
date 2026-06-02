<?php

class AuthController
{
    public function login(): void
    {
        $mensagem = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = (new User())->findByEmailAndPassword($_POST['email'] ?? '', $_POST['senha'] ?? '');

            if ($user) {
                $_SESSION['usuario_id'] = $user['id'];
                $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['nome'] = $user['nome'] ?? '';
                redirect('/home');
            }

            $mensagem = 'Email ou senha incorretos.';
        }

        view('auth/login', compact('mensagem'));
    }

    public function register(): void
    {
        $mensagem = '';
        $sucesso = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'email' => $_POST['email'] ?? '',
                'senha' => $_POST['senha'] ?? '',
                'tipo_usuario' => $_POST['tipo_usuario'] ?? '',
                'telefone' => $_POST['telefone'] ?? '',
                'cep' => $_POST['cep'] ?? '',
                'trabalho' => $_POST['trabalho'] ?? '',
            ];

            $model = new User();
            $usuarioId = $model->create($data);

            if ($usuarioId) {
                $ok = $data['tipo_usuario'] === 'buscador'
                    ? $model->createBuscadorProfile($usuarioId, $data)
                    : $model->createPrestadorProfile($usuarioId, $data);

                $mensagem = $ok
                    ? 'Conta criada com sucesso! Seus dados foram registrados no banco de dados.'
                    : 'Conta criada, mas houve erro ao registrar o perfil.';
                $sucesso = $ok;
            } else {
                $mensagem = 'Erro ao cadastrar.';
            }
        }

        view('auth/register', compact('mensagem', 'sucesso'));
    }

    public function logout(): void
    {
        session_destroy();
        redirect('/home');
    }
}
