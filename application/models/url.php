<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */

class URL_Model extends ORM implements Viewable_Table
{
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
	
	public function table_headers()
	{
		$headers = array
		(
			'id',
			'resource_id',
			'url',
			'valid_from',
			'valid_to',
			'is_seed',
			'comments',
		);
		return $headers;
	}
}

?>