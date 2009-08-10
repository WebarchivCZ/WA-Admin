<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Seed
 */
class Seed_Model extends Table_Model
{
	public $headers = array(
                'id',
		'resource' ,
		'url' ,
                'seed_status' ,
		'valid_from' , 
		'valid_to');

	protected $primary_val = 'url';

	protected $belongs_to = array(
		'resource', 'seed_status');

        public function __get($column) {
            $value = parent::__get($column);
            if ($this->__isset($column) AND ($column == 'valid_to' OR $column == 'valid_from')) {
                $date_format = Kohana::config('wadmin.short_date_format');
                $value = date($date_format, strtotime($value));
            }
            return $value;
        }

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}
	
	public function __set($key, $value) {
		if($key == 'valid') {
			$value = date('Y-m-d');
			if((boolean) $value) {
				$key = 'valid_from';
			} else {
				$key = 'valid_to';
			}
		}
		parent::__set($key, $value);
	}

	public function add_resource ($resource)
	{
		if ($resource instanceof Resource_Model)
		{
			$this->resource_id = $resource->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}
}
?>