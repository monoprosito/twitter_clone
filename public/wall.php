<?php

require_once __DIR__ . '/../vendor/autoload.php';

use TwitterClone\Message\Message;
use TwitterClone\User\User;

// Initialize the session
session_start();

// If the user isn't logged in will be redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('location: login.php');
    exit;
}

$tweets = (object) array_reverse((array) Message::getMessageInstances());

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
        <div class="row" style="width: 100%;">
            <div class="row tweets">
                <ul>
                    <?php if (empty((array) $tweets)) {?>
                    <li>Tweets not found.</li>
                    <?php } else { ?>
                    <?php foreach ($tweets as $tweet) {?>
                        <li>
                        <span><strong><?php echo $tweet->getCreatedAt()->format('h:i a · d M. Y'); ?></strong></span><br>
                        <span><?php echo $tweet->getText(); ?></span><br>
                        <span><strong>By: <?php echo User::getUserBy('id', $tweet->getAuthorId())->getUsername(); ?></strong></span>
                    </li>
                    <?php } ?>
                    <?php } ?>
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
        <a href="http://localhost:8080/twitter_clone/public/logout.php" class="secondary-button logout">Log out</a>
    </div>
    <script src="scripts/wall.js"></script>
</body>
</html>
