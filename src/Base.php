<?php

/**
 * Base.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone;

use TwitterClone\Uuid\Uuid;
use TwitterClone\Engine\Engine;
use DateTime;
use DateTimeZone;

/**
 * Base Class
 *
 * The Base Class is in charge of establishing a reference Base Model
 * for the classes that extend from it. The class contains information
 * such as a Unique Universal Identifier, a way to save the data created
 * from the instances and finally the representation of all the keys and
 * values of an instance.
 */
class Base
{
    /**
     * @var string $id The id for an instance.
     */
    public $id;

    /**
     * @var DateTime $createdAt The date of creation of an instance.
     */
    public $createdAt;

    public function __construct()
    {
        $this->id = Uuid::guidv4();
        $this->createdAt = new DateTime('now', new DateTimeZone('-0500'));
    }

    /**
     * Get the id of the current instance.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the date of creation of the current instance.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Dumps the current instance data into a file.
     *
     * @return void
     */
    public function save()
    {
        Engine::getStorage()->addObject($this);
        Engine::getStorage()->serializeObjects();
    }

    /**
     * Get the class name of the current instance.
     *
     * @return string
     */
    public function getClassName()
    {
        return static::class;
    }

    /**
     * Checks if a value has an underscore character.
     *
     * @param string $value The value to be tested
     *
     * @return int
     */
    public function hasUnderscore($value)
    {
        return strpos($value, "_");
    }

    /**
     * Removes the underscore character from a string.
     *
     * @param string $value The value to be tested
     *
     * @return string
     */
    public function removeUnderscore(string $value)
    {
        return explode("_", $value)[1];
    }

    /**
     * Sanitizes the private attributes of an object.
     *
     * When classes have private attributes, casting an object
     * into an array causes the attributes of this object to be
     * mapped as the following pattern: "{classname}_{attributename}".
     *
     * This method takes care of sanitizing all these attributes to
     * keep a clean format when serializing and deserializing an object.
     *
     * @return array
     */
    public function sanitizePrivateKeysFromClass()
    {
        $classInfo = (array) $this;
        $classKeys = array_keys($classInfo);
        $privateKeys = array_filter($classKeys, array($this, 'hasUnderscore'));
        $fixedKeys = array_map(array($this, 'removeUnderscore'), $privateKeys);
        $unifiedKeys = array_merge($fixedKeys, array_diff($classKeys, $privateKeys));
        $sanitizedClass = array_combine($unifiedKeys, array_values($classInfo));
        return $sanitizedClass;
    }

    /**
     * Converts the information of the current instance
     * to human-readable format.
     *
     * @return array Returns a new array containing all
     * keys/values of the instance.
     */
    public function toArray(): array
    {
        $classInfo = $this->sanitizePrivateKeysFromClass();
        $classInfo['__class__'] = static::class;
        $classInfo['createdAt'] = $this->createdAt->format('Y-m-d H:i:s');
        return $classInfo;
    }
}
