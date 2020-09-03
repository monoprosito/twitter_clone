<?php

/**
 * UserController.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\User\Controllers;

use Exception;

class InvalidUsername extends Exception {}
class InvalidEmail extends Exception {}
class InvalidPassword extends Exception {}
class InvalidPhoneNumber extends Exception {}

/**
 * UserController Class
 *
 * The UserController defines the validator methods for the
 * User Model attributes.
 */
class UserController
{
    /**
     * Verifies that the nickname has at least 4 letters and 2 numbers.
     * Also, that it does not contain any special characters.
     *
     * This validator method raises an InvalidUsernameException in
     * case the username is invalid.
     *
     * @param string $username The nickname of the user
     *
     * @return void
     */
    public function checkUsername($username)
    {
        $pattern = "/^(?=(.*\d){2,})(?=(.*[A-Za-z]){4,})[\w]+$/";

        if ($username == null || !preg_match($pattern, $username))
            throw new InvalidUsername('The username should not be empty. It must have at least 4 letters and 2 numbers, and must not contain any special characters.');
    }

    /**
     * Verifies that the email is valid.
     *
     * RegEx from: General Email Regex (Practical Implementation of RFC 5322 Official Standard)
     * https://www.regular-expressions.info/email.html
     *
     * This validator method raises an InvalidEmailException in
     * case the email is invalid.
     *
     * @param string $email The email to be checked.
     *
     * @return void
     */
    public function checkEmail($email)
    {
        $pattern = "/^[a-z0-9!#$%&\'*+\/=?^_‘{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_‘{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/";

        if ($email == null || !preg_match($pattern, $email))
            throw new InvalidEmail('The email should be a valid.');
    }

    /**
     * Verifies that the password has at least 6 characters,
     * a "-" and a capital letter.
     *
     * This validator method raises an InvalidPasswordException in
     * case the password is invalid.
     *
     * @param string $password The password to be checked.
     *
     * @return void
     */
    public function checkPassword($password)
    {
        $pattern = "/^(?=.*[A-Z]+)(?=.*-+)(?=.{6,}$)[\w-]*$/";

        if ($password == null || !preg_match($pattern, $password))
            throw new InvalidPassword('The password should be at least 6 characters longand contain a “-” and an uppercase letter.');
    }

    /**
     * Verifies that the cell phone number has at least 10 numbers,
     * all characters here must be numbers.
     *
     * This validator method raises an InvalidPhoneNumberException in
     * case the phone number is invalid.
     *
     * @param string $phoneNumber The phone number to be checked.
     *
     * @return void
     */
    public function checkPhoneNumber($phoneNumber)
    {
        $pattern = "/^\d{10,}$/";

        if ($phoneNumber == null || !preg_match($pattern, $phoneNumber))
            throw new InvalidPhoneNumber('The phone number should have at least 10 numbers. All the characters must be numbers.');
    }
}
