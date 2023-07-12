<?php

namespace LinkSavvy;

use Exception;
use PDO;

class Application
{
    private $basePath;
    private $baseUrl;
    private $config;
    private $pdo;
    private $userId;
    private $userManager;

    public function __construct()
    {
        session_start();

        $this->basePath = dirname(dirname(__FILE__)) . '/';
        $this->baseUrl = $this->getBaseUrl();

        $configFilePath = $this->basePath . '/config.ini';
        $this->config = parse_ini_file($configFilePath, true);

        $dbConfig = $this->getConfigSection('db');
        $dbManager = new DatabaseManager($dbConfig);
        $this->pdo = $dbManager->getConnection();

        $userConfig = $this->getConfigSection('user');
        $this->userManager = new UserManager($this->pdo, $userConfig);
    }

    public function checkAuthentication()
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
        } else {
            header('HTTP/1.1 401 Unauthorized');
            exit();
        }
    }

    public function checkAuthenticationAndRedirect()
    {
        if (isset($_SESSION['userId'])) {
            $this->userId = $_SESSION['userId'];
        } else {
            header('HTTP/1.1 401 Unauthorized');
            $this->redirect('index.php');
            exit();
        }
    }

    public function getBaseUrl() {
        $serverName = $_SERVER['SERVER_NAME'];
        $requestUri = $_SERVER['REQUEST_URI'];

        $baseURL = '';

        // Find the position of the program name in the URL.
        $progDir = basename($this->basePath);
        $prognamePosition = strpos($requestUri, $progDir);

        // If program name is found, get the base path.
        if ($prognamePosition !== false) {
            $baseURL = substr($requestUri, 0, $prognamePosition) . $progDir . '/public/';
            return 'https://' . $serverName . $baseURL;
        } else {
            throw new Exception("Base URL not found");
        }
    }

    public function getConfigSection(string $section): array
    {
        if (!isset($this->config[$section])) {
            throw new Exception("Section not found");
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
