<?php

namespace App\Service;

class StringService
{
    public static function repeatBlank($length): string
    {
        $str = '';
        for ($n = 0; $n < $length; $n++) {
            $str .= ' ';
        }

        return $str;
    }

    public static function ensureUrl($str): string
    {
        $str = trim($str);

        $str = str_replace('http//', 'http://', $str);

        $str = str_replace('https//', 'https://', $str);

        if (substr($str, 0, 1) != '/' && substr($str, 0, 4) != 'http' && substr($str, 0, 7) != 'mailto:') {
            $str = 'http://' . $str;
        }

        return $str;
    }
}
