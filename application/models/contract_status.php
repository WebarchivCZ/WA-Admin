<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */

class Contract_Status_Model extends Table_Model 
{
	protected $table_name = 'contract_status';	
	protected $default_column = 'status';
	public $headers = array('id', 'status', 'comments');
	protected $belongs_to = array('contract');
	
	public function _construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
}
?>