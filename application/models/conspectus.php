<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Conspectus category
 */
class Conspectus_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'category' , 
		'comments');
	
	protected $table_name = 'conspectus';

	protected $default_column = 'category';

	protected $has_many = array(
		'resources');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		parent::__set($key, $value);
	}
}
?>