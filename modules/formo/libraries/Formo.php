<?php defined('SYSPATH') or die('No direct script access.');

/* 
	Version 1.0
	avanthill.net/formo_manual/
		
	Requires Formo_Element and Formo_Group
	Kohana 2.2
*/

class Formo_Core {

	public $_formo_name;
	public $_formo_type;
	
	public $_error;
	public $_sent = FALSE;
	public $_elements = array();
			
	public $_functions = array();
	protected static $__includes = array();
			
	public $_post_added;
	public $_was_validated;
	public $_validated;
	public $_post_type;
	public $_cleared;
			
	public $_open = '<form action="{action}" method="{method}" class="{class}">';
	public $_close = '</form>';
	public $_action;
	public $_method = 'post';
	public $_class = 'standardform';
			
	public $_order = array();
			
	public $_auto_rules = array();
	public $_pre_filters = array();
	public $_label_filters = array();
			
	private $__elements_str;
			
	public $_globals = array();
	public $_defaults = array();
		
	public function __construct($name='noname',$type='')
	{	
		$data = array('name'=>$name, 'type'=>$type);
		Event::run('formo.pre_construct', $data);
		
		$this->_formo_name = ($data['name']) ? $data['name'] : 'noname';
		$this->_formo_type = $data['type'];
		$this->add('hidden','__form_object',array('value'=>$this->_formo_name));
		
		$this->_compile_plugins();
		$this->_compile_settings('form_globals');
		$this->_compile_settings('globals');
		$this->_compile_settings('defaults');
		$this->_compile_settings('auto_rules');
		$this->_compile_settings('label_filters');
		$this->_compile_settings('pre_filters');
		
		Event::run('formo.post_construct');
	}
		
	public function bind($property, & $value)
	{
		// only bind the property if it doesn't already exist
		if (empty($this->$property))
		{
			$this->$property =& $value;
		}		
				
		return $this;
	}
	
	public function add_function($function, $values)
	{
		$this->_functions[$function] = $values;
		
		return $this;
	}
		
	public function plugin($plugin)
	{
		$plugins = (func_num_args() > 1) ? func_get_args() : self::splitby($plugin);
		
		foreach ($plugins as $name)
		{
			self::include_file('plugin', $name);
			call_user_func('Formo_'.$name.'::load', $this);
		}

		return $this;
	}
	
	/**
	 * Magic __call method. Handles element-specific stuff and
	 * set_thing and add_thing
	 *
	 * @return  object
	 */		
	public function __call($function, $values)
	{
		if ( ! empty($this->_functions[$function]))
		{
			$return = call_user_func_array($this->_functions[$function], $values);
			
			return ($return) ? $return : $this;
		}
				
		$element = ( ! empty($values[0])) ? $values[0] : NULL;
		$formo_var = '_'.$function;

		if ( ! is_array($element) AND isset($this->$element) AND method_exists($this->$element, $function))
		{
			unset($values[0]);
			call_user_func_array(array($this->$element, $function), $values);
			return $this;			
		}
		elseif (isset($this->$formo_var))
		{
			if (is_array($values[0]) AND isset($values[1]) AND is_array($values[1]))
			{
				$this->$formo_var = $values;
			}
			elseif (is_array($values[0]))
			{
				$this->$formo_var = $values[0];
			}
			else
			{
				$this->$formo_var = $values;
			}
		}
		
		return $this;
	}
	
	/**
	 * Magic __set method. Keeps track of elements added to form object
	 *
	 */				
	public function __set($var, $val)
	{
		// if it's an object (element, element group), add it to the elements
		if (is_object($val))
		{
			$this->$var = $val;
			$this->_elements[$var] = $this->$var->type;
		}
		// if it's a formo value, properly set it
		elseif ($formo_var = '_'.$var AND isset($this->$formo_var))
		{
			$this->$formo_var = $val;
		}
		else
		{
			$this->$var = $val;
		}
	}
			
	public function __toString()
	{
		return $this->get();	
	}

