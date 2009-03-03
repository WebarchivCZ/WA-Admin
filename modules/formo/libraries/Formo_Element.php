<?php defined('SYSPATH') or die('No direct script access.');

/*
	Version .8
	avanthill.com/formo_manual/
	
	Requires Formo and Formo_Group
	Kohana 2.2
*/

class Formo_Element_Core {
		
	public $order = array('label','element','error');

	public $open = "<p>";
	public $close = "</p>";
	
	public $label;
	public $label_open = '<label for="{name}">';
	public $label_close = ':</label>';
	
	public $element_open;
	public $element_close;
	
	public $type;
	public $name;
	public $value;
	public $checked;
	public $values = array();
	
	public $tags = array();
	
	public $required = TRUE;
	public $rule = array();
	
	public $error_msg = "Invalid";
	public $required_msg = "Required";
	public $show_error;
	public $error;
	public $error_open = '<span class="{error_msg_class}">';
	public $error_close = '</span>';
	public $error_class = 'errorInput';
	public $error_msg_class = 'errorMessage';
	public $file_link_class = 'fileLink';
	
	// uploads
	public $upload_path = 'uploads';
	public $allowed_types;
	public $max_size = '1M';
	public $data = array();
	private $_was_file;

	/**
	 * Magic __toString method. Returns all element without label
	 * or open and close.
	 *
	 * @return  string
	 */	
	function __toString() {
		return $this->get();
	}

	/**
	 * Magic __construct method. creates element object from $type,
	 * $name, and $info
	 *
	 */	
	public function __construct ($type,$name='',$info=array())
	{
		if (strtolower($type) == 'submit')
		{
			if ( ! $name)
			{
				$name = "Submit";
			}
			$info['value'] = ( ! isset($info['value'])) ? $name : $info['value'];
		}
		elseif ( ! $info AND ! $name)
		{
			$name = $type;
			$type = 'text';
		}
		elseif ( ! $info AND (is_array($name) OR preg_match('/=/',$name)))
		{
			$info = $name;
			$name = $type;
			$type = 'text';
		}
		
		$shortcuts = array('/^ta$/','/^sel$/', '/^hid$/');
		$methods = array('textarea','select', 'hidden');
		
		$this->type = preg_replace($shortcuts, $methods, $type);
		$this->name = strtolower($name);
		$this->id = strtolower($name);
		$this->label = $name;
		$this->_into_properties(Formo::quicktags($info));
	}

	/**
	 * Magic __call method. Process shorthand for element type
	 *
	 */	
	public function __call($function, $values)
	{
		$shortcuts = array
		(
			'ta'	=> 'textarea',
			'sel'	=> 'select',
			'cb'	=> 'checkbox',
			'hid'	=> 'hidden'
		);
		if (isset($shortcuts[$function]))
		{
			$func = $shortcuts[$function];
			$this->$func();
		}

	}

	/**
	 * Magic __set method. Keeps track of tags added to element
	 *
	 * @return  string
	 */	
	public function __set($var, $val)
	{
		if ( ! is_object($val))
		{
			$this->tags[] = $var;
			$this->$var = $val;
		}
		elseif (get_class($val) == 'Formo_Element')
		{
			$this->elements[$var] = $val->type;
		}	
	}

	/**
	 * factory method. Returns a Form_Element object
	 *
	 * @return  object
	 */	
	public static function factory($type, $name='', $info=array())
	{
		return new Form_Element($type, $name, $info);
	}

	/**
	 * set method. Gives a tag a value
	 *
	 * @return  object
	 */	
	public function set($tag, $value)
	{
		$this->$tag = $value;
		return $this;
	}

	/**
	 * _into_properties method. Processes $info from
	 * __construct
	 *
	 */	
	private function _into_properties($info)
	{
		foreach ($info as $k=>$v)
		{
			$this->$k = $v;
		}
	}

	/**
	 * add_class method. Adds a class to the object
	 * Creates class tag if it doesn't exist already
	 *
	 */	
	public function add_class($class)
	{
		if (is_array($class))
		{
			foreach ($class as $v)
			{
				$this->add_class($v);
			}
		}
		else
		{
			$this->class = (isset($this->class)) ? $this->class.' '.$class : $class;
		}		
	}

	/**
	 * remove_class method. Removes class from object
	 * Deletes class tag if none exist after function
	 *
	 * @return  object
	 */	
	public function remove_class($class)
	{
		if (is_array($class) AND isset($this->class))
		{
			foreach ($class as $v)
			{
				$this->remove_class($v);
			}
		}
		elseif (isset($this->class))
		{
			$this->class = preg_replace("/ *$class/",'',$this->class);
			if (!$this->class OR $this->class == ' ') {
				$this->_remove_tag('class',TRUE);
			}
		}
	}

