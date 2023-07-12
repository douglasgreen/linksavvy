<?php

namespace LinkSavvy;

use Exception;
use PDO;

class TagManager
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $tagUserId, string $tagName)
    {
        $sql = "INSERT INTO Tags (tagUserId, tagName) VALUES (:tagUserId, :tagName)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':tagUserId' => $tagUserId,
            ':tagName' => $tagName
        ]);
        return $this->pdo->lastInsertId();
    }

    public function delete(int $tagId)
    {
        $sql = "DELETE FROM Tags WHERE tagId = :tagId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':tagId' => $tagId]);
    }

    public function read(int $tagId)
    {
        $sql = "SELECT * FROM Tags WHERE tagId = :tagId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':tagId' => $tagId]);
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
        $stmt->execute([':tagUserId' => $tagUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $tagId, string $tagName)
    {
        $sql = "UPDATE Tags SET tagName = :tagName WHERE tagId = :tagId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':tagName' => $tagName,
            ':tagId' => $tagId
        ]);
    }
}
