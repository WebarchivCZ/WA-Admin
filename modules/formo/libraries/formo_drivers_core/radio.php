<?php defined('SYSPATH') or die('No direct script access.');

class Formo_radio_Driver extends Formo_Element {

	public $checked;
	public $values = array();

	public function __construct($name='',$info=array())
	{
		parent::__construct($name, $info);
	}
	
	public function render()
	{
		$checked = ($this->checked === TRUE) ? ' checked="checked"' : '';
		return '<input type="radio" value="'.$this->value.'" name="'.$this->name.'"'.$checked.Formo::quicktagss($this->_find_tags()).' />';
	}

}