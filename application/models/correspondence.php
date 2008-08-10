<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */

class Correspondence_Model extends ORM implements Viewable_Table
{
	public function __construct($id = NULL)
	{
		$this->table_name = 'correspondence';
		parent::__construct($id);
	}
	
	public function table_headers()
	{
		$headers = array
		(
			'id',
			'resources_id',
			'date',
			'type',
			'result',
			'comments',
		);
		return $headers;
	}
}

?>