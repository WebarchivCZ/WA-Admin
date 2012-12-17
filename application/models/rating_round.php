<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing rounds of ratings.
 * Each resource is rated in rounds. Mostly one round is enough, but in some cases -
 * e.g. uncertainty of publisher permission or technical difficulties - new round is
 * created for resource ratings. In that case new round is scheduled for particular date.
 */
class Rating_Round_Model extends Table_Model {
	// db properties
	protected $table_name = 'rating_rounds';

	// relationships
	protected $has_many = array('ratings');
	protected $belongs_to = array('resource', 'curator');

	// table columns
//	public $id, $resource_id, $round, $rating_result, $date_created, $date_closed, $closing_curator;

	public function get_curator_rating($curator_id)
	{
		return ORM::factory('rating')->where(array('curator_id'  => $curator_id,
												   'round_id'    => $this->id,
												   'resource_id' => $this->resource_id))->find();
	}

	public function get_active_curators()
	{
		if ($this->rating_result == "")
		{
			$sql = "select c.id from curators c, curators_roles cr, rating_rounds r
				WHERE cr.role_id = 2
				AND c.id = cr.curator_id
 				AND c.active = 1
 				AND (c.active_to >= r.date_created OR c.active_to >= now() OR c.active_to IS NULL)
 				AND r.resource_id = {$this->resource_id}";
		} else
		{
			$sql = "select c.id from curators c, curators_roles cr, rating_rounds r
				WHERE cr.role_id = 2
				AND c.id = cr.curator_id
 				AND c.active = 1
 				AND (c.active_to >= r.date_created OR c.active_to IS NULL)
 				AND (c.active_from <= r.date_closed OR c.active_from IS NULL)
 				AND r.resource_id = {$this->resource_id}";
		}
		$curator_ids = sql::get_id_array($sql);
		return ORM::factory('curator')->in('id', $curator_ids)->find_all()->as_array();
	}

	public function is_open()
	{
		return ($this->__isset('date_closed')) ? TRUE : FALSE;
	}

	public function foreign_key($table = NULL, $prefix_table = NULL)
	{
		return 'round_id';
	}

	public function id()
	{
		return $this->__get('id');
	}


}

?>