	/**
	 * add_rule method. Adds a rule to the object
	 *
	 * @return  object
	 */		
	public function add_rule($rule, $error_msg='')
	{
		if ($rule == 'required')
		{
			$this->required = TRUE;
			$this->required_msg = ($error_msg) ? $error_msg : $this->required_msg;
		}
		
		Formo::into_array($this->rule);
		if (is_array($rule))
		{
			$this->rule = array_merge($this->rule,$rule);
		}
		else
		{
			$error_msg = ($error_msg) ? $error_msg : $this->error_msg;
			$this->rule[] = array('rule'=>$rule, 'error_msg'=>$error_msg);
		}		
	}
		
	/**
	 * _remove_tag method. Adds a class to the object
	 * Creates class tag if it doesn't exist already
	 *
	 * @return  object
	 */	
	private function _remove_tag($tag)
	{
		if (isset($this->$tag))
		{
			unset($this->$tag);
		}
		if ($key = array_keys($this->tags, $tag))
		{
			unset ($this->$tag[$key[0]]);
		}
	}

	/**
	 * _find_tags method. returns an array of all
	 * the tags and its value
	 *
	 * @return  array
	 */		
	private function _find_tags()
	{
		foreach ($this->tags as $tag)
		{
			$tags[$tag] = $this->$tag;
		}
		return $tags;
	}

	/**
	 * html method. returns a custom html element
	 *
	 * @return  string
	 */			
	public function html()
	{
		return $this->value;
	}

	/**
	 * text method. Processes object into formatted text
	 *
	 * @return  text
	 */		
	public function text()
	{
		return '<input type="text" name="'.$this->name.'" id="'.$this->id.'" value="'.$this->value.'"'.Formo::quicktagss($this->_find_tags()).'" />';
	}

	/**
	 * hidden method. Processes object into formatted text
	 *
	 * @return  text
	 */			
	public function hidden()
	{
		$quote = (preg_match('/"/',$this->value)) ? "'" : '"';
		return '<input type="hidden" name="'.$this->name.'" id="'.$this->id.'" value='.$quote.$this->value.$quote.''.Formo::quicktagss($this->_find_tags()).'" />';
	}
	
	/**
	 * password method. Processes object into formatted text
	 *
	 * @return  text
	 */		
	public function password()
	{
		return '<input type="password" name="'.$this->name.'" id="'.$this->id.'"'.Formo::quicktagss($this->_find_tags()).'" />';
	}

	/**
	 * textarea method. Processes object into formatted text
	 *
	 * @return  text
	 */			
	public function textarea()
	{
		return '<textarea name="'.$this->name.'" id="'.$this->id.'"'.Formo::quicktagss($this->_find_tags()).'>'.$this->value.'</textarea>';	
	}

	/**
	 * select method. Processes object into formatted text
	 *
	 * @return  text
	 */			
	public function select()
	{
		$sel = '';
		$sel.= '<select name="'.$this->name.'" id="'.$this->id.'"'.Formo::quicktagss($this->_find_tags()).">"."\n";
		foreach ($this->values as $k=>$v) {
			$k = preg_replace('/_blank[0-9]*_/','',$k);
			$selected = ($v == $this->value) ? " selected='selected'" : '';
			$sel .= "\t\t".'<option value="'.$v.'"'.$selected.'>'.$k.'</option>'."\n";
		}
		$sel.= "</select>";	
		return $sel;
	}

	/**
	 * submit method. Processes object into formatted text
	 *
	 * @return  text
	 */			
	public function submit()
	{	
		return '<input type="submit" name="'.preg_replace('/ /','_',$this->name).'" id="'.preg_replace('/ /','_',$this->id).'" value="'.$this->value.'"'.Formo::quicktagss($this->_find_tags()).' />';
	}

	/**
	 * image method. Processes object into formatted text
	 *
	 * @return  text
	 */			
	public function image()
	{
		return '<input type="image" name="'.$this->name.'" value="'.$this->value.'"'.Formo::quicktagss($this->_find_tags()).' />';
	}

	/**
	 * file method. Processes object into formatted text
	 *
	 * @return  text
	 */				
	public function file()
	{
		return '<input type="file" name="'.$this->name.'"'.Formo::quicktagss($this->_find_tags()).' />';
	}

	/**
	 * radio method. Processes object into formatted text
	 *
	 * @return  text
	 */		
	function radio()
	{
		return '<input type="radio" name="'.$this->name.'"'.Formo::quicktagss($this->_find_tags()).' />';
	}

	/**
	 * checkbox method. Processes object into formatted text
	 *
	 * @return  text
	 */			
	function checkbox()
	{
		$checked = ($this->checked === TRUE) ? ' checked="checked"' : '';
		return '<input type="checkbox" value="1" name="'.$this->name.'"'.$checked.Formo::quicktagss($this->_find_tags()).' />';
	}

