<?php defined('SYSPATH') or die('No direct script access.');

/*
	Version .75
	avanthill.com/formo_manual/

	
	Requires Formo and Formo_Group
	Kohana 2.2
*/

class Formo_Group_Core {

	public $name;
	public $name_is_array = FALSE;
	public $type = 'checkbox';
	public $elements = array();
	
	public $open = "<p>";
	public $close = "</p>";
	public $group_open = "<div style='float:left;margin-bottom:1em' {class}>";
	public $group_close = "</div>";
	public $class;
	
	public $element_label = 'close';
	public $element_space = '';
	
	public $required = TRUE;
	
	public $error;
	public $required_msg = 'Required';
	public $error_msg = 'Invalid';
	public $error_open = '<span class="{error_msg_class}">';
	public $error_close = '</span>';
	public $error_class = 'errorInputGroup';
	public $error_msg_class = 'errorMessage';
	
	private $_elements_string;

	/**
	 * Does all the necessary creating
	 *
	 */	
	function __construct($type, $name, $values, $info=array())
	{
		$this->type = $type;
		$this->name = strtolower(preg_replace('/\[\]/', '', $name));
		$this->name_is_array = (preg_match('/\[\]/', $name)) ? TRUE : FALSE;
		
		foreach ($values as $key=>$value)
		{
			$this->add($type, $key, $value, $info);
		}
	}

	/**
	 * Factory method. Returns a new Element_Group object
	 *
	 * @return object
	 */
	public static function factory($type, $name, $values, $info=array())
	{
		return new Formo_Group($type, $name, $values, $info);
	}

	/**
	 * Magic __set method. Keeps track of elements added to object
	 *
	 */
	public function __set($var, $val)
	{
		if (is_object($val) AND get_class($val) == 'Formo_Element')
		{
			$this->elements[$var] = $val->value;
		}
		$this->$var = $val;
	}
	
	/**
	 * Magic __toString method. Returns all formatted elements without label
	 * or open and close.
	 *
	 * @return  string
	 */
	public function __toString()
	{
		return $this->get();
	}
	
	public function add($type, $name, $value, $info)
	{
		$info['value'] = $value;
		$info['label'] = preg_replace('/\[[a-zA-Z0-9_ ]*\]/','', $name);
		
		$label_place = ($this->element_label == 'open') ? 'element_open' : 'element_close';
		$space_place = ($label_place == 'element_open') ? 'element_close' : 'element_open';
		
		$search = array
		(
			'/\[[a-zA-Z0-9_ ]*\]/',
			'/{/',
			'/}/'
		);
		
		$info[$label_place] = ' '.preg_replace($search, '', $name).' ';
		$info[$space_place] = $this->element_space;		
		

		$element_name = ($this->name_is_array) ? $this->name.'[]' : $this->name;
				
		if ($this->name_is_array AND preg_match('/\[([a-zA-Z0-9_ ]+)\]/', $name, $matches))
		{
			$element_name = $this->name.'['.$matches[1].']';
		}
		$this->{strtolower($name)} = new Formo_Element($type, $element_name, $info);
	}

	/**
	 * validate method. run validation through all elements in group
	 *
	 */	
	function validate()
	{
		foreach ($this->elements as $element=>$value)
		{
			$this->$element->validate();
		}
		
		if ($this->required AND ! Input::instance()->post($this->name))
		{
			$this->error = $this->required_msg;
			$this->add_class($this->error_class);
		}
	}

	/**
	 * add_class method. add class to class
	 *
	 */		
	public function add_class($class)
	{
		$this->class = ($this->class) ? $this->class.' '.$class : $class;
	}
	
	/**
	 * _build_error method. turn error into formatted text
	 *
	 */	
	private function _build_error()
	{
		if ($this->error)
		{
			$search = '/{error_msg_class}/';
			$replace = $this->error_msg_class;
			
			return preg_replace($search, $replace, $this->error_open)
			      .$this->error
			      .$this->error_close;
			
			$message = preg_replace('/{error_msg_class}/', $this->error_msg_class, $this->open);
			$message.= $this->error_msg;
			$message.= $this->error_close;
			return $message;
		}
	}

	/**
	 * _build_group_open method. turn open tag into formatted text
	 * or open and close.
	 *
	 * @return string
	 */	
	private function _build_group_open()
	{
		$search = '/{class}/';
		$replace = ' class="'.$this->class.'"';
		if ($this->class)
		{
			$this->group_open = preg_replace($search, $replace, $this->group_open);
		}
		
		return $this->group_open;
	}

	/**
	 * get method. turns all elements in group into formatted elements
	 *
	 * @return  string
	 */			
	public function get()
	{
		foreach ($this->elements as $element=>$type)
		{
			$this->_elements_string.= $this->$element->get(TRUE);
		}
		return $this->open
			  .'<label for="'.$this->name.'">'.$this->name.':</label>'
			  .$this->_build_group_open()
			  .$this->_elements_string
			  .$this->group_close
			  .$this->_build_error()
			  .$this->close;
	}
	
}