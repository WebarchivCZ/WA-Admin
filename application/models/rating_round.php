<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing rounds of ratings.
 * Each resource is rated in rounds. Mostly one round is enough, but in some cases -
 * e.g. uncertainty of publisher permission or technical difficulties - new round is
 * created for resource ratings.
 */
class Rating_Round_Model extends Table_Model {
	// db properties
	protected $table_name = 'rating_rounds';

	// relationships
	protected $has_many = array('rating');
	protected $belongs_to = array('resource', 'curator');

	// table columns
	public $id, $resource_id, $round, $rating_result, $date_created, $date_closed, $closing_curator;
}

?>