<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing type of a seed
 */
class Seed_Type_Model extends Table_Model {

	public $headers = array(
		'id',
		'type',
		'comments');

	public function __get($column)
	{
		$value = parent::__get($column);
		if ($column == 'type' AND $value == '')
		{
			return 'normal';
		}
		return $value;
	}


	protected $primary_val = 'type';
	protected $has_many = array('seeds');
}

?>