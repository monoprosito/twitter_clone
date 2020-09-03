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
use TwitterClone\User\User;

class InvalidUsername extends Exception {}
class InvalidEmail extends Exception {}
class InvalidPassword extends Exception {}
class InvalidPhoneNumber extends Exception {}

/**
 * UserController Class
 *
 * The UserControlelr Class Descriptiom
 *
 * The UserController handles a payload to notify the user
 * with the result of every respective request.
 */
class UserController
{
    /**
     * Checks if the data of a request to store a user is valid
     * and proceed to store it in the Storage Engine.
     *
     * This method establish the process to validate the user data,
     * depending the answer of the validator method, the flow will
     * proceed to store the user, and return a succeed payload, or
     * notify the reason for the issue in an error payload.
     *
     * @param object $user The user data to verifies and store.
     *
     * @return void
     */
    public static function registerUser($user)
    {
        $userController = (new self);
        $inputDataPayload = $userController->checkUserInputData($user);

        if ($inputDataPayload->success) {
            $payload = $userController->storeUser($user->username, $user->email, $user->password, $user->phoneNumber);
        } else {
            $payload = $inputDataPayload;
        }

        echo json_encode($payload);
    }

    /**
     * Checks if all the data of a user is correctly structured to
     * make a User instance with this data.
     *
     * This method establish the process to call every validator
     * method and pass the respective parameter to know if each
     * parameter from the input user data is valid. In case of
     * analyzing an invalid data, the method catch the Exception
     * and returns an error payload. Otherwise, a success payload
     * is returned.
     *
     * @param object $user The input user data to verifies.
     *
     * @return object
     */
    public function checkUserInputData($user)
    {
        try {
            $this->checkUsername($user->username);
            $this->checkEmail($user->email);
            $this->checkPassword($user->password);
            $this->checkPhoneNumber($user->phoneNumber);
            $success = 1;
            $message = 'All the data is valid.';
        } catch (InvalidUsername $e) {
            $success = 0;
            $message = $e->getMessage();
        } catch (InvalidEmail $e) {
            $message = $e->getMessage();
            $success = 0;
        } catch (InvalidPassword $e) {
            $success = 0;
            $message = $e->getMessage();
        } catch (InvalidPhoneNumber $e) {
            $success = 0;
            $message = $e->getMessage();
        }

        return (object) [
            'success' => $success,
            'data' => [
                'message' => $message
            ]
        ];
    }

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

    /**
     * Stores the user instance in the Engine Storage.
     *
     * @param string $username The nickname of the user.
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     * @param string $phoneNumber The phone number of the user.
     *
     * @return array
     */
    public function storeUser($username, $email, $password, $phoneNumber)
    {
        if (!User::exists($username, $email)) {
            $user = new User($username, $email, $password, $phoneNumber);
            $user->save();

            $payload = [
                'success' => 1,
                'data' => [
                    'message' => 'The user has been created correctly.'
                ]
            ];
        } else {
            $payload = [
                'success' => 0,
                'data' => [
                    'message' => 'This user already exists.'
                ]
            ];
        }

        return $payload;
    }
}
