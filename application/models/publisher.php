<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM for publisher
 * available attributes
 * 	- id
 * 	- name
 */

class Publisher_Model extends Table_Model 
{	
	protected $default_column = 'name';
	
	public $headers = array('id', 'name');
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->has_many = array('contact');
	}
}

?>