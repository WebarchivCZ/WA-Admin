<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */

class Contract_Model extends ORM implements Viewable_Table
{
	
	public function _construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
		$this->_set_status();
	}
	
	public function table_headers()
	{
		$headers = array('id', 'contract_no', 'status', 'date_signed', 'comments');
		return $headers;
	}
	
	// TODO status - rozpoznavani
	private function _set_status() {
		$status = $this->__get('status');
		$s = 'neznamy';
		switch ($status)
		{
			case '1':
				$s = 'v poradku';
				break;
			default:
				$s = 'nezname';
				break;
		}
		$this->__set('status', $s);
	}
}

?>