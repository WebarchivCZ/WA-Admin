<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * ORM for publisher
 * available attributes
 * 	- id
 * 	- name
 */

class Crawl_Freq_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'frequency' , 
		'comments');

	protected $table_name = 'crawl_freq';

	protected $primary_val = 'frequency';

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'frequency' and strlen($value) > 45)
		{
			throw new InvalidArgumentException('Pojmenovani frekvence sklizeni je prilis dlouhe');
		}
		parent::__set($key, $value);
	}
}

?>