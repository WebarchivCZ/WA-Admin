<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */

class Contract_Model extends Table_Model 
{
	protected $default_column = 'contract_no';
	public $headers = array('id', 'contract_no', 'date_signed', 'comments');
	
	public function _construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}	
}
?>