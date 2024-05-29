<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LinkSavvy\Application;
use LinkSavvy\UserManager;

$app = new Application();
$pdo = $app->getPdo();
$userManager = $app->getUserManager();

$username = $_POST['username'];
$password = $_POST['password'];

$userId = $userManager->login($username, $password);
if ($userId) {
    $_SESSION['userId'] = $userId;
    $app->redirect('help');
} else {
    echo "Login failed. Please <a href='index.php'>try again</a>.";
}
