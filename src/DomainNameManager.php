<?php

declare(strict_types=1);

namespace LinkSavvy;

use PDO;

class DomainNameManager
{
    public function __construct(
        private readonly PDO $pdo
    ) {}

    public function create($domainName): string|false
    {
        $sql = 'INSERT INTO DomainNames (domainName) VALUES (:domainName)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainName', $domainName);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function read($domainId)
    {
        $sql = 'SELECT * FROM DomainNames WHERE domainId = :domainId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainId', $domainId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($domainId, $domainName)
    {
        $sql = 'UPDATE DomainNames SET domainName = :domainName WHERE domainId = :domainId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainId', $domainId);
        $stmt->bindParam(':domainName', $domainName);
        return $stmt->execute();
    }

    public function delete($domainId)
    {
        $sql = 'DELETE FROM DomainNames WHERE domainId = :domainId';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainId', $domainId);
        return $stmt->execute();
    }
}
