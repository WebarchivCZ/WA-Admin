<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Suggested_By_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'proposer' , 
		'comments');

	protected $default_column = 'proposer';

	protected $has_many = array(
		'resources');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'proposer' and strlen($value) > 45)
		{
			throw new InvalidArgumentException('Jmeno navrhovatele je prilis dlouhe');
		}
	}
}
?>