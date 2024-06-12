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

    $response = [];

    // Check if necessary POST parameters are set
    if (isset($_POST['folderName'])) {
        $folderName = $_POST['folderName'];
        $folderManager = new FolderManager($pdo);

        // Create the new folder
        $folderId = $folderManager->create($userId, $folderName);

        // Add the new folder's ID to the response
        $response['status'] = 'success';
        $response['folderId'] = $folderId;
    } else {
        throw new Exception('The folderName field is required.');
    }

    echo json_encode($response);
} catch (Exception $exception) {
    http_response_code(400); // return a custom status code
    echo json_encode([
        'status' => 'error',
        'message' => $exception->getMessage(),
    ]);
}
