<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Class representing Contracts
 * Atributes:
 * - contract_no
 * - status
 * - date_signed
 * - comments
 */
class Contact_Model extends Table_Model
{
	public $headers = array('id' , 'name' , 'email' , 'phone' , 'address' , 'publisher' , 'comments');
	
	protected $belongs_to = array('publisher');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>