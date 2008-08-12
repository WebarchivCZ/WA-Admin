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
	protected $belongs_to = array('publisher');
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
		//$this->publisher_name = ORM::factory('publisher', $this->publisher_id)->name;
		//$this->publisher = $this->publisher->name;
	}
	
	public function table_headers()
	{
		$headers = array('id', 'name', 'email', 'phone', 'address', 'publisher', 'comments');
		return $headers;
	}

}

?>