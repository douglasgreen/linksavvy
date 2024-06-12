<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use LinkSavvy\Application;
use LinkSavvy\TagManager;

header('Content-Type: application/json');

try {
    $app = new Application();
    $app->checkAuthentication();
    $pdo = $app->getPdo();
    $userId = $app->getUserId();

    $response = [];

    // Check if necessary POST parameters are set
    if (isset($_POST['tagName'])) {
        $tagName = $_POST['tagName'];
        $tagManager = new TagManager($pdo);

        // Create the new tag
        $tagId = $tagManager->create($userId, $tagName);

        // Add the new tag's ID to the response
        $response['status'] = 'success';
        $response['tagId'] = $tagId;
    } else {
        throw new Exception('The tagName field is required.');
    }

    echo json_encode($response);
} catch (Exception $exception) {
    http_response_code(400); // return a custom status code
    echo json_encode([
        'status' => 'error',
        'message' => $exception->getMessage(),
    ]);
}
