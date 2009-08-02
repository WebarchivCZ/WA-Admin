<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Model representing Publishers
 * available attributes
 * 	- id
 * 	- name
 */

class Publisher_Model extends Table_Model
{

	public $headers = array(
		'name');

        protected $primary_val = 'name';
        protected $sorting = array('name' => 'asc');

	protected $has_many = array(
		'contact' , 
		'resource');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}
	
	public function unique_key($id = NULL)
	{
		if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
		{
			return 'name';
		}
	return parent::unique_key($id);
}
	
}

?>