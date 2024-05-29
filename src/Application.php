<?php

declare(strict_types=1);

namespace LinkSavvy;

use Exception;
use PDO;

class Application
{
    private readonly string $basePath;

    private $baseUrl;

    private array|bool $config;

    private readonly \PDO $pdo;

    private $userId;

    private readonly UserManager $userManager;

    public function __construct()
    {
        session_start();

        $this->basePath = dirname(__FILE__, 2) . '/';
        $this->baseUrl = $this->getBaseUrl();

        $configFilePath = $this->basePath . '/config.ini';
        $this->config = parse_ini_file($configFilePath, true);

        $dbConfig = $this->getConfigSection('db');
        $databaseManager = new DatabaseManager($dbConfig);
        $this->pdo = $databaseManager->getConnection();

        $userConfig = $this->getConfigSection('user');
        $this->userManager = new UserManager($this->pdo, $userConfig);
    }

    public function checkAuthentication(): void
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
        } else {
            header('HTTP/1.1 401 Unauthorized');
            exit();
        }
    }

    public function checkAuthenticationAndRedirect(): void
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
        } else {
            header('HTTP/1.1 401 Unauthorized');
            $this->redirect('index.php');
            exit();
        }
    }

    public function getBaseUrl()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $requestUri = $_SERVER['REQUEST_URI'];

        $baseURL = '';

        // Find the position of the program name in the URL.
        $progDir = basename($this->basePath);
        $prognamePosition = strpos((string) $requestUri, $progDir);

        // If program name is found, get the base path.
        if ($prognamePosition !== false) {
            $baseURL = substr((string) $requestUri, 0, $prognamePosition) . $progDir . '/public/';
            return 'https://' . $serverName . $baseURL;
        }

        throw new Exception('Base URL not found');
    }

    public function getConfigSection(string $section): array
    {
        if (! isset($this->config[$section])) {
            throw new Exception('Section not found');
        }

        return $this->config[$section];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserManager(): UserManager
    {
        return $this->userManager;
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function redirect(string $path): void
    {
        header('Location: ' . $this->baseUrl . $path);
        exit();
    }
}
