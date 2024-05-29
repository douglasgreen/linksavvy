<?php

require_once __DIR__ . '/../vendor/autoload.php';

use LinkSavvy\Application;

$app = new Application();

if (isset($_SESSION['userId'])) {
    $app->redirect('folder/');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login/Register</title>
    <link rel="stylesheet" type="text/css" href="common.css">
    <link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
    <div id="page-container">
        <form id="login" method="POST" action="login/">
            <h2>Login</h2>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input class="btn" type="submit" value="Login">
        </form>

        <form id="register" method="POST" action="register/" style="display:none;">
            <h2>Register</h2>
            <label for="rusername">Username:</label><br>
            <input type="text" id="rusername" name="username"><br>
            <label for="rpassword">Password:</label><br>
            <input type="password" id="rpassword" name="password"><br>
            <input class="btn" type="submit" value="Register">
        </form>

        <button class="btn" id="switch">Switch to Register</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="common.js"></script>
    <script src="index.js"></script>
</body>
</html>
