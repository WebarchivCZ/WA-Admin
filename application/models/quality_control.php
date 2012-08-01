<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Quality_Control_Model extends Table_Model {

	public $headers = array(
		'id',
		'resource',
		'date',
		'result',
		'comments');

	protected $primary_val = 'proposer';

	protected $belongs_to = array(
		'resources');

	protected $result_array = array(
		0 => 'vyhovujici',
		1 => 'nevyhovujici');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
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
}

?>