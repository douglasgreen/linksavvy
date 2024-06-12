<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use LinkSavvy\Application;
use LinkSavvy\TagManager;

$app = new Application();
$app->checkAuthenticationAndRedirect();
$pdo = $app->getPdo();
$userId = $app->getUserId();

$tagManager = new TagManager($pdo);
$tagNames = $tagManager->readNames($userId);

?>
<!DOCTYPE html>
<html>
<head>
    <title>LinkSavvy: URL Manager</title>
    <link rel="stylesheet" type="text/css" href="../common.css">
    <link rel="stylesheet" type="text/css" href="../header.css">
    <link rel="stylesheet" type="text/css" href="tag.css">
</head>
<body>
<?php
require_once __DIR__ . '/../header.php';
?>
    <div id="page-container">
        <h1>LinkSavvy: URL Manager</h1>
        <form id="tag-form">
            <input type="hidden" id="tagId" name="tagId" />
            <div>
                <label for="tagName">Tag Name:</label>
                <input type="text" id="tagName" name="tagName" required />
            </div>
            <button class="btn" type="submit">Save</button>
        </form>
        <button class="btn" id="delete">Delete</button>
        <div id="tags-list"></div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="../error_handler.js"></script>
    <script src="tag.js"></script>
</body>
</html>
