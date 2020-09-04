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
    <link rel="shortcut icon" href="//abs.twimg.com/favicons/twitter.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/buttons.css">
    <link rel="stylesheet" href="styles/wall.css">
    <title>Home / Twitter</title>
</head>
<body>
    <div class="row main-row">
        <h1>Message Posting View</h1>
        <div class="row filters">
            <input type="text" placeholder="Search">
            <input type="text" class="date-filter" placeholder="YYYY.MM.DD"/>
        </div>
        <div class="row">
            <div class="row tweets">
                <ul>
                    <li>
                        <span><strong>YYYY.MM.DD</strong></span><br>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis urna enim, eget lacinia nisl commodo id. Maecenas in pretium purus.</span><br>
                        <span><strong>By: Username</strong></span>
                    </li>
                    <li>
                        <span><strong>YYYY.MM.DD</strong></span><br>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis urna enim, eget lacinia nisl commodo id. Maecenas in pretium purus.</span><br>
                        <span><strong>By: Username</strong></span>
                    </li>
                    <li>
                        <span><strong>YYYY.MM.DD</strong></span><br>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis urna enim, eget lacinia nisl commodo id. Maecenas in pretium purus.</span><br>
                        <span><strong>By: Username</strong></span>
                    </li>
                    <li>
                        <span><strong>YYYY.MM.DD</strong></span><br>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis urna enim, eget lacinia nisl commodo id. Maecenas in pretium purus.</span><br>
                        <span><strong>By: Username</strong></span>
                    </li>
                    <li>
                        <span><strong>YYYY.MM.DD</strong></span><br>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis urna enim, eget lacinia nisl commodo id. Maecenas in pretium purus.</span><br>
                        <span><strong>By: Username</strong></span>
                    </li>
                    <li>
                        <span><strong>YYYY.MM.DD</strong></span><br>
                        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris convallis urna enim, eget lacinia nisl commodo id. Maecenas in pretium purus.</span><br>
                        <span><strong>By: Username</strong></span>
                    </li>
                </ul>
            </div>
            <div class="row tweet-box">
                <textarea name="message" id="tweetMessage" placeholder="What's happening?" maxlength="280"></textarea>
                <div class="row tweet-action-box">
                    <span id="tweetLimit" class="tweet-limit-message">0/280 characters</span>
                    <a class="primary-button" id="submitForm">Tweet</a>
                </div>
            </div>
        </div>
        <a href="http://localhost:8080/twitter_clone/public/logout.php">Log out</a>
    </div>
    <script src="scripts/wall.js"></script>
</body>
</html>