	/**
	 * do_rule method. runs object rules
	 *
	 * @return  true if valid, false if invalid
	 */				
	private function _do_rule($rule)
	{
		$rule = (is_array($rule) AND isset($rule['rule'])) ? $rule['rule'] : $rule;
		$form_level_rules = array('match','depends_on');
		list($function,$args) = Formo::into_function($rule);

		if ($function == 'matches' OR $function == 'depends_on')
		{
			$values = array();
			foreach ($args as $match)
			{
				if (is_array($match))
				{
					foreach ($match as $match_val)
					{
						$values[$match_val] = Input::instance()->post($match_val);
					}
				}
				else
				{
					$values[$match] = Input::instance()->post($match);
				}				
			}

			return Formo::$function($this->value, $values);
		}

		if (preg_match('/::/', $function))
		{
			array_unshift($args, $this->value);
			return call_user_func_array($function, $args);
		}
		elseif (method_exists('valid', $function))
		{
			array_unshift($args, $this->value);
			return call_user_func_array('valid::'.$function, $args);
		}
		elseif (method_exists('Validation', $function))
		{
			return Validation::$function($this->value, $args);
		}
		elseif ( ! in_array($function, $form_level_rules))
		{
			array_unshift($args, $this->value);
			return call_user_func_array($function,$args);
		}
		
	}

	/**
	 * validate method. checks to see if element is required
	 * and passes any rules
	 *
	 * @return  text
	 */							
	public function validate()
	{
		if ($this->error)
			return $this->error;
			
		if ($this->type == 'file')
			return $this->_validate_file();
			
		$this->strip_error();
		$done_already = FALSE;
		if ($this->value && $this->rule)
		{
			foreach (Formo::into_array($this->rule) as $rule)
			{
				if ( ! $this->_do_rule($rule))
				{
					$this->error = $this->error_msg;
					$this->error = (is_array($rule) AND isset($rule['error_msg'])) ? $rule['error_msg'] : $this->error_msg;
					break;
				}
			}
		}
		elseif ($this->required AND strtoupper($this->required !== 'FALSE') AND strtoupper($this->required) !== 'F' AND ! $this->value)
		{
			$this->error = $this->required_msg;
		}
		
		return $this->error;
	}
	
	private function _validate_file()
	{
		$input = Input::instance();
		$fname = (isset($_FILES[$this->name.'_file'])) ? $this->name.'_file' : $this->name;
		$file = $_FILES[$fname];
		$already_uploaded = $input->post($this->name.'_path') ? TRUE : FALSE;
				
		if ($this->required AND empty($file['name']) AND ! $already_uploaded)
		{
			if ($already_uploaded AND is_file($input->post($this->name.'_path')))
			{
				unlink($input->post($this->name.'_path'));
			}
			
			$this->error = $this->required_msg;
			return $this->error;
		}
		elseif ( ! $this->required AND ! $input->post($this->name) AND empty($file['name'])) // do nothing
		{
			return;
		}
		else // let's actually do something with this
		{
			$allowed_types = $this->allowed_types;
			if ( ! is_array($allowed_types)) $allowed_types = (preg_match('/\|/', $this->allowed_types))
															? split('\|', $allowed_types) 
															: split(',', $allowed_types);
			
			// this means we're good with the file uploaded already
			if ($already_uploaded === TRUE AND ! $file['name'])
			{
				$full_path = $input->post($this->name.'_path');
				$path = array_pop(split('\/', $full_path));
				$file_name = $input->post($this->name);
			}
			elseif ($file['name']) // we're uploading a new one
			{
				// delete old entry
				if ($already_uploaded)
				{
					$full_path = $input->post($this->name.'_path');
					$path = array_pop(split('\/', $full_path));
					$file_name = $input->post($this->name);
					if (is_file($full_path)) unlink($full_path);
				}
				
				// start validating
				if ( ! upload::required($file))
					return $this->error = Kohana::lang('formo.invalidfile');
				
				if ( ! upload::size($file, array($this->max_size)))
					return $this->error = Kohana::lang('formo.too_large'). ' ('.$this->max_size.')';
					
				if ( ! upload::type($file, $allowed_types))
					return $this->error = Kohana::lang('formo.invalid_type');
								
				$full_path = upload::save($fname, time().$file['name'], DOCROOT.$this->upload_path, 0777);
				$path = array_pop(split('\/', $full_path));
				$file_name = $file['name'];				
			}
						
			// fill $this->data with appropriate info
			$this->data['orig_name'] = $file_name;
			$this->data['file_name'] = end(split('\/', $full_path));
			$this->data['path'] = preg_replace('/\/'.$this->data['file_name'].'/', '', $full_path);
			$this->data['full_path'] = $full_path;
			$this->data['file_ext'] = strtolower(substr(strrchr($file_name, '.'), 1));
			$this->data['file_type'] = reset(Kohana::config('mimes.'.$this->data['file_ext']));
			$this->data['bytes'] = filesize($full_path);
			$this->data['file_size'] = round(filesize($full_path) / 1024, 2);
			
			if ($isize = getimagesize($full_path))
			{
				$this->data['is_image'] = 1;
				$this->data['image_width'] = $isize[0];
				$this->data['image_height'] = $isize[1];
				$this->data['image_size_str'] = $isize[3];
			}
			else
			{
				$this->data['is_image'] = 0;
				$this->data['image_width'] = NULL;
				$this->data['image_height'] = NULL;
				$this->data['image_size_str'] = NULL;
			}
			
			// create the extra stuff for saving past, accepted uploads and unvalidated forms
			$this->type = 'text';
			$this->_was_file = TRUE;
			$this->add_class($this->file_link_class);
			$this->value = $file_name;
			$this->readOnly = 'readOnly';
			$this->onClick = 'file_replace("'.$this->id.'")';

			$oldclose = $this->element_close;
			$class = ( ! empty($this->class)) ? ' class="'.preg_replace('/ *'.$this->file_link_class.'/', '', $this->class).'"' : '';
			$this->element_close = '<script type="text/javascript">'."\n"
								 . 'function file_replace(id){'."\n"
								 . 'var txt = document.getElementById(id);'."\n"
								 . 'var file = document.getElementById(id+"_file");'."\n"
								 . 'txt.style.display = "none";'."\n"
								 . 'file.style.display = "inline";'."\n"
								 . '}'."\n"
								 . '</script>'."\n"
								 . '<input type="hidden" name="'.$this->name.'_path" id="'.$this->id.'_path" value="'.$full_path.'" />'."\n"
								 . '<input type="file" name="'.$this->name.'_file" id="'.$this->id.'_file"'.$class.' style="display:none"/>'."\n"
								 . $oldclose;
		}
	}
	
