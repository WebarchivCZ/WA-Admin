<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Correspondence_Model extends Table_Model
{

	protected $primary_val = 'result';
	
	protected $table_name = 'correspondence';

        protected $belongs_to = array('correspondence_type', 'resource');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public $headers = array(
		'id' , 
		'resource' , 
		'date' , 
		'correspondence_type' ,
		'result');

}

?>