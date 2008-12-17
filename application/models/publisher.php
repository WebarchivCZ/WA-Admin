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
		'id' , 
		'name' , 
		'comments');

	protected $default_column = 'name';

	protected $has_many = array(
		'contact' , 
		'resource');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}
	
}

?>