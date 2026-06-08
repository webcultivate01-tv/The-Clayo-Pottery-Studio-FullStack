<?php
declare(strict_types=1);

namespace Calyo\Core;

use PDO;

abstract class Model
{
    protected string $table = '';
    protected string $primaryKey = 'id';

    protected function db(): PDO
    {
        return Database::connection();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function all(string $orderBy = 'id DESC'): array
    {
        $stmt = $this->db()->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $cols = array_keys($data);
        $placeholders = array_map(fn($c) => ':' . $c, $cols);
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(',', $cols),
            implode(',', $placeholders)
        );
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($data);
        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $set = implode(',', array_map(fn($c) => "$c = :$c", array_keys($data)));
        $sql = "UPDATE {$this->table} SET {$set} WHERE {$this->primaryKey} = :_pk";
        $stmt = $this->db()->prepare($sql);
        $data['_pk'] = $id;
        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        return $stmt->execute(['id' => $id]);
    }
}
