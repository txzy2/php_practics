<?php

class Str
{
    private static function detect(string $str)
    {
        if (preg_match("/[А-Яа-я]/", $str)) {
            return "эта строка содержит кириллицу";
        }

        return "this string contains only Latin letters";
    }

    public static function getRes($str)
    {
        if (is_numeric($str)) {
            return 'You entered numbers. I need only letters';
        }

        return self::detect($str);
    }
}
