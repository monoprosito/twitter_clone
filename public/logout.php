<?php

/**
 * logout.php
 * php version 7.4.9
 *
 * This file handles the end of the session of a Twitter User.
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: index.php");
exit;
?>
