<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LinkSavvy\Application;
use LinkSavvy\TagManager;

header('Content-Type: application/json');

try {
    $app = new Application();
    $app->checkAuthentication();
    $pdo = $app->getPdo();
    $userId = $app->getUserId();

    $tagManager = new TagManager($pdo);
    $allTags = $tagManager->readNames($userId);

    echo json_encode($allTags);
} catch (Exception $e) {
    http_response_code(400); // return a custom status code
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
