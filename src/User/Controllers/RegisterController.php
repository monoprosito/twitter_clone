<?php

/**
 * RegisterController.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\User\Controllers;

use TwitterClone\User\User;

/**
 * RegisterController Class
 *
 * The RegisterController defines the methods to handle
 * a request to store a new Twitter User.
 *
 * The RegisterController handles a payload to notify the user
 * with the result of every respective request.
 */
class RegisterController extends UserController
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
        $registerController = (new self);
        $inputDataPayload = $registerController->checkUserInputData($user);

        if ($inputDataPayload->success) {
            $payload = $registerController->storeUser($user->username, $user->email, $user->password, $user->phoneNumber);
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
     * Stores the user instance in the Storage Engine.
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
        $userByUsername = User::getUserBy('username', $username);
        $userByEmail = User::getUserBy('email', $email);

        if (empty((array) $userByUsername) && empty((array) $userByEmail)) {
            $user = new User($username, $email, password_hash($password, PASSWORD_DEFAULT), $phoneNumber);
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
