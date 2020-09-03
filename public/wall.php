<?php

// Initialize the session
session_start();

// If the user isn't logged in will be redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home / Twitter</title>
</head>
<body>
    <p>Wall</p>
    <a href="http://localhost:8080/twitter_clone/public/logout.php">Log out</a>
</body>
</html>
