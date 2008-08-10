<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM for publisher
 * available attributes
 * 	- id
 * 	- name
 */

class Publisher_Model extends ORM implements Viewable_Table
{
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}	
	
	public function table_headers()
	{
		$headers = array('id', 'name', 'comments');
		return $headers;
	}
}

?>