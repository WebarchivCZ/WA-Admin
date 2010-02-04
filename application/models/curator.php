<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Curator_Model extends Auth_User_Model 
{

	public $headers = array(
		'id' , 
		'username' , 
		'password' , 
		'firstname' , 
		'lastname' , 
		'email' , 
		'icq' , 
		'skype' ,  
		'comments');

	protected $primary_val = 'vocative';
        protected $sorting = array('username' => 'asc');

	protected $has_many = array('curator_tokens', 'ratings');
	protected $has_and_belongs_to_many = array('roles');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		if ($key === 'firstname' OR $key === 'lastname')
		{
			// Ensure the name is formatted correctly
			$value = ucwords(strtolower($value));
		}
		parent::__set($key, $value);
	}

        public function __get ($column) {
            $value = parent::__get($column);
            if ($column == 'vocative') {
                $value = $this->firstname . ' ' . $this->lastname;
            }
            return $value;
        }
}
?>