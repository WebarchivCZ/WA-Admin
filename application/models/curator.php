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
	 * @param Resource_Model $for_resource Rated resource
	 * @return
	 */
	public static function get_curators_for_rating($for_resource)
	{
		return ORM::factory('curator')->where('active', 1)->find_all();
	}
}
