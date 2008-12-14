<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Resource_Status_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'status' ,
		'comments');

	protected $default_column = 'status';

	protected $has_many = array('resources');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'status' AND strlen($value) > 45)
		{
			throw new InvalidArgumentException('Nazev statusu je prilis dlouhy');
		}
	}
}
?>