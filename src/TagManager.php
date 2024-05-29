<?php

declare(strict_types=1);

namespace LinkSavvy;

use PDO;

class TagManager
{
    public function __construct(
        private readonly PDO $pdo
    ) {}

    public function create(int $tagUserId, string $tagName): string|false
    {
        $sql = 'INSERT INTO Tags (tagUserId, tagName) VALUES (:tagUserId, :tagName)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':tagUserId' => $tagUserId,
            ':tagName' => $tagName,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function delete(int $tagId)
    {
        $sql = 'DELETE FROM Tags WHERE tagId = :tagId';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':tagId' => $tagId,
        ]);
    }

    public function read(int $tagId)
    {
        $sql = 'SELECT * FROM Tags WHERE tagId = :tagId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':tagId' => $tagId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readNames(int $tagUserId): array
    {
        $query = <<<SQL
            SELECT
                tagId,
                tagName
            FROM
                Tags
            WHERE
                tagUserId = :tagUserId
            ORDER BY
                tagName
            SQL;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':tagUserId' => $tagUserId,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $tagId, string $tagName)
    {
        $sql = 'UPDATE Tags SET tagName = :tagName WHERE tagId = :tagId';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':tagName' => $tagName,
            ':tagId' => $tagId,
        ]);
    }
}
