<?php defined('SYSPATH') or die('No direct script access.');

class Formo_hidden_Driver extends Formo_Element {
		
	public function __construct($name='',$info=array())
	{
		parent::__construct($name,$info);
	}
	
	public function render()
	{
		$quote = (preg_match('/"/',$this->value)) ? "'" : '"';
		return '<input type="hidden" name="'.$this->name.'" value='.$quote.$this->value.$quote.''.Formo::quicktagss($this->_find_tags()).' />';
	}
	
	protected function build()
	{
		return "\t".$this->render()."\n";
	}

}