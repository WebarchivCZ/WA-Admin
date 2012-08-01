<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Seed
 */
class Seed_Model extends Table_Model {
	public $headers = array(
		'resource',
		'url',
		'seed_status');

	// to speed up loading editing form
	//public $formo_ignores = array('resource_id');

	protected $sorting = array('url' => 'asc');
	protected $primary_val = 'url';

	protected $belongs_to = array(
		'resource', 'seed_status');

	public $formo_ignores = array('id');

	public function __get($column)
	{
		$value = parent::__get($column);
		if ($this->__isset($column) AND ($column == 'valid_to' OR $column == 'valid_from'))
		{
			$date_format = Kohana::config('wadmin.short_date_format');
			$value = date($date_format, strtotime($value));
		}
		return $value;
	}

	public function __set($key, $value)
	{
		if (($key == 'valid_from' OR $key == 'valid_to') AND $value != '')
		{
			$date = new DateTime($value);
			$value = $date->format(DATE_ATOM);
		}
		parent::__set($key, $value);
	}

	public function table_view($per_page, $offset)
	{
		return $this->join('resources', 'seeds.resource_id = resources.id')
			->orderby('resources.title')
			->find_all($per_page, $offset);
	}

	public function search($pattern, & $count, $limit = 20, $offset = 0)
	{
		$count = $this->orlike(array('url' => $pattern, 'resource'))
			->count_all();
		$records = $this->join('resources', 'resources.id = seeds.resource_id')
			->orlike(array('resources.title' => $pattern,
						   'seeds.url'       => $pattern))
			->find_all($limit, $offset);
		return $records;
	}

	public function add_resource($resource)
	{
		if ($resource instanceof Resource_Model)
		{
			$this->resource_id = $resource->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}

	public function delete_record()
	{
		return $this->delete();
	}
}

?>