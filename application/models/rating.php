<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Rating_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'curator' ,
		'resource' , 
		'rating' , 
		'date' , 
		'round' );

	protected $primary_val = 'rating';

	protected $belongs_to = array(
		'publisher' , 
		'resource',
                'curator');

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

	public function add_curator ($curator)
	{
		if ($curator instanceof Curator_Model)
		{
			$this->curator_id = $curator->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}
}
?>