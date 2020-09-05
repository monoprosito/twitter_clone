<?php

/**
 * Message.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\Message;

use TwitterClone\Base;
use TwitterClone\Engine\Engine;

/**
 * Message Class
 *
 * The Message class is in charge of establishing all the
 * attributes and behaviors that a message has on the
 * Twitter platform.
 */
class Message extends Base
{
    /**
     * @var string The author of the message.
     */
    private $_authorId;

    /**
     * @var string The text of the message.
     */
    private $_text;

    public function __construct($authorId, $text, $id = null, $createdAt = null)
    {
        if ($id && $createdAt)
            parent::__construct($id, $createdAt);
        else if ($id)
            parent::__construct($id);
        else if ($createdAt)
            parent::__construct($createdAt);
        else
            parent::__construct();

        $this->setAuthorId($authorId);
        $this->setText($text);
    }

    /**
     * Get the Author Uuid of the message.
     *
     * @return string
     */
    public function getAuthorId()
    {
        return $this->_authorId;
    }

    /**
     * Set the Author Uuid of the message.
     *
     * @param string $author The Author Uuid of the message.
     *
     * @return void
     */
    public function setAuthorId($authorId)
    {
        $this->_authorId = $authorId;
    }

    /**
     * Get the text of the message.
     *
     * @return string
     */
    public function getText(): string
    {
        return $this->_text;
    }

    /**
     * Set the text for the message.
     *
     * @param string $text The text for the message.
     *
     * @return void
     */
    public function setText($text)
    {
        $this->_text = $text;
    }

    /**
     * Get all the Message objects from the Storage Engine.
     *
     * @return array
     */
    public static function getMessageInstances()
    {
        $storage = Engine::getStorage()->getAllObjects();

        if (empty($storage))
            return [];
        else
            return array_filter($storage, function($element) {
                return is_a($element, Message::class);
            });
    }

    /**
     * Filter tweets by a property and value.
     *
     * @param string $property The key to filter in the tweets
     * @param string $value The value to filter in the tweets
     * @param object $objects (optional) An object of tweets to filter
     *
     * @return array
     */
    public static function filterMessagesBy($property, $value, $objects = null)
    {
        if ($objects) {
            $tweets = $objects;
        } else {
            $tweets = self::getMessageInstances();
        }

        $methodKey = "get$property";

        return array_filter($tweets, function ($tweet) use($methodKey, $value) {
            return (stripos(($methodKey === 'getCreatedAt') ? $tweet->$methodKey()->format('Y-m-d') : $tweet->$methodKey(), $value) !== false);
        });
    }
}