	/**
	 * factory method. Creates and returns a new form object
	 *
	 * @return  object
	 */			
	public static function factory($name='noname',$type='')
	{	
		return new Formo($name, $type);
	}
	
	/**
	 * depends_on method. Mimicks Kohana's built-in helper
	 *
	 * @return bool
	 */					
	public function depends_on($field, array $fields)
	{
		foreach ($fields as $element=>$v)
		{
			if ( ! isset($fields[$element]) OR $fields[$element] == NULL )
				return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * matches method. Mimicks Kohana's built-in helper
	 *
	 * @return bool
	 */					
	public function matches($field_value, array $inputs)
	{
		foreach ($inputs as $element=>$v)
		{
			if ($field_value != $inputs[$element])
				return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * validate method. Runs validate on each element
	 *
	 * @return object
	 */						
	public function validate($append_errors=FALSE)
	{
		Event::run('pre_validate');

		if ($this->_was_validated AND ! $append_errors)
			return $this->_validated;
						
		if ( ! $this->_post_added)
		{
			$this->add_posts();
		}
		
		if ( ! $this->_sent)
			return;
				
		// validate elements
		foreach (($elements = $this->find_elements()) as $key)
		{
			if ( ! $this->_validated)
			{
				if ($this->$key->validate()) {
					$this->_error = TRUE;
				}
			}
			
			if ($append_errors)
			{
				$this->$key->append_errors();
			}
		}	
		
		if ($this->_was_validated)
			return $this->_validated;
	
		$this->_was_validated = TRUE;		
		$this->_validated = ($this->_error) ? FALSE : TRUE;
				
		Event::run('formo.post_validate');
		
		return ($this->_error) ? FALSE : TRUE;
	}

	/**
	 * _filter_labels method. Runs filters on labels
	 *
	 * NOT USABLE
	 */							
	private function _filter_label($element)
	{
		foreach ($this->_label_filters as $filter)
		{
			$this->$element->filter_label($filter);
		}
	}
	
	public function label_filter($function)
	{
		$this->_label_filters[] = $function;
		
		return $this;
	}

	/**
	 * add_posts method. Called from _prepare, adds post/get
	 * values to elements
	 *
	 * @return bool
	 */							
	public function add_posts()
	{
		if ($this->_post_added)
			return;
				
		if (strtoupper(Input::instance()->post('__form_object')) == strtoupper($this->_formo_name))
		{
			$this->_post_type = 'post';
		}
		elseif (strtoupper(Input::instance()->get('__form_object')) == strtoupper($this->_formo_name))
		{
			$this->_post_type = 'get';
		}
			
		if ( ! $this->_post_type)
			return;
		
		$type = $this->_post_type;

		Event::run('formo.pre_addpost');
		
		foreach ($this->find_elements() as $element)
		{
			$value = Input::instance()->$type($element);
			$this->$element->add_post($value, $type);
		}

		Event::run('formo.post_addpost');

		$this->_post_added = TRUE;
		$this->_sent = TRUE;
	}

	/**
	 * _do_pre_filters method. run pre_filters on elements
	 * 
	 * USABLE, NEEDS SERIOUS CLEANUP
	 *
	 * @return bool
	 */
	 	
	private function _do_pre_filters()
	{
		foreach ($this->find_elements() as $element)
		{
			if (isset($this->_pre_filters['all']))
			{
				foreach ($this->_pre_filters['all'] as $filter)
				{
					if ($this->$element->type == 'select' OR $this->$element->type == 'sel')
					{
						$this->_do_select_pre_filter($element, $filter);
					}
					else
					{
						$this->$element->value = call_user_func($filter, $this->$element->value);
					}					
				}
			}
			if (isset($this->_pre_filters[$element]))
			{
				foreach ($this->_pre_filters[$element] as $filter)
				{
					if ($this->$element->type == 'select' OR $this->$element->type == 'sel')
					{
						$this->_do_select_pre_filter($element, $filter);
					}
					else
					{
						$this->$element->value = call_user_func($filter, $this->$element->value);
					}					
				}
			}
		}	
	}
	
	private function _do_select_pre_filter($element, $filter)
	{
		$keys = array_keys($this->$element->values);
		$values = array_values($this->$element->values);
		foreach ($keys as $k=>$key)
		{
			$keys[$k] = call_user_func($filter, $key);
		}
		
		if ($keys AND $values)
		{
			$this->$element->values = array_combine($keys, $values);
		}		
	}
	
	protected function _set_type($element, $type)
	{
		self::include_file('driver', $type);
		$class = 'Formo_'.$type.'_Driver';
		
		$vals = get_object_vars($this->$element);

		unset($this->$element);
		unset($vals['type']);
		unset($vals['tags']);
		
		$this->add($type, $element, $vals);
	}
	
	/**
	 * set method. set form object value
	 * 
	 *
	 * @return object
	 */								
	public function set($tag,$value,$other='')
	{
		if (isset($this->_elements[$tag]) AND $value != 'type')
		{
			$this->$tag->$value = $other;
		}
		elseif (isset($this->_elements[$tag]) AND $value == 'type')
		{
			$this->_set_type($tag, $other);
		}
		else
		{
			$formo_var = (isset($this->$tag)) ? $tag : '_'.$tag;
			$value = (is_array($this->$formo_var)) ? self::into_array($value) : $value;
			$this->$formo_var = $value;
		}
		return $this;
	}

	/**
	 * splitby method. Divide a list into parts
	 *
	 * @return array
	 */													
	public static function splitby($string, $dividers = array(',', '\|'))
	{
		if (is_array($string))
			return $string;
			
		foreach ($dividers as $divider)
		{
			if (preg_match('/'.$divider.'/', $string))
			{
				$array = preg_split('/'.$divider.'/', $string);
				foreach ($array as $k=>$v)
				{
					$array[$k] = trim($v);
				}
				return $array;
			}
		}
		
		return ($string) ? array($string) : array();
	}

	/**
	 * quicktags method. Simple method for inputting tag sets
	 *
	 * @return array
	 */											
	public static function quicktags($string)
	{	
		if ( ! $string)
			return array();
		if (is_array($string))
			return $string;
			
		$groups = self::splitby($string);
		foreach ($groups as $group)
		{
			$group_parts = explode('=', $group);
			$tags[trim($group_parts[0])] = trim($group_parts[1]);
		}
		
		return $tags;
	}
	
	/**
	 * quicktagss method. Formats tags array into formatted html
	 *
	 * @return string
	 */												
	public static function quicktagss($string)
	{
		$tags = self::quicktags($string);
		$str = '';
		$a = 0;
		foreach ($tags as $k=>$v)
		{
			$str.= ' '.$k.'='.'"'.$v.'"';
			$a++;
		}
		return $str;
	}

	/**
	 * into_function method. Takes string like some_function[val, val2][val3, val4]
	 * and returns an array function => some_function, args => 0 => array(val, val2), 1 => array(val3, val4)
	 *
	 * @return array
	 */										
	public static function into_function($string)
	{
		preg_match('/^([^\[]++)/', $string, $matches);
		$function = $matches[0];
		$string = preg_replace('/^'.$function.'/','',$string);
		
		preg_match_all('/\[.+?\]/', $string, $matches);
		$args = array();
		foreach ($matches[0] as $match)
		{
			$match = preg_replace('/[\[\]]/', '', $match);
			$args[] = (preg_match('/,/',$match)) ? preg_split('/(?<!\\\\),\s*/', $match) : $match;
		}
				
		return array($function,$args);
	}

	/**
	 * into_array method. Turns $thing into an array if it isn't
	 *
	 * @return array
	 */											
	public function into_array( & $thing)
	{	
		if ( ! is_array($thing))
		{
			$thing = array($thing);
		}

		return $thing;
	}
	
	/**
	 * _compile_plugins function.
	 * 
	 * @access private
	 * @return void
	 */
	private function _compile_plugins()
	{
		$plugins = array();
		$settings = array
		(
			'values' => Kohana::config('formo.plugins', FALSE, FALSE),
			'type_values' => Kohana::config('formo.'.$this->_formo_type.'.plugins', FALSE, FALSE)
		);
		
		foreach ($settings as $setting)
		{
			if ( ! $setting)
				continue;
			
			$this->plugin($setting);
		}
		
	}
		
	/**
	 * _compile_settings function. From config
	 * 
	 * @access public
	 * @param mixed $setting
	 * @return void
	 */
	public function _compile_settings($setting)
	{
		$formo_var = '_'.$setting;
		
		$settings = array
		(
			'values' => Kohana::config('formo.'.$setting, FALSE, FALSE),
			'type_values' => Kohana::config('formo.'.$this->_formo_type.'.'.$setting, FALSE, FALSE)
		);
		
		if ($setting == 'form_globals')
			return $this->_compile_form_globals($settings);
					
		if ($settings['values'])
		{
			$this->$formo_var = array_merge($this->$formo_var, $settings['values']);
		}
			
		if ($settings['type_values'])
		{
			$this->$formo_var = array_merge($this->$formo_var, $settings['type_values']);
		}
	}
	
	/**
	 * _compile_form_globals function.
	 * 
	 * @access private
	 * @param mixed $settings
	 * @return void
	 */
	private function _compile_form_globals($settings)
	{
		foreach ($settings as $values)
		{
			if (empty($values))
				continue;
			
			foreach ($values as $property => $value)
			{
				$this->{'_'.$property} = $value;
			}
		}
	}
			
	public function check($group, $element='')
	{
		if (is_object($this->$group) AND get_class($this->$group) == 'Formo_Group')
		{
			foreach (Formo::splitby($element) as $el)
			{
				$this->$group->$el->checked = TRUE;
			}
		}
		else
		{
			$this->$group->checked = TRUE;
		}
		
		return $this;
	}

	/**
	 * pre_filter method. Add a pre_filter
	 *
	 * @return object
	 */												
	public function pre_filter($element, $function='')
	{
		$this->_pre_filters[$element][] = $function;
		
		return $this;
	}
	
	/**
	 * pre_filters method. Add a pre_filter to a set of elements
	 *
	 * @return object
	 */
	public function pre_filters($function, $elements)
	{
		$_functions = self::splitby($function);
		$_elements = self::splitby($elements);
		
		foreach ($_functions as $_function)
		{
			foreach ($_elements as $_element)
			{
				$_element = trim($_element);
				$this->pre_filter(trim($_element), $_function);
			}		
		}		
		
		return $this;
	}
	
	/**
	 * add_rules. Add a rule to a set of elements
	 *
	 * @return object
	 */
	public function add_rules($rule, $elements, $message='')
	{
		$_rules = self::splitby($rule);
		$_elements = self::splitby($elements);

		foreach ($_rules as $_rule)
		{
			foreach ($_elements as $_element)
			{
				$_element = trim($_element);
				$this->$_element->add_rule($_rule, $message);
			}
		}
		
		return $this;
	}
	
	public function clear()
	{
		foreach ($this->form->find_elements() as $element)
		{
			if ($this->form->$element->type == 'submit')
				continue;
			if ($element == '__form_object')
				continue;
			
			$this->form->$element->value = NULL;
		}

		$this->form->post_added = FALSE;
		$this->form->was_validate = FALSE;
		$this->form->validated = FALSE;
		$this->form->sent = FALSE;
		$this->cleared = TRUE;
		
		return $this;
	}	
		
	/**
	 * _make_defaults method. Append default tags to element
	 *
	 * @return array
	 */
	private function _make_defaults($type, $name)
	{
		$defaults = array();
		// check if this needs to change types first
		if (isset($this->_defaults[strtolower($name)]['type']))
		{
			$type = $this->_defaults[strtolower($name)]['type'];
		}
		
		if (isset($this->_defaults[$type]))
		{
			$defaults = array_merge($this->_defaults[$type], $defaults);
		}		
	
		if (isset($this->_defaults[strtolower($name)]))
		{
			$defaults = array_merge($defaults, $this->_defaults[strtolower($name)]);
		}
		
		
		return $defaults;
	}
	
	public static function include_file($type, $file)
	{
		if (in_array($file, self::$__includes))
			return;
			
		$path = 'libraries/formo_'.$type.'s';

		$_file = Kohana::find_file($path, $file);
		if ( ! $_file)
		{
			$_file = Kohana::find_file($path.'_core', $file);
		}

		include_once($_file);
		self::$__includes[] = $file;
	}
				

	/**
	 * add method. Add a new Form_Element object to form
	 *
	 * @return object
	 */
	public function add($type,$name='',$info=array())
	{
		if ($type == 'submit')
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
								
		$obj_name = preg_replace('/ /', '_', $name);
		$obj_name = strtolower($obj_name);
		
		if (isset($this->$obj_name))
			return $this;		

		$shortcuts = array('/^ta$/','/^sel$/', '/^hid$/');
		$methods = array('textarea','select', 'hidden');
		$type = preg_replace($shortcuts,$methods,$type);
		
		$defaults = $this->_make_defaults($type, $name);
		$defaults_globals = array_merge($this->_globals, $defaults);

		$info = self::quicktags($info);
		$info = array_merge($defaults_globals, $info);

		if ( ! empty($info['type']))
		{
			$type = $info['type'];
			unset($info['type']);
		}
		
		self::include_file('driver', $type);
		
		$file = 'Formo_'.$type.'_Driver';
		$el = new $file($name, $info);
		$el->type = $type;

		$this->$obj_name = $el;
		
		$this->_attach_auto_rule($obj_name);

		if ($el->type == 'file')
		{
			$this->_open = preg_replace('/>/',' enctype="multipart/form-data">', $this->_open);
		}
		elseif ($el->type == 'bool')
		{
			if ($el->value) $this->check($obj_name);
			$this->$obj_name->value = 0;
			$this->$obj_name->required = FALSE;
		}
		

		return $this;
	}
	
	/**
	 * add_group method. Add a new Form_Group object to form
	 *
	 * @return object
	 */
	public function add_group($name, $values, $info=NULL)
	{
		$add_name = strtolower(preg_replace('/\[\]/','',$name));
		$this->$add_name = Formo_Group::factory($name, $values, $info);
		return $this;
	}
			
	/**
	 * _attach_auto_rule method. Attach an auto rule to appropriate element
	 *
	 */
	private function _attach_auto_rule($name)
	{
		if ( ! isset($this->_auto_rules[$name]))
			return;
		
		if (is_array($this->_auto_rules[$name][0]))
		{
			foreach ($this->_auto_rules[$name] as $rule)
			{
				$this->add_rule($name, $rule[0], $rule[1]);
			}
		}
		elseif (is_array($this->_auto_rules[$name]))
		{
			$this->add_rule($name, $this->_auto_rules[$name][0], $this->_auto_rules[$name][1]);
		}
		else
		{
			$this->add_rule($name, $this->_auto_rules[$name]);
		}		
	}
	
	/**
	 * add_select method. Special function for adding a new select element object
	 * to form
	 *
	 * @return object
	 */
	public function add_select($name,$values,$info=array())
	{
		$info = $this->quicktags($info);
		$info['values'] = $values;
		$this->add('select',$name,$info);
		return $this;
	}
		
	/**
	 * add_html method. Special function for adding a new html element object
	 * to form
	 *
	 * @return object
	 */
	public function add_html($name,$value)
	{
		$info['value'] = $value;
		$this->add('html',$name,$info);
		return $this;
	}

	/**
	 * add_image method. Special function for adding a new image element object
	 * to form
	 *
	 * @return object
	 */
	public function add_image($name,$src,$info=array())
	{
		$info = $this->quicktags($info);
		$info['src'] = $src;
		$this->add('image',$name,$info);
		return $this;
	}
	
	public function add_button($value, $info=array())
	{
		$info = Formo::quicktags($info);
		$info['value'] = $value;
		$this->add('button', $value, $info);
		return $this;
	}

	/**
	 * remove method. Removes an element from form object
	 *
	 * @return object
	 */
	public function remove($element)
	{
		if (is_array($element))
		{
			foreach ($element as $el)
			{
				unset($this->$el);
				unset($this->_elements[$el]);
			}
		}
		else
		{
			unset($this->$element);
			unset($this->_elements[$element]);
		}
		
		return $this;
	}

	/**
	 * find_elements method. return all elements. Use order if applicable
	 *
	 * @return array
	 */	
	public function find_elements()
	{
		if ($this->_order)
		{
			$elements[] = '__form_object';
			foreach ($this->_order as $v)
			{
				$elements[] = $v;
			}
			return $elements;
		}
		else
		{
			return array_keys($this->_elements);
		}
	}

	/**
	 * _elements_to_string method. Build a string of formatted text with all the
	 * form's elements
	 *
	 * @return string
	 */		
	protected function _elements_to_string($return_as_array=FALSE)
	{
		foreach (($elements = $this->find_elements()) as $key)
		{
			if ($return_as_array)
			{			
				$elements_array[$key] = $this->$key;
				$elements_array[$key.'_error'] = $this->$key->error;
			}
			else
			{
				$this->_filter_label($key);
				$this->__elements_str.= $this->$key->get();			
			}
	
		}
		if ($return_as_array)
			return $elements_array;
			
		return $this->__elements_str;
	}
	
	/**
	 * _make_opentag method. Format form open tag
	 *
	 * @return string
	 */	
	private function _make_opentag()
	{
		$search = array('/{action}/','/{method}/','/{class}/');
		$replace = array($this->_action,$this->_method,$this->_class);
		return preg_replace($search,$replace,$this->_open);
	}
	
	/**
	 * _make_closetag method. Format form close tag
	 *
	 * PROBABLY AN UNNECESSARY FUNCTION
	 *
	 * @return string
	 */	
	private function _make_closetag()
	{
		return $this->_close;
	}
				
	/**
	 * get method. Retun formatted array or entire form
	 *
	 * @return string or array
	 */			
	public function get($as_array=FALSE)
	{
		$this->add_posts();
		$this->_do_pre_filters();

		Event::run('formo.pre_render');

		if ($this->_sent)
		{
			$this->validate(TRUE);
		}
		
		$return = ($as_array == TRUE) ? $this->_get_array() : $this->_get();
		
		Event::run('formo.post_render');

		return $return;
	}

	/**
	 * render method. Alias for get()
	 *
	 * @return string or array
	 */				
	public function render($as_array=FALSE)
	{
		$this->get($as_array);
	}	

	/**
	 * _get_array method. Used with get, processes into an array
	 *
	 * @return array
	 */			
	private function _get_array()
	{
		$form = $this->_elements_to_string(TRUE);
		$form['open'] = $this->_make_opentag()."\n".$this->__form_object->get();
		$form['close'] = $this->_make_closetag();
		
		return $form;
	}

	/**
	 * _get method. Used with get, processes into an string
	 *
	 * @return string
	 */				
	private function _get()
	{	
		$form = $this->_make_opentag()."\n";
		$form.= $this->_elements_to_string();
		$form.= $this->_make_closetag()."\n";
		
		return $form;
	}
	
	public function get_values($element=NULL)
	{
		if ($element)
			return $this->$element->get_value();

		$values = array();
		foreach (($elements = $this->find_elements()) as $element)
		{
			if (($val = $this->$element->get_value()) === FALSE)
				continue;
				
			$values[$element] = $val;
		}
		return $values;
	}	

}	// End Formo