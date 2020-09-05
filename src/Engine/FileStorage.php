<?php

/**
 * FileStorage.php
 * php version 7.4.9
 *
 * @author  Santiago Arboleda Londoño <monoprosito@gmail.com>
 * @license https://github.com/monoprosito/twitter_clone/blob/master/LICENSE MIT License
 */

namespace TwitterClone\Engine;

use TwitterClone\User\User;
use TwitterClone\Message\Message;
use ReflectionClass;

/**
 * FileStorage Class
 *
 * Serializes the instances to a JSON file and
 * deserializes the JSON file to the instances.
 */
class FileStorage
{
    /**
     * @var string $_filePath The file path that saves
     * all objects of the application.
     */
    private $_filePath = '../resources/twitter_storage.json';

    /**
     * @var array $_objects The object that stores all
     * the instances of the objects of the application.
     */
    private $_objects = [];

    public function __construct()
    {
        /**
         * Each time this class is instantiated, objects that
         * are saved in the application file will be incorporated
         * to make them available.
         */
        $this->deserializeObjects();
    }

    /**
     * Get the _objects information.
     *
     * @return array Returns the content of all
     * the instances of the objects of the application.
     */
    public function getAllObjects()
    {
        return $this->_objects;
    }

    /**
     * Saves the data of an instance in the storage
     * object of the application.
     *
     * @param object $obj The instance to be saved.
     *
     * @return void
     */
    public function addObject($obj)
    {
        $key = $obj->getClassName() . '.' . $obj->id;
        $this->_objects[$key] = $obj;
    }

    /**
     * Saves the data of the application storage
     * object instances in a local file.
     *
     * @return void
     */
    public function serializeObjects()
    {
        $jsonArray = [];

        foreach ($this->getAllObjects() as $key => $value) {
            /**
             * Extracts the class name of an instance
             * from the Namespace path
             */
            $splittedClass = explode("\\", $key);
            $lastClassName = end($splittedClass);

            $jsonArray[$lastClassName] = $value->toArray();
        }

        /**
         * Writes the human-readable data of
         * all instances in the local file
         */
        file_put_contents($this->_filePath, json_encode($jsonArray));
    }

    /**
     * Loads the data from the local file instances
     * into the application storage object.
     *
     * @return void
     */
    public function deserializeObjects()
    {
        $fileExists = file_exists($this->_filePath);

        if ($fileExists) {
            $fileContent = file_get_contents($this->_filePath);

            /**
             * Prevents an error from occurring on the first application
             * load, when the local file is empty
             */
            if (strlen($fileContent) > 0) {
                $jsonArray = json_decode($fileContent);

                foreach ($jsonArray as $key => $value) {
                    /**
                     * Creates an instance of the current object
                     * along with its data
                     */
                    $reflect = new ReflectionClass($value->__class__);
                    $this->_objects[$key] = $reflect->newInstanceArgs(array_values((array) $value));
                }
            }
        }
    }
}
