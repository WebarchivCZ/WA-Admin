<?php
class date_helper
{
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';
    const SCREENSHOT_DATE_FORMAT = 'Ymd';

    /**
     * Formatting according set format in wadmin config
     * @param DATETIME $long_date
     */
    static function short_date($long_date)
    {
        return self::get_date_in_format($long_date, Kohana::config('wadmin.short_date_format'));
    }

    static function mysql_date($short_date)
    {
        return self::get_date_in_format($short_date, self::MYSQL_DATE_FORMAT);
    }

    static function screenshot_date($short_date)
    {
        return self::get_date_in_format($short_date, self::SCREENSHOT_DATE_FORMAT);
    }

    static function mysql_date_now()
    {
        $date_format = self::MYSQL_DATE_FORMAT;
        return date($date_format);
    }

    private static function get_date_in_format($date, $format)
    {
        if ($date == '') {
            return '';
        }
        return date($format, strtotime($date));
    }
}

?>