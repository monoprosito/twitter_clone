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

    public function __construct($authorId, $text, $id = null)
    {
        if ($id)
            parent::__construct($id);
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
}
