<?php

namespace App\Service;

class NumberService
{
    public static function floatFromString($str)
    {
        if (config('shop.float_format') == 'de') {
            return floatval(str_replace(',', '.', str_replace('.', '', $str)));
        }

        return floatval(str_replace(',', '', $str));
    }

    public static function stringFromFloat($number, $forceDecimals = 0)
    {
        $str = str_replace('.', ',', strval($number));

        if ($forceDecimals) {
            if (! stristr($str, ',')) {
                return $str.',00';
            }

            $arr = explode(',', $str);

            while (strlen($arr[1]) < $forceDecimals) {
                $arr[1] .= '0';
            }

            if (strlen($arr[1]) > $forceDecimals) {
                $arr[1] = substr($arr[1], 0, $forceDecimals);
            }

            $str = implode(',', $arr);
        }

        return $str;
    }

    public static function formattedFromCents($cents, $emptyStringWhenZero = true)
    {
        if ($emptyStringWhenZero && ! $cents) {
            return '';
        }

        if (config('shop.float_format') == 'de') {
            return number_format(($cents ? ($cents / 100) : 0), 2, ',', '.');
        }

        return number_format(($cents ? ($cents / 100) : 0), 2, '.', ',');
    }

    public static function formatted($value, $emptyStringWhenZero = true, $forceDecimal = true)
    {
        if ($emptyStringWhenZero && ! $value) {
            return '';
        }

        if (! $forceDecimal) {
            $str = strval($value);

            if (config('shop.float_format') == 'de') {
                return str_replace('.', ',', $str);
            }

            return $str;
        }

        if (config('shop.float_format') == 'de') {
            return number_format(($value ?: 0), 2, ',', '.');
        }

        return number_format(($value ?: 0), 2, '.', ',');
    }

    public static function centsFromString($str)
    {
        return intval(static::floatFromString($str) * 100);
    }

    public static function floatForFilemaker($number)
    {
        $str = '';
        $number = static::floatFromString($number);

        if ($number < 100) {
            $str = '0';
        }

        $str .= stringFromFloat($number, 2);

        return $str;
    }
}
