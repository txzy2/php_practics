<?php

class Str
{
    /**
     * Summary of detect
     * @param string $str
     * @return string
     */
    private static function detect(string $str)
    {
        if (preg_match("/[А-Яа-я]/", $str)) {
            return "эта строка содержит кириллицу";
        }

        return "this string contains only Latin letters";
    }

    /**
     * Summary of getRes
     * @param mixed $str
     * @return string
     */
    public static function getRes($str)
    {
        if (is_numeric($str)) {
            return 'You entered numbers. I need only letters';
        }

        return self::detect($str);
    }
}
