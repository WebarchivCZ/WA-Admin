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