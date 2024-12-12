<?php

declare(strict_types=1);

namespace app;

class DB
{
    private readonly \PDO $connection;

    public function __construct()
    {
        $this->connection = new \PDO(
            'mysql:host=db;dbname=' . getenv('MYSQL_DATABASE'),
            'root',
            getenv('MYSQL_ROOT_PASSWORD'),
        );
    }

    public function getFile(int $id): ?array
    {
        $stmt = $this->connection->prepare('SELECT * FROM files WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertFile(string $name, ?int $parentId, bool $isDirectory = false, ?string $data = null): int
    {
        $stmt = $this->connection->prepare('INSERT INTO files (name, parent_id, is_directory, data) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $parentId, (int)$isDirectory, $data]);

        return (int)$this->connection->lastInsertId();
    }

    public function searchFiles(string $query): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM files WHERE name LIKE ?');
        $stmt->execute(["%$query%"]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteFile(int $id): void
    {
        $stmt = $this->connection->prepare('DELETE FROM files WHERE id =?');
        $stmt->execute([$id]);
    }
}
