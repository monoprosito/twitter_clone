<?php

/**
 * Engine.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\Engine;

use TwitterClone\Engine\FileStorage;

// Hold the required Storage Engine
$_SESSION['storage'] = new FileStorage();

/**
 * Engine Class
 *
 * The Engine Class is in charge of establishing the storage engine
 * that the application uses.
 */
class Engine
{
    public static function getStorage()
    {
        return $_SESSION['storage'];
    }
}
