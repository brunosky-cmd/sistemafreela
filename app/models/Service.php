<?php

class Service extends BaseModel
{
    public function all(?string $busca = null): array
    {
        $sql = 'SELECT servicos.*, usuarios.email, usuarios.nome
                FROM servicos
                JOIN usuarios ON servicos.usuario_id = usuarios.id';

        if ($busca) {
            $term = '%' . $busca . '%';
            return $this->fetchAll(
                $sql . ' WHERE servicos.titulo LIKE ? OR servicos.categoria LIKE ? OR usuarios.email LIKE ? ORDER BY servicos.data_criacao DESC',
                'sss',
                [$term, $term, $term]
            );
        }

        return $this->fetchAll($sql . ' ORDER BY servicos.data_criacao DESC');
    }

    public function findWithOwner(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT servicos.*, usuarios.nome, usuarios.email
             FROM servicos
             JOIN usuarios ON servicos.usuario_id = usuarios.id
             WHERE servicos.id = ?',
            'i',
            [$id]
        );
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM servicos WHERE id = ?', 'i', [$id]);
    }

    public function byOwner(int $usuarioId): array
    {
        return $this->fetchAll('SELECT * FROM servicos WHERE usuario_id = ? ORDER BY id DESC', 'i', [$usuarioId]);
    }

    public function create(int $usuarioId, array $data): bool
    {
        return $this->execute(
            'INSERT INTO servicos (usuario_id, titulo, descricao, categoria, modalidade, preco, cidade, uf) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            'isssssss',
            [$usuarioId, $data['titulo'], $data['descricao'], $data['categoria'], $data['modalidade'], $data['preco'], $data['cidade'], $data['uf']]
        );
    }

    public function update(int $id, int $usuarioId, array $data): bool
    {
        return $this->execute(
            'UPDATE servicos SET titulo = ?, categoria = ?, modalidade = ?, preco = ?, descricao = ?, cidade = ?, uf = ? WHERE id = ? AND usuario_id = ?',
            'sssssssii',
            [$data['titulo'], $data['categoria'], $data['modalidade'], $data['preco'], $data['descricao'], $data['cidade'], $data['uf'], $id, $usuarioId]
        );
    }

    public function delete(int $id, int $usuarioId): bool
    {
        $this->execute('DELETE FROM candidaturas WHERE servico_id = ?', 'i', [$id]);
        return $this->execute('DELETE FROM servicos WHERE id = ? AND usuario_id = ?', 'ii', [$id, $usuarioId]);
    }

    public function belongsTo(int $id, int $usuarioId): bool
    {
        return (bool) $this->fetchOne('SELECT id FROM servicos WHERE id = ? AND usuario_id = ?', 'ii', [$id, $usuarioId]);
    }
}
