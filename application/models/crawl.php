<?php
defined ( 'SYSPATH' ) or die ( 'No direct script access.' );
class Crawl_Model extends Table_Model {
    protected $primary_val = 'date';

    public static function get_last_crawl () {
        return self::factory('crawl')->orderby('date', 'DESC')->limit(1)->find();
    }
}
?>