<?php
class date_helper
{
    const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';
    const MYSQL_DATE_FORMAT = 'Y-m-d';
    const SCREENSHOT_DATE_FORMAT = 'Ymd';
    const GET_ONLY_YEAR = 'Y';

    /**
     * Formatting according set format in wadmin config
     * @param DATETIME $date
     */
    static function short_date($date)
    {
        return self::get_date_in_format($date, Kohana::config('wadmin.short_date_format'));
    }

    static function mysql_datetime($date)
    {
        return self::get_date_in_format($date, self::MYSQL_DATETIME_FORMAT);
    }

    static function mysql_date($date)
    {
        return self::get_date_in_format($date, self::MYSQL_DATE_FORMAT);
    }

    static function screenshot_date($date)
    {
        return self::get_date_in_format($date, self::SCREENSHOT_DATE_FORMAT);
    }

    static function get_year($date)
    {
        return self::get_date_in_format($date, self::GET_ONLY_YEAR);
    }

    static function mysql_date_now()
    {
        $date_format = self::MYSQL_DATETIME_FORMAT;
        return date($date_format);
    }

    public static function get_date_in_format($date, $format)
    {
        if ($date == '') {
            return '';
        }
        return date($format, strtotime($date));
    }
}

?>