<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Nomination
 */

class Nomination_Model extends Table_Model {

	protected $primary_key = 'resource_id';

	protected $belongs_to = array('resource',
		'proposer' => 'curator');

	//protected $sorting = array('resource.conspectus_id' => 'asc', 'resource.title' => 'asc');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
		if (is_null($id))
		{
			$this->date_nominated = date_helper::mysql_datetime_now();
		}
	}

	public function __get($key)
	{
		$value = parent::__get($key);
		if ($value != '' AND $key == 'date_nominated' OR $key == 'date_resolved')
		{
			$value = date_helper::short_date($value);
		}
		return $value;
	}

	public function __set($column, $value)
	{
		if ($column === 'accepted')
		{
			$value = ($value === TRUE) ? "1" : "0";
		}
		parent::__set($column, $value);
	}

	public static function get_new($curator_id, $filter = NULL)
	{
		$conditions = array('resource.curator_id' => $curator_id,
							'accepted'            => NULL);
		if ($filter != NULL)
		{
			$conditions['resource.conspectus_id'] = $filter['conspectus'];
			if ($filter['conspectus_subcategory'] != '')
			{
				$conditions['resource.conspectus_subcategory_id'] = $filter['conspectus_subcategory'];
			}
		}
		return ORM::factory('nomination')
			->with('resource')
			->where($conditions)
			->find_all();
	}
}

?>