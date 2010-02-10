<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Correspondence_Model extends Table_Model {

    protected $primary_val = 'result';
    protected $sorting = array('date' => 'asc');

    protected $table_name = 'correspondence';

    protected $belongs_to = array('correspondence_type', 'resource');

    public $formo_ignores = array('resource_id');

    public function __construct ($id = NULL) {
        parent::__construct($id);
    }

    public $headers = array(
            'resource' ,
            'date' ,
            'correspondence_type' ,
            'result');

    public function  __get($column) {
        $value = parent::__get($column);
        if ($column == 'date') {
            if ($value == '') {
                $value = '';
            } else {
                $value = date_helper::short_date($value);
            }
        }
        return $value;
    }

    public function __set($key, $value) {
        if ($key === 'date') {
            if ($value == '') {
                $value = NULL;
            } else {
                $date = new DateTime($value);
                $value = $date->format(DATE_ATOM);
            }
        }
        parent::__set($key, $value);
    }

    public function table_view($limit = NULL, $offset = NULL) {
        $records = ORM::factory('resource')->join('correspondence', 'correspondence.resource_id = resources.id')
                ->groupby('resources.id')
                ->find_all($limit, $offset);

        return $records;
    }

    public function count_table_view() {
        $count = ORM::factory('resource')->join('correspondence', 'correspondence.resource_id = resources.id')
                ->groupby('resources.id')
                ->find_all()->count();
        return $count;
    }

    public function search($pattern, & $count, $limit = 20, $offset = 0) {
        // TODO - prazvlastni vec. nefunguje count_all
        $count = ORM::factory('resource')->like('title', $pattern)
                ->join('correspondence', 'correspondence.resource_id = resources.id')
                ->groupby('resources.id')
                ->find_all()->count();

        $records = ORM::factory('resource')->like('title', $pattern)
                ->join('correspondence', 'correspondence.resource_id = resources.id')
                ->groupby('resources.id')
                ->find_all($limit, $offset);
        //$count = $records->count_all();
        return $records;
    }
}

?>