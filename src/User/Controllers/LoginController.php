<?php

/**
 * LoginController.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\User\Controllers;

use TwitterClone\User\User;

/**
 * LoginController Class
 *
 * The LoginController defines the methods to handle
 * a login request to Twitter.
 *
 * The LoginController handles a payload to notify the user
 * with the result of every respective request.
 */
class LoginController extends UserController
{
    /**
     * @var SUCCESSFUL_PAYLOAD Indicates that a request was successful. 1 is equal to TRUE.
     */
    const SUCCESSFUL_PAYLOAD = 1;

    /**
     * @var UNSUCCESSFUL_PAYLOAD Indicates that a request was unsuccessful. 0 is equal to FALSE.
     */
    const UNSUCCESSFUL_PAYLOAD = 0;

    /**
     * Checks if the data of a request to login is valid
     * and proceed to logon the user.
     *
     * This method establish the process to validate the user data,
     * depending the answer of the validator method, the flow will
     * proceed to logon the user, and return a succeed payload, or
     * notify the reason for the issue in an error payload.
     *
     * @param object $user The user data to verifies and logon.
     *
     * @return void
     */
    public static function loginUser($user)
    {
        $loginController = (new self);
        $inputDataPayload = $loginController->checkUserInputData($user);

        if ($inputDataPayload->success) {
            $payload = $loginController->logon($user->email, $user->password);
        } else {
            $payload = $inputDataPayload;
        }

        echo json_encode($payload);
    }

    /**
     * Checks if all the data of a user is correctly structured to
     * logon the user.
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
            $this->checkEmail($user->email);
            $this->checkPassword($user->password);
            $success = self::SUCCESSFUL_PAYLOAD;
            $message = 'All the data is valid.';
        } catch (InvalidEmail | InvalidPassword$e) {
            $message = $e->getMessage();
            $success = self::UNSUCCESSFUL_PAYLOAD;
        }

        return (object) [
            'success' => $success,
            'data' => [
                'message' => $message
            ]
        ];
    }

    /**
     * Enter a user on Twitter.
     *
     * When the user enters Twitter, some values are stored
     * in session variables to identify at some point,
     * if the user is logged in and who is the logged in user.
     *
     * @param string $email The email of the user.
     * @param string $password The password of the user.
     *
     * @return array
     */
    public function logon($email, $password)
    {
        $user = User::getUserBy('email', $email);

        if (!empty((array) $user)) {
            if (password_verify($password, $user->getPassword())) {
                session_start();

                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user->getId();

                $payload = [
                    'success' => self::SUCCESSFUL_PAYLOAD,
                    'data' => [
                        'message' => 'You have successfully logged in.'
                    ]
                ];
            } else {
                $payload = [
                    'success' => self::UNSUCCESSFUL_PAYLOAD,
                    'data' => [
                        'message' => 'The password you entered was not valid.'
                    ]
                ];
            }
        } else {
            $payload = [
                'success' => self::UNSUCCESSFUL_PAYLOAD,
                'data' => [
                    'message' => 'No account found with that email.'
                ]
            ];
        }

        return $payload;
    }
}
