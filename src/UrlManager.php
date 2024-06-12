<?php

declare(strict_types=1);

namespace LinkSavvy;

use PDO;

class UrlManager
{
    public function __construct(
        private readonly PDO $pdo
    ) {}

    public function create(
        int $folderId,
        string $originalUrl,
        string $urlTitle,
        string $urlDescription,
        int $domainId
    ): string|false {
        $sql = <<<SQL
            INSERT INTO
                Urls (
                    folderId,
                    originalUrl,
                    urlTitle,
                    urlDescription,
                    domainId
                )
            VALUES
                (
                    :folderId,
                    :originalUrl,
                    :urlTitle,
                    :urlDescription,
                    :domainId
                )
            SQL;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':folderId' => $folderId,
            ':originalUrl' => $originalUrl,
            ':urlTitle' => $urlTitle,
            ':urlDescription' => $urlDescription,
            ':domainId' => $domainId,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function delete(int $urlId)
    {
        $sql = 'DELETE FROM Urls WHERE urlId = :urlId';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':urlId' => $urlId,
        ]);
    }

    public function read(int $urlId)
    {
        $sql = 'SELECT * FROM Urls WHERE urlId = :urlId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':urlId' => $urlId,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function readUrlsInFolder(int $folderId): array
    {
        $query = <<<SQL
            SELECT
                urlId,
                originalUrl,
                urlTitle,
                urlDescription
            FROM
                Urls
            WHERE
                folderId = :folderId
            ORDER BY
                urlTitle
            SQL;
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            ':folderId' => $folderId,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(
        int $urlId,
        string $originalUrl,
        string $urlTitle,
        string $urlDescription,
        int $domainId
    ) {
        $sql = <<<SQL
            UPDATE
                Urls
            SET
                originalUrl = :originalUrl,
                urlTitle = :urlTitle,
                urlDescription = :urlDescription,
                domainId = :domainId
            WHERE
                urlId = :urlId
            SQL;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':originalUrl' => $originalUrl,
            ':urlTitle' => $urlTitle,
            ':urlDescription' => $urlDescription,
            ':domainId' => $domainId,
            ':urlId' => $urlId,
        ]);
    }
}
