<?php defined('SYSPATH') or die('No direct script access.');

class Formo_checkbox_Driver extends Formo_Element {

	public $checked;
	public $values = array();

	public function __construct($name='',$info=array())
	{
		parent::__construct($name,$info);
		
		if ( ! $this->value)
		{
			$this->value = $name;
		}		
	}
	
	public function render()
	{
		$checked = ($this->checked === TRUE) ? ' checked="checked"' : '';
		return '<input type="checkbox" value="'.$this->value.'" name="'.$this->name.'"'.$checked.Formo::quicktagss($this->_find_tags()).' />';
	}
	
	protected function validate_this()
	{
		$this->was_validated = TRUE;
		if ($this->required AND ! Input::instance()->post($this->name))
		{
			$this->error = $this->required_msg;
			return $this->error;
		}
	}
	
	public function add_post($value)
	{
		$this->checked = ($value AND $value == $this->value) ? TRUE : FALSE;
	}

}