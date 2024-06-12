<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use LinkSavvy\Application;
use LinkSavvy\FolderManager;

header('Content-Type: application/json');

try {
    $app = new Application();
    $app->checkAuthentication();
    $pdo = $app->getPdo();
    $userId = $app->getUserId();

    $folderManager = new FolderManager($pdo);
    $allFolders = $folderManager->readNames($userId);

    echo json_encode($allFolders);
} catch (Exception $exception) {
    http_response_code(400); // return a custom status code
    echo json_encode([
        'status' => 'error',
        'message' => $exception->getMessage(),
    ]);
}
