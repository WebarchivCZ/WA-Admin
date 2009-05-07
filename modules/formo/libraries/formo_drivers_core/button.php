<?php defined('SYSPATH') or die('No direct script access.');

class Formo_button_Driver extends Formo_Element {

	public function __construct($name='',$info=array())
	{
		parent::__construct($name,$info);
		
		$this->value = $name;
	}

	public function render()
	{
		return '<button name="'.$this->name.'"'.Formo::quicktagss($this->_find_tags()).'>'.$this->value.'</button>';
	}
	
	protected function build()
	{
		return "\t".$this->open
			  .$this->element()
			  .$this->close."\n";
	}	

	public function add_post()
	{
		return;
	}

	public function validate_this()
	{
		return;
	}
	
	public function get_value()
	{
		return FALSE;
	}	

}