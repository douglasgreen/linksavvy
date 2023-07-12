<?php

namespace LinkSavvy;

use Exception;
use PDO;

class DomainNameManager
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($domainName)
    {
        $sql = "INSERT INTO DomainNames (domainName) VALUES (:domainName)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainName', $domainName);
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function read($domainId)
    {
        $sql = "SELECT * FROM DomainNames WHERE domainId = :domainId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainId', $domainId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($domainId, $domainName)
    {
        $sql = "UPDATE DomainNames SET domainName = :domainName WHERE domainId = :domainId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainId', $domainId);
        $stmt->bindParam(':domainName', $domainName);
        return $stmt->execute();
    }

    public function delete($domainId)
    {
        $sql = "DELETE FROM DomainNames WHERE domainId = :domainId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':domainId', $domainId);
        return $stmt->execute();
    }
}
