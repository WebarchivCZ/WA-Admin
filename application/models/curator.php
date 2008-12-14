<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Curator_Model extends User_Model
{

	public $headers = array(
		'id' , 
		'username' , 
		'password' , 
		'firstname' , 
		'lastname' , 
		'email' , 
		'icq' , 
		'skype' , 
		'role' , 
		'comments');

	protected $default_column = 'username';

	protected $belongs_to = array(
		'role');

	protected $has_many = array(
		'ratings');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'firstname' OR $key === 'lastname')
		{
			// Ensure the name is formatted correctly
			$value = ucwords(strtolower($value));
		}
	}

	public function add_role ($role)
	{
		if ($role instanceof Role_Model)
		{
			$this->role_id = $role->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}
}
?>