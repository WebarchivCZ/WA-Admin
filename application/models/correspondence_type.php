<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Correspondence_Type_Model extends Table_Model
{

	protected $primary_val = 'type';
	
	protected $table_name = 'correspondence_type';

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

}

?>