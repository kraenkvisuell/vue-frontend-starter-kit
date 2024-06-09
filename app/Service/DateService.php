<?php

namespace App\Service;

class DateService
{
    public static function datetimeDbToXml($date)
    {
        $date = str_replace(' ', 'T', $date);

        return $date;
    }

    public static function germanMonthNames()
    {
        return [
            'Januar',
            'Februar',
            'März',
            'April',
            'Mai',
            'Juni',
            'Juli',
            'August',
            'September',
            'Oktober',
            'November',
            'Dezember',
        ];
    }
}
