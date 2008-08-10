<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */

class Contact_Model extends ORM implements Viewable_Table
{
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
	
	public function table_headers()
	{
		$headers = array('id', 'name', 'email', 'phone', 'address', 'publisher_id', 'comments');
		return $headers;
	}
}

?>