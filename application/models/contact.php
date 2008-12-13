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
	
	protected $default_column = 'name';
	protected $belongs_to = array('publisher');
	protected $has_many = array('resource');

	public function __construct($id = NULL)
	{
		parent::__construct($id);
	}
}
?>