<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Correspondence_Model extends Table_Model
{

	protected $default_column = 'result';
	
	protected $table_name = 'correspondence';

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public $headers = array(
		'id' , 
		'resources_id' , 
		'date' , 
		'type' , 
		'result' , 
		'comments');

}

?>