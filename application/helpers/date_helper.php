<?php
class date_helper {
    const MYSQL_DATE_FORMAT = 'Y-m-d H:i:s';
    
    /**
     * Formatovani data podle configu na kratky format
     * @param DATETIME $long_date
     */
    static function short_date($long_date) {
        $format = Kohana::config('wadmin.short_date_format');
        $date = date($format, strtotime($long_date));
        return $date;
    }
    
    static function mysql_date_now() {
        $date_format = self::MYSQL_DATE_FORMAT;
        return date($date_format);
    }
}
?>