<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model
 */
class Suggested_By_Model extends Table_Model {

	public $headers = array(
		'id',
		'proposer',
		'comments');

	protected $table_name = 'suggested_by';

	protected $primary_val = 'proposer';

	protected $has_many = array(
		'resources');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set($key, $value)
	{
		if ($key === 'proposer' and strlen($value) > 45)
		{
			throw new InvalidArgumentException('Jmeno navrhovatele je prilis dlouhe');
		}
		parent::__set($key, $value);
	}
}

?>