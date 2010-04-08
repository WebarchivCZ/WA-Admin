<?php
defined ( 'SYSPATH' ) or die ( 'No direct script access.' );
class Qa_Check_Model extends Table_Model {

    protected $primary_val = 'id';

    protected $belongs_to = array ('resource', 'curator');

    protected $has_many = array('qa_problems' => 'qa_check_problems');

    protected static $result_array = array (1 => 'v pořádku', 0 => 'akceptovatelné', - 1 => 'nevyhovující' );

    public function __construct($id = NULL) {
        parent::__construct ( $id );
    }

    public function __set($key, $value) {
        if ($key === 'date_checked' OR $key === 'date_crawled') {
            if ($value == '') {
                $value = NULL;
            } else {
            	$value = str_replace(' ', '', $value);
                $date = new DateTime($value);
                $value = $date->format(DATE_ATOM);
            }
        }
        parent::__set($key, $value);
    }
    
    public function __get($column) {
        $value = parent::__get($column);
        if ($column === 'date_checked' OR $column === 'date_crawled') {
            if ( ! is_null($value)) {
                return date_helper::short_date($value);
            }
        }
        return $value;
    }
    public static function get_result_array() {
        return self::$result_array;
    }

    public static function get_result_value($value) {
        return self::$result_array[$value];
    }

    public static function get_checks ($qa_result = NULL, $curator_id = NULL) {
        $conditions = array();
        if ( ! is_null($qa_result) AND is_int($qa_result)) {
            $conditions['result'] = $qa_result;
        }
        if ( ! is_null($curator_id)) {
            $conditions['curator_id'] = $curator_id;
        }
        $qa_checks = ORM::factory('qa_check')->where($conditions)->find_all();
        return $qa_checks;
    }

    public function add_resource($resource) {
        if ($resource instanceof Resource_Model) {
            $this->resource_id = $resource->id;
        } else {
            throw new InvalidArgumentException ( 'Neplatný argument' );
        }
    }

    public function add_curator($curator) {
        if ($curator instanceof Curator_Model) {
            $this->curator_id = $curator->id;
        } else {
            throw new InvalidArgumentException ( 'Neplatný argument' );
        }
    }
}
?>