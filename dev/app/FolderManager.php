<?php

namespace LinkSavvy;

use PDO;

class FolderManager
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $folderUserId, string $folderName)
    {
        $sql = "INSERT INTO Folders (folderUserId, folderName) VALUES (:folderUserId, :folderName)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':folderUserId' => $folderUserId,
            ':folderName' => $folderName
        ]);
        return $this->pdo->lastInsertId();
    }

    public function delete(int $folderId)
    {
        $sql = "DELETE FROM Folders WHERE folderId = :folderId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':folderId' => $folderId]);
    }

    public function read(int $folderId)
    {
        $sql = "SELECT * FROM Folders WHERE folderId = :folderId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':folderId' => $folderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readNames(int $folderUserId): array
    {
        $query = <<<SQL
            SELECT
                folderId,
                folderName
            FROM
                Folders
            WHERE
                folderUserId = :folderUserId
            ORDER BY
                folderName
            SQL;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':folderUserId' => $folderUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $folderId, string $folderName)
    {
        $sql = "UPDATE Folders SET folderName = :folderName WHERE folderId = :folderId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':folderName' => $folderName,
            ':folderId' => $folderId
        ]);
    }
}
