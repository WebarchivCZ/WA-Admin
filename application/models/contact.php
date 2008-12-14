<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Contact_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'name' , 
		'email' , 
		'phone' , 
		'address' , 
		'publisher' , 
		'position' , 
		'comments');

	protected $default_column = 'name';

	protected $belongs_to = array(
		'publisher');

	protected $has_many = array(
		'resources');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'name')
		{
			// Ensure the name is formatted correctly
			$value = ucwords(strtolower($value));
		} else if ($key === 'phone') {
			// Validate phone number
			if ( ! valid::phone($value)) {
				throw new InvalidArgumentException;
			}
		}
	}

	public function add_publisher ($publisher)
	{
		if ($publisher instanceof Publisher_Model)
		{
			$this->publisher_id = $publisher->id;
		} else
		{
			throw new InvalidArgumentException;
		}
	}
}
?>