<?php

/**
 * MessageController.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\Message\Controllers;

use Exception;
use TwitterClone\Message\Message;
use TwitterClone\User\User;

class EmptyTweet extends Exception {}
class TweetWithExceededCharacters extends Exception {}
class NonExistentUser extends Exception {}

/**
 * MessageController Class
 *
 * The MessageController description.
 */
class MessageController
{
    /**
     * @var TWEET_MAX_LENGTH The maximum amount of characters that a Tweet can store.
     */
    const TWEET_MAX_LENGTH = 280;

    /**
     * @var SUCCESSFUL_PAYLOAD Indicates that a request was successful. 1 is equal to TRUE.
     */
    const SUCCESSFUL_PAYLOAD = 1;

    /**
     * @var UNSUCCESSFUL_PAYLOAD Indicates that a request was unsuccessful. 0 is equal to FALSE.
     */
    const UNSUCCESSFUL_PAYLOAD = 0;

    /**
     * Checks if the data of a request to store a Tweet is valid
     * and proceed to store it in the Storage Engine.
     *
     * This method establish the process to validate the tweet data,
     * depending the answer of the validator method, the flow will
     * proceed to store the tweet, and return a succeed payload, or
     * notify the reason for the issue in an error payload.
     *
     * @param object $message The message data to verifies and store.
     *
     * @return void
     */
    public static function registerTweet($message)
    {
        $messageController = (new self);
        $inputDataPayload = $messageController->checkMessageInputData($message);

        if ($inputDataPayload->success) {
            $payload = $messageController->storeTweet($message->author, $message->text);
        } else {
            $payload = $inputDataPayload;
        }

        echo json_encode($payload);
    }

    /**
     * Checks if all the data of a tweet is correctly structured to
     * make a Message instance with this data.
     *
     * This method establish the process to call every validator
     * method and pass the respective parameter to know if each
     * parameter from the input tweet data is valid. In case of
     * analyzing an invalid data, the method catch the Exception
     * and returns an error payload. Otherwise, a success payload
     * is returned.
     *
     * @param object $message The input tweet data to verifies.
     *
     * @return object
     */
    public function checkMessageInputData($message)
    {
        try {
            $this->checkTweetMessage($message->text);
            $this->checkTweetAuthor($message->author);
            $success = self::SUCCESSFUL_PAYLOAD;
            $message = 'All the data is valid.';
        } catch (EmptyTweet | TweetWithExceededCharacters | NonExistentUser $e) {
            $success = self::UNSUCCESSFUL_PAYLOAD;
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
     * Verifies if the tweet message isn't empty.
     *
     * This validator method raises an EmptyTweet exception in
     * case the tweet message is empty. Also raises a
     * TweetWithExceededCharacters exception, if the tweet
     * exceeds the maximum allowed number of characters.
     *
     * @param string $text The Tweet Message to be checked.
     *
     * @return void
     */
    public function checkTweetMessage($text)
    {
        $text = trim($text);

        if ($text == null)
            throw new EmptyTweet('A Tweet cannot be empty.');

        if (strlen($text) > self::TWEET_MAX_LENGTH)
            throw new TweetWithExceededCharacters('A Tweet may not exceed 280 characters in length.');
    }

    /**
     * Verifies if the tweet author isn't empty and if the author
     * exists in Twitter.
     *
     * This validator method raises an NonExistentUser in
     * case the author is empty or not exists in Twitter.
     *
     * @param string $authorId The Tweet Author to be checked.
     *
     * @return void
     */
    public function checkTweetAuthor($authorId)
    {
        $authorId = trim($authorId);
        $userById = User::getUserBy('id', $authorId);

        if ($authorId == null || empty((array) $userById))
            throw new NonExistentUser('This user is not registered on Twitter, an unregistered user cannot tweet.');
    }

    /**
     * Stores the message instance in the Storage Engine.
     *
     * @param string $author The author id of the tweet.
     * @param string $text The text of the tweet.
     *
     * @return array
     */
    public function storeTweet($author, $text)
    {
        $tweet = new Message($author, $text);
        $tweet->save();

        $payload = [
            'success' => self::SUCCESSFUL_PAYLOAD,
            'data' => [
                'message' => 'The tweet has been created correctly.'
            ]
        ];

        return $payload;
    }
}
