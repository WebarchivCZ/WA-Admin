<?php
defined('SYSPATH') or die ('No direct script access.');
/**
 * Model representing Contacts
 */
class Curator_Model extends Auth_User_Model {

	public $headers = array('id', 'username', 'password', 'firstname', 'lastname', 'email', 'icq', 'skype', 'comments');

	protected $primary_val = 'vocative';
	protected $sorting = array('username' => 'asc');

	protected $has_many = array('curator_tokens', 'ratings');
	protected $has_and_belongs_to_many = array('roles');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set($key, $value)
	{
		if ($key === 'firstname' or $key === 'lastname')
		{
			// Ensure the name is formatted correctly
			$value = ucwords(strtolower($value));
		}
		parent::__set($key, $value);
	}

	public function __get($column)
	{
		$value = parent::__get($column);
		if ($column == 'vocative')
		{
			$value = $this->firstname.' '.$this->lastname;
		}
		return $value;
	}

	/**
	 * Function check if curator can close final rating for resource
	 * @param $resource_id
	 * @return bool true if curator can close rating
	 */
	public function could_close_rating($resource_id)
	{
		$resource = new Resource_Model($resource_id);
		$is_curated = $resource->is_curated_by($this);
		return $is_curated && $resource->is_ratable();
	}

	/**
	 * Get active curators for resource,
	 *
	 * TODO Feature - activate&deactivate curators
	 * @param Resource_Model $resource_id Rated resource
	 * @return
	 */
	public static function get_curators_for_rating($resource_id)
	{
//		$sql = "select resources.date as date_start,
//        if (rating_rounds.date_closed is null, now(), max(rating_rounds.date_closed)) as date_end
//		from resources, rating_rounds
//  		where rating_rounds.resource_id = resources.id and resource_id = ${resource_id}
//          and rating_rounds.id = (select max(rating_rounds.id) from rating_rounds where resource_id = ${resource_id});";
		$sql = "select c.* from curators c, curators_roles cr, resources r
				WHERE cr.role_id = 2
				AND c.id = cr.curator_id
 				AND c.active = 1
 				AND (c.active_to >= r.date OR c.active_to IS NULL)
 				AND r.id = $resource_id";
		$id_array = sql::get_id_array($sql, 'id');
		return ORM::factory('curator')->in('id', $id_array)->find_all();
	}
}
