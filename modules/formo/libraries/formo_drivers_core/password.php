<?php defined('SYSPATH') or die('No direct script access.');

class Formo_password_Driver extends Formo_Element {
	
	public function __construct($name='',$info=array())
	{
		parent::__construct($name, $info);
	}
	
	public function render()
	{
		return '<input type="password" name="'.$this->name.'"'.Formo::quicktagss($this->_find_tags()).'" />';
	}

}