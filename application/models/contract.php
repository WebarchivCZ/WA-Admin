<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Contract_Model extends Table_Model
{

	protected $default_column = 'contract_no';

	public $headers = array(
		'id' , 
		'contract_no' , 
		'date_signed' , 
		'addendum' , 
		'cc' , 
		'comments');

	public function _construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'cc' OR $key === 'addendum')
		{
			$value = (boolean) $value;
		}
		parent::__set($key, $value);
	}
}
?>