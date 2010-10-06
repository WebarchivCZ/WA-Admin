<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Rating_Model extends Table_Model {
    
    public $headers = array ('curator', 'resource', 'rating', 'date', 'round');
    
    protected static $rating_values = array ('NULL' => '', '-2' => 'ne', '-1' => 'spíše ne', '0' => 'možná', '1' => 'spíše ano', '2' => 'ano', '4' => 'technické ne');
    
    protected static $ratings_result = array ('NULL' => NULL, '1' => 'NE', '2' => 'ANO', '3' => 'MOŽNÁ', '4' => 'TECHNICKÉ NE');
    
    protected $primary_val = 'rating';
    protected $sorting = array ('date' => 'asc');
    
    protected $belongs_to = array ('publisher', 'resource', 'curator');
    
    public function __construct($id = NULL) {
        parent::__construct($id);
    }
    
    public function __get($column) {
        $value = parent::__get($column);
        
        if ($column == 'rating') {
            $value = self::$rating_values [$value];
        }
        
        if ($column == 'tech_problems') {
            if ($value == TRUE) {
                $value = 'ANO';
            } else {
                $value = 'NE';
            }
        }
        if ($column === 'date') {
            if ( ! is_null($value)) {
                $value = date('d.m.Y', strtotime($value));
            }
        }
        return $value;
    }
    
    public function __set($key, $value) {
        if ($key == 'date') {
            $date = new DateTime($value);
            $value = $date->format(DATE_ATOM);
        }
        parent::__set($key, $value);
    }
    
    public function add_resource($resource) {
        if ($resource instanceof Resource_Model) {
            $this->resource_id = $resource->id;
        } else {
            throw new InvalidArgumentException();
        }
    }
    
    public function add_curator($curator) {
        if ($curator instanceof Curator_Model) {
            $this->curator_id = $curator->id;
        } else {
            throw new InvalidArgumentException();
        }
    }
    
    public function table_view($limit = 0, $offset = 0) {
        $result = Resource_Model::get_rated_resources(1, $limit, $offset);
        return $result;
    }
    
    public function count_table_view() {
        $count = Resource_Model::get_rated_resources(1)->count();
        return $count;
    }
    
    public function search($pattern, & $count, $limit = 20, $offset = 0) {
        $count = Resource_Model::get_rated_resources(1, NULL, NULL, $pattern)->count();
        $records = Resource_Model::get_rated_resources(1, $limit, $offset, $pattern);
        return $records;
    }
    
    public function get_rating() {
        return parent::__get('rating');
    }
    
    public static function get_final_array() {
        
        return self::$ratings_result;
    }
    
    public static function get_final_rating($value) {
        if (is_string($value)) {
            $ratings = self::get_final_array();
            return array_search($value, $ratings);
        } else {
            return FALSE;
        }
    }
    
    public static function get_rating_values() {
        return self::$rating_values;
    }
    
    public static function find_resources($user_id, $resource_status = RS_NEW, $only_rated = FALSE) {
        $db = Database::instance();
        
        $round = ($resource_status == RS_NEW) ? ' = 1': ' >= 2';
        $reevaluate_constraint = '';

        if ($resource_status == RS_RE_EVALUATE) {
            $reevaluate_constraint = 'AND reevaluate_date <= CURDATE()';
        }
        if ($only_rated == TRUE) {
            $sql_query = "SELECT g.resource_id AS id
                            FROM ratings g, curators c, resources r
                            WHERE r.curator_id = {$user_id}
                            AND g.resource_id = r.id
                            AND g.curator_id = c.id
                            AND g.round {$round}
                            AND r.resource_status_id = {$resource_status}
                    {$reevaluate_constraint}
                            GROUP BY g.resource_id
                            HAVING count( * ) >= 1
                        ORDER BY count(g.resource_id) ASC
                    ";
        } else {
            $sql_query = "SELECT r.id
                        FROM `resources` r
                        WHERE r.resource_status_id = {$resource_status}
                        AND r.id NOT IN
                        (
                            SELECT r.id
                            FROM resources r, curators c, ratings g
                            WHERE r.id = g.resource_id
                            AND c.id = g.curator_id
                            AND c.id = {$user_id}
                            AND g.round > r.rating_last_round
                        )
                    {$reevaluate_constraint}
                        ORDER BY field(suggested_by_id, 2, 1, 3, 4)";
        }
        $query = $db->query($sql_query);

// TODO refaktorovat - stejna metoda v addressing
        $id_array = array();
        foreach($query->result_array(FALSE) as $row) {
            array_push($id_array, $row['id']);
        }
        $result = count($id_array) != 0? $id_array : 0;
        return $result;
    }
}
?>