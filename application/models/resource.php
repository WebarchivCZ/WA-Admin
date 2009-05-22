<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing resource
 *
 */
class Resource_Model extends Table_Model
{

	protected $primary_val = 'title';

	public $headers = array(
		'title',
		'url',
		'publisher'
	);
	
	/**public $headers = array(
		'id' , 
		'curator' , 
		'contact' , 
		'publisher' , 
		'contract' , 
		'title' , 
		'url' , 
		'rating_result' , 
		'suggested_by' , 
		'date' , 
		'aleph_id' , 
		'ISSN' , 
		'conspectus' , 
		'resource_status' , 
		'creative_commons' , 
		'metadata' , 
		'catalogued' , 
		'crawl_freq' , 
		'tech_problems' , 
		'comments');
*/

	protected $belongs_to = array(
		'contact' , 
		'curator' , 
		'publisher' , 
		'contract' , 
		'conspectus' , 
		'crawl_freq' , 
		'resource_status' , 
		'suggested_by');

	protected $has_many = array(
		'seeds' , 
		'ratings' , 
		'correspondence' , 
		'quality_control');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
		//TODO format presunout do configu
		$format = 'Y-m-d h:m:s';
		$this->date = date($format);
	}
	
	public function __set ($key, $value) {
				//TODO format presunout do configu
		
		if (($key === 'metadata' OR $key === 'catalogued') AND $value == TRUE) {
			$format = 'Y-m-d h:m:s';
			$value = date($format);
		}
		parent::__set($key, $value);
	}
	
	public function __get ($column) {
		if ($column === 'date' OR $column === 'metadata' OR $column === 'catalogued') {
			$value = parent::__get($column);
			if ( ! is_null($value)) {
				return date('d.m.Y', strtotime($value));
			}
		}
		return parent::__get($column);
	}

	public function is_related ($column)
	{
		return in_array($column, $this->belongs_to);
	}

	public function add_curator ($curator)
	{
		if ($curator instanceof Curator_Model)
		{
			$this->curator_id = $curator->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}

	public function add_publisher ($publisher)
	{
		if ($publisher instanceof Publisher_Model)
		{
			$this->publisher_id = $publisher->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}

        public function compute_rating($round = 1) {
            $ratings = ORM::factory('rating')->where(array('resource_id'=> $this->id))->find_all();
            return $ratings->count();
        }
	
}
?>