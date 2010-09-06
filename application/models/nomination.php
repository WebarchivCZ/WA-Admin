<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Nomination
 */

class Nomination_Model extends Table_Model {
    
	protected $primary_key = 'resource_id';
	
    protected $belongs_to = array ('resource');
    
    protected $sorting = array('resource.conspectus_id' => 'asc', 'resource.title' => 'asc');
    
    public function __construct($id = NULL) {
        parent::__construct($id);
        if (is_null($id)) {
            $this->date_nominated = date_helper::mysql_date_now();
        }
    }
    
    public function __set($column, $value) {
    	if ($column === 'accepted') {
    		$value = ($value === true) ? "1" : "0";
    	}
    	parent::__set($column, $value);
    }

    public static function get_new($curator_id, $filter = null) {
    	$conditions = array('resource.curator_id' => $curator_id,
    						'accepted' => null);
    	if ($filter != null) {
    		$conditions['resource.conspectus_id'] = $filter['conspectus'];
    		if ($filter['conspectus_subcategory'] != '') {
    			$conditions['resource.conspectus_subcategory_id'] = $filter['conspectus_subcategory'];
    		}
    	}
    	return ORM::factory('nomination')
    			->with('resource')
    			->where($conditions)
    			->find_all();
    }
}
?>