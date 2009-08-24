<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Contact_Model extends Table_Model
{

	public $headers = array(
		'name',
                'email',
		'publisher'
	);

	protected $primary_val = 'email';
        protected $sorting = array('email' => 'asc');

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
		}
		parent::__set($key, $value);
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