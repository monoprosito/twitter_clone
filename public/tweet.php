<?php

/**
 * tweet.php
 * php version 7.4.9
 *
 * This file handles the request from Javascript to create a Tweet.
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */


require_once __DIR__ . '/../vendor/autoload.php';

use TwitterClone\Message\Controllers\MessageController;

// Initialize the session
session_start();

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));
$data->author = $_SESSION['user_id'];

MessageController::registerTweet($data);
