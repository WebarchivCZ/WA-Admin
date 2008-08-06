<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM for publisher
 * available attributes
 * 	- id
 * 	- name
 */

class Publisher_Model extends ORM  {
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}	
}

?>