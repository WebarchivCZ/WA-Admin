<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Role_Model extends Auth_Role_Model {

	public $headers = array(
		'id',
		'role',
		'comments');

	protected $primary_val = 'role';

	protected $has_and_belongs_to_many = array('curators');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set($key, $value)
	{
		if ($key === 'role' AND strlen($value) > 45)
		{
			throw new InvalidArgumentException('Nazev role je prilis dlouhy');
		}
		parent::__set($key, $value);
	}
}

?>