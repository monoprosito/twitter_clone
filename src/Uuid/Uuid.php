<?php

/**
 * Uuid.php
 * php version 7.4.9
 *
 * @author Tjerk Anne Meesters <https://stackoverflow.com/users/1338292/ja%cd%a2ck>
 * @link   https://stackoverflow.com/a/15875555
 */

/**
 * Uuid Class
 *
 * Generates an UUID code.
 */
class Uuid
{
    /**
     * Generates random byte sequences and returns a string with
     * the format of an UUID code.
     *
     * @return string
     */
    public static function guidv4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
