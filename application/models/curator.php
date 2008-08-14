<?php defined('SYSPATH') or die('No direct script access.');

class Curator_Model extends User_Model  
{
	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
	
}

?>