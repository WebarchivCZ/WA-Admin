<?php defined('SYSPATH') or die('No direct script access.');

class Formo_select_Driver extends Formo_Element {
	
	public $values = array();

	public function __construct($name='',$info=array())
	{
		parent::__construct($name, $info);
	}
	
	public function render()
	{
		$sel = '';
		$sel.= '<select name="'.$this->name.'"'.Formo::quicktagss($this->_find_tags()).">"."\n";
		foreach ($this->values as $k=>$v) {
			$k = preg_replace('/_[bB][lL][aA][nN][kK][0-9]*_/','',$k);
			$selected = ($v == $this->value) ? " selected='selected'" : '';
			$sel .= "\t\t".'<option value="'.$v.'"'.$selected.'>'.$k.'</option>'."\n";
		}
		$sel.= "</select>";	
		return $sel;
	}

}