	public function append_errors()
	{
		if ($this->error)
		{
			$this->show_error = $this->error;
			$this->add_class($this->error_class);
		}
	}

	/**
	 * strip method. strips error from element object
	 *
	 */				
	public function strip_error()
	{
		$this->show_error = '';
		$this->remove_class($this->error_class);
	}

	/**
	 * _build_error method. Processes error into formatted text
	 *
	 * @return  text
	 */				
	private function _build_error($msg='')
	{
		if ($this->error)
		{
			$open = preg_replace('/{error_msg_class}/',$this->error_msg_class,$this->error_open);
			return $open.$this->show_error.$this->error_close;
		}	
	}

	/**
	 * _build_element method. returns element with formatting
	 *
	 * @return  text
	 */						
	private function _build_element($type='')
	{
		$func = ($type) ? $type : $this->type;
		return $this->element_open	.
			   $this->$func()		.
			   $this->element_close;
			  
	}

	/**
	 * _build_label method. returns formatted label
	 *
	 * @return  text
	 */							
	private function _build_label()
	{
		if ($this->label)
		{
			$open = str_replace('{name}', $this->name, $this->label_open);
			return $open				.
				   $this->label			.
				   $this->label_close;
		}
	}
	
	public function get_value()
	{
		switch ($this->type)
		{
			case 'html':
			case 'submit':
				return FALSE;
			case 'file':
				return $this->data;
			default:
				if ($this->_was_file === TRUE)
					return $this->data;
				if ($this->name == '__form_object')
					return FALSE;
				return $this->value;
		}
	}

	/**
	 * get method. Fully turns element into formatted text
	 *
	 * @return  text or array
	 */								
	public function get($get_as_array=FALSE)
	{
		if ( ! $get_as_array)
		{
			$func1 = '_build_'.$this->order[0];
			$func2 = '_build_'.$this->order[1];
			$func3 = '_build_'.$this->order[2];
			
			switch ($this->type)
			{
				case 'image':
				case 'submit':
					return "\t".$this->open				.
							$this->_build_element() .
							$this->close."\n";
				case 'bool':
					if ($this->value == 1) $this->checked = TRUE;
					return "\t".$this->open		.
						   $this->$func1('checkbox')	.
						   $this->$func2('checkbox')	.
						   $this->$func3('checkbox')	.
						   $this->close."\n";
				case 'hidden':
					return "\t".$this->hidden()."\n";
				case 'html':
					return "\t".$this->html()."\n";
				default:		
					return "\t".$this->open		.
						   $this->$func1()	.
						   $this->$func2()	.
						   $this->$func3()	.
						   $this->close."\n";
			}
		}
		else
		{
			switch ($this->type)
			{
				case 'bool':
					return $this->_build_element('checkbox');
				default:
					return $this->_build_element();
			}
		}
	}
		
}
// End Form_Element