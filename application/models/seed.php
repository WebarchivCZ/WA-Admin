<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Seed_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'resource' , 
		'url' , 
		'seed_status' , 
		'redirect' , 
		'valid_from' , 
		'valit_to' , 
		'comments');

	protected $default_column = 'url';

	protected $belongs_to = array(
		'resources' , 
		'seed_status');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function add_resource ($resource)
	{
		if ($resource instanceof Resource_Model)
		{
			$this->resource_id = $resource->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}

	public function add_seed_status ($seed_status)
	{
		if ($seed_status instanceof Seed_Status_Model)
		{
			$this->seed_status_id = $seed_status->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}
}
?>