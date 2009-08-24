<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Correspondence_Model extends Table_Model
{

	protected $primary_val = 'result';
        protected $sorting = array('date' => 'asc');
	
	protected $table_name = 'correspondence';

        protected $belongs_to = array('correspondence_type', 'resource');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public $headers = array(
		'resource' , 
		'date' , 
		'correspondence_type' ,
		'result');

        public function  __get($column)
        {
            $value = parent::__get($column);
            if ($column == 'date') {
                if ($value == '') {
                    $value = '';
                } else {
                    $value = date_helper::short_date($value);
                }
            }
            return $value;
        }

}

?>