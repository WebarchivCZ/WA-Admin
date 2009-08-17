<?php
class date_helper
{
    /**
     * Formatovani data podle configu na kratky format
     * @param DATETIME $long_date
     */
    static function short_date($long_date)
    {
        $format = Kohana::config('wadmin.short_date_format');
        $date = date($format, strtotime($long_date));
        return $date;
    }
}
?>