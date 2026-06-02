<?php

class Application extends BaseModel
{
    public function statusForServiceAndUser(int $servicoId, int $buscadorId): string
    {
        $row = $this->fetchOne(
            'SELECT status FROM candidaturas WHERE servico_id = ? AND buscador_id = ?',
            'ii',
            [$servicoId, $buscadorId]
        );

        return $row['status'] ?? '';
    }

    public function create(int $servicoId, int $buscadorId): bool
    {
        if ($this->statusForServiceAndUser($servicoId, $buscadorId) !== '') {
            return true;
        }

        return $this->execute(
            'INSERT INTO candidaturas (servico_id, buscador_id) VALUES (?, ?)',
            'ii',
            [$servicoId, $buscadorId]
        );
    }

    public function forService(int $servicoId): array
    {
        return $this->fetchAll(
            'SELECT c.id, c.status, u.id as buscador_id, u.nome, u.email,
                    p.quem_sou, p.cidade, p.valor_hora, p.salario
             FROM candidaturas c
             JOIN usuarios u ON c.buscador_id = u.id
             LEFT JOIN perfil_buscador p ON p.usuario_id = u.id
             WHERE c.servico_id = ?
             ORDER BY c.data_candidatura DESC',
            'i',
            [$servicoId]
        );
    }

    public function byBuscador(int $buscadorId): array
    {
        return $this->fetchAll(
            'SELECT candidaturas.status,
                    servicos.id as servico_id,
                    servicos.titulo,
                    servicos.cidade,
                    servicos.uf,
                    servicos.modalidade,
                    usuarios.nome as prestador_nome,
                    usuarios.id as prestador_id
             FROM candidaturas
             JOIN servicos ON candidaturas.servico_id = servicos.id
             JOIN usuarios ON servicos.usuario_id = usuarios.id
             WHERE candidaturas.buscador_id = ?
             ORDER BY candidaturas.id DESC',
            'i',
            [$buscadorId]
        );
    }

    public function updateStatusIfOwner(int $candidaturaId, int $prestadorId, string $status): bool
    {
        return $this->execute(
            'UPDATE candidaturas c
             JOIN servicos s ON c.servico_id = s.id
             SET c.status = ?
             WHERE c.id = ? AND s.usuario_id = ?',
            'sii',
            [$status, $candidaturaId, $prestadorId]
        );
    }
}
