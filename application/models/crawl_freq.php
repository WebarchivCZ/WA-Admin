<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM for publisher
 * available attributes
 * 	- id
 * 	- name
 */

class Crawl_Freq_Model extends Table_Model 
{	
	public $headers = array('id', 'frequency');
	protected $table_name = 'crawl_freq';
	
	protected $default_column = 'frequency';
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}

?>