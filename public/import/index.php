<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LinkSavvy\Application;
use LinkSavvy\FolderManager;

$app = new Application();
$app->checkAuthenticationAndRedirect();
$pdo = $app->getPdo();
$userId = $app->getUserId();

$folderManager = new FolderManager($pdo);
$folderNames = $folderManager->readNames($userId);

?>
<!DOCTYPE html>
<html>
<head>
    <title>LinkSavvy: URL Manager</title>
    <link rel="stylesheet" type="text/css" href="../common.css">
    <link rel="stylesheet" type="text/css" href="../header.css">
    <link rel="stylesheet" type="text/css" href="folder.css">
</head>
<body>
<?php
require_once '../header.php';
?>
    <div id="page-container">
        <h1>LinkSavvy: URL Manager</h1>
        <form id="folder-form">
            <input type="hidden" id="folderId" name="folderId" />
            <div>
                <label for="folderName">Folder Name:</label>
                <input type="text" id="folderName" name="folderName" required />
            </div>
            <button class="btn" type="submit">Save</button>
        </form>
        <button class="btn" id="delete">Delete</button>
        <div id="folders-list"></div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../error_handler.js"></script>
    <script src="folder.js"></script>
</body>
</html>
