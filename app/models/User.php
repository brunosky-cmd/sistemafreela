<?php

class User extends BaseModel
{
    public function findByEmailAndPassword(string $email, string $senha): ?array
    {
        return $this->fetchOne(
            'SELECT * FROM usuarios WHERE email = ? AND senha = ?',
            'ss',
            [$email, $senha]
        );
    }

    public function findById(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM usuarios WHERE id = ?', 'i', [$id]);
    }

    public function create(array $data): ?int
    {
        $ok = $this->execute(
            'INSERT INTO usuarios (email, nome, senha, tipo_usuario) VALUES (?, ?, ?, ?)',
            'ssss',
            [$data['email'], '', $data['senha'], $data['tipo_usuario']]
        );

        return $ok ? $this->db->insert_id : null;
    }

    public function updateName(int $id, string $nome): bool
    {
        return $this->execute('UPDATE usuarios SET nome = ? WHERE id = ?', 'si', [$nome, $id]);
    }

    public function createBuscadorProfile(int $usuarioId, array $data): bool
    {
        return $this->execute(
            'INSERT INTO perfil_buscador (usuario_id, cep, telefone, trabalho) VALUES (?, ?, ?, ?)',
            'isss',
            [$usuarioId, $data['cep'], $data['telefone'], $data['trabalho']]
        );
    }

    public function createPrestadorProfile(int $usuarioId, array $data): bool
    {
        return $this->execute(
            'INSERT INTO perfil_prestador (usuario_id, trabalho) VALUES (?, ?)',
            'is',
            [$usuarioId, $data['trabalho']]
        );
    }

    public function getProfile(int $usuarioId, string $tipoUsuario): array
    {
        $table = $tipoUsuario === 'prestador' ? 'perfil_prestador' : 'perfil_buscador';
        return $this->fetchOne("SELECT * FROM {$table} WHERE usuario_id = ?", 'i', [$usuarioId]) ?? [];
    }

    public function updatePrestadorProfile(int $usuarioId, array $data): bool
    {
        return $this->execute(
            'UPDATE perfil_prestador SET telefone = ?, cep = ?, rua = ?, bairro = ?, cidade = ?, quem_sou = ?, categoria = ? WHERE usuario_id = ?',
            'sssssssi',
            [$data['telefone'], $data['cep'], $data['rua'], $data['bairro'], $data['cidade'], $data['quem_sou'], $data['categoria'], $usuarioId]
        );
    }

    public function updateBuscadorProfile(int $usuarioId, array $data): bool
    {
        return $this->execute(
            'UPDATE perfil_buscador SET telefone = ?, cep = ?, rua = ?, bairro = ?, cidade = ?, categoria = ?, quem_sou = ?, trabalho = ?, valor_hora = ?, salario = ? WHERE usuario_id = ?',
            'ssssssssssi',
            [$data['telefone'], $data['cep'], $data['rua'], $data['bairro'], $data['cidade'], $data['categoria'], $data['quem_sou'], $data['trabalho'], $data['valor_hora'], $data['salario'], $usuarioId]
        );
    }

    public function delete(int $usuarioId): bool
    {
        $this->execute('DELETE FROM avaliacoes WHERE avaliador_id = ? OR avaliado_id = ?', 'ii', [$usuarioId, $usuarioId]);
        $this->execute('DELETE FROM candidaturas WHERE buscador_id = ?', 'i', [$usuarioId]);
        $this->execute('DELETE c FROM candidaturas c JOIN servicos s ON c.servico_id = s.id WHERE s.usuario_id = ?', 'i', [$usuarioId]);
        $this->execute('DELETE FROM servicos WHERE usuario_id = ?', 'i', [$usuarioId]);
        $this->execute('DELETE FROM perfil_prestador WHERE usuario_id = ?', 'i', [$usuarioId]);
        $this->execute('DELETE FROM perfil_buscador WHERE usuario_id = ?', 'i', [$usuarioId]);
        return $this->execute('DELETE FROM usuarios WHERE id = ?', 'i', [$usuarioId]);
    }
}
