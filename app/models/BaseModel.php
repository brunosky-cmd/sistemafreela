<?php

abstract class BaseModel
{
    protected mysqli $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    protected function fetchAll(string $sql, string $types = '', array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return [];
        }

        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    protected function fetchOne(string $sql, string $types = '', array $params = []): ?array
    {
        $rows = $this->fetchAll($sql, $types, $params);
        return $rows[0] ?? null;
    }

    protected function execute(string $sql, string $types = '', array $params = []): bool
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }

        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }

        return $stmt->execute();
    }
}
