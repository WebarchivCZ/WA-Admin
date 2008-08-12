<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM for publisher
 * available attributes
 * 	- id
 * 	- name
 */

class Publisher_Model extends ORM implements Viewable_Table
{	
	public $default = 'name';
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->has_many = array('contact');
	}	
	
	public function table_headers()
	{
		$headers = array('id', 'name', 'comments');
		return $headers;
	}
	
	public function __toString() {
		return $this->name;
	}
}

?>