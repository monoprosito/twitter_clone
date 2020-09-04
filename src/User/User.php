<?php

/**
 * User.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\User;

use TwitterClone\Base;
use TwitterClone\Engine\Engine;

/**
 * User Class
 *
 * The User class is in charge of establishing all the
 * attributes and behaviors that a user has on the
 * Twitter platform.
 */
class User extends Base
{
    /**
     * @var string The nickname of the user.
     */
    private $_username;

    /**
     * @var string The email of the user.
     */
    private $_email;

    /**
     * @var string The password of the user.
     */
    private $_password;

    /**
     * @var string The phone number of this user.
     */
    private $_phoneNumber;

    public function __construct($username, $email, $password, $phoneNumber,
                                $id = null, $createdAt = null)
    {
        if ($id && $createdAt)
            parent::__construct($id, $createdAt);
        else if ($id)
            parent::__construct($id);
        else if ($createdAt)
            parent::__construct($createdAt);
        else
            parent::__construct();

        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setPhoneNumber($phoneNumber);
    }

    /**
     * Get the username of the user.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * Set a username for this user.
     *
     * @param string $username The username to set.
     *
     * @return void
     */
    public function setUsername(string $username)
    {
        $this->_username = $username;
    }

    /**
     * Get the email of this user.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Set a email for this user.
     *
     * @param string $email The email to set.
     *
     * @return void
     */
    public function setEmail(string $email)
    {
        $this->_email = $email;
    }

    /**
     * Get the password of this user.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Set a password for this user.
     *
     * @param string $password The password to set.
     *
     * @return void
     */
    public function setPassword(string $password)
    {
        $this->_password = $password;
    }

    /**
     * Get the phone number of this user.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->_phoneNumber;
    }

    /**
     * Set the phone number of this user.
     *
     * @param string $phoneNumber The phone number to set.
     *
     * @return void
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->_phoneNumber = $phoneNumber;
    }

    /**
     * Get all the User objects from the Storage Engine.
     *
     * @return array
     */
    public static function getUserInstances()
    {
        $storage = Engine::getStorage()->getAllObjects();

        if (empty($storage))
            return [];
        else
            return array_filter($storage, function($element) {
                return is_a($element, User::class);
            });
    }

    /**
     * Get an User instance by a property.
     *
     * @param string $property The property with which you
     * will search for the user.
     * @param string $value The value of the property to
     * search for the user.
     *
     * @return object
     */
    public static function getUserBy($property, $value)
    {
        $users = User::getUserInstances();
        $capitalizedProperty = ucfirst(strtolower($property));
        $getProperty = "get$capitalizedProperty";

        if (empty($users))
            return (object) [];
        else
            foreach ($users as $user)
                if ($user->$getProperty() === $value)
                    return $user;
    }
}
