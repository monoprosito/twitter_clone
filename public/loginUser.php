<?php

/**
 * loginUser.php
 * php version 7.4.9
 *
 * This file handles the request from Javascript to login a Twitter User.
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */


require_once __DIR__ . '/../vendor/autoload.php';

use TwitterClone\User\Controllers\LoginController;

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"));

LoginController::loginUser($data);
