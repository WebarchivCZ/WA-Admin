<?php defined('SYSPATH') or die('No direct script access.');

/* 
	Version .8.5.1
	avanthill.com/formo_manual/
	
	Requires Formo_Element and Formo_Group
	Kohana 2.2
*/

class Formo_Core {

	public $__form_name;
	public $__form_type;
	public $session;
	public $error;
	public $sent = FALSE;
	public $elements = array();
		
	public $post_added;
	public $was_validated;
	public $validated;
		
	public $open = '<form action="{action}" method="{method}" class="{class}">';
	public $close = '</form>';
	public $action;
	public $method = 'post';
	public $class = 'standardform';
	
	public $order = array();
	
	public $auto_rules = array();
	public $pre_filters = array();
	public $label_filters = array();
	
	public $model;
	public $model_array = array();
	public $ignores = array();
	public $auto_save = FALSE;
	public $aliases = array();
	
	private $_elements_str;
	
	public $submit_name;
	public $errors = array();
		
	public $on_success = array();
	public $on_failure = array();
	
	public $globals = array();
	public $defaults = array();
		
	public function __construct($name='noname',$type='')
	{
		$this->session = Session::instance();
		$this->__form_name = ($name) ? $name : 'noname';
		$this->__form_type = $type;
		$this->add('hidden','__form_object',array('value'=>$this->__form_name));
				
		$this->_compile_settings('globals');
		$this->_compile_settings('defaults');
		$this->_compile_settings('auto_rules');
		$this->_compile_settings('label_filters');
		$this->_compile_settings('pre_filters');		
	}

	/**
	 * Magic __call method. Handles element-specific stuff and
	 * set_thing and add_thing
	 *
	 * @return  object
	 */		
	public function __call($function, $values)
	{
		$element = $values[0];
		if ( ! is_array($element) AND isset($this->$element) AND method_exists($this->$element, $function))
		{
			unset($values[0]);
			call_user_func_array(array($this->$element, $function), $values);
			return $this;			
		}
		elseif (preg_match('/^(set|add)_([a-zA-Z0-9_]+)$/', $function, $matches))
		{
			switch ($matches[1])
			{
				case 'add':
					switch ($matches[2])
					{
						case 'on_success':
							$array = array('function'=>$values[0]);
							for ($i=1;$i<count($values);$i++)
							{
								$array['args'][] = $values[$i];
							}
							$this->on_success[] = $array;
							break;
						case 'on_failure':
							$this->on_failure[] = array('function'=>$values[0]);					
							break;
						default:
							$this->$matches[2] = array_merge($this->$matches[2], self::into_array($values));	
					}				
					
				break;
				case 'set':
					$this->$matches[2] = $values[0];
				break;
			}
		}
		elseif (isset($this->$function))
		{
			$this->$function = $values[0];
		}
		
		return $this;
	}
	
	/**
	 * Magic __set method. Keeps track of elements added to form object
	 *
	 */				
	public function __set($var, $val)
	{
		$element_classes = array('Formo_Element','Formo_Group');
		$this->$var = $val;
		if (in_array(get_class($val), $element_classes))
		{
			$this->elements[$var] = $this->$var->type;
		}
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
	 * _template method. Basic template parser
	 *
	 * @return  string
	 */			
	private function _template($string)
	{
		preg_match_all('/{([a-z_0-9]+)}/', $string, $matches);
		if ($matches[1])
		{
			foreach ($matches[1] as $match)
			{
				$str = '{'.$match.'}';
				$value = $this->$match->value;
				$string = str_replace($str,$value,$string);
			}
		}
		return $string;
	}

	/**
	 * _process_success method. Successively run on_success functions
	 *
	 */			
	private function _process_success()
	{
		if ($this->_has_error())
			return;
						
		foreach ($this->on_success as $success)
		{
			$function = $success['function'];
			$args = (isset($success['args'])) ? $success['args'] : NULL;
			call_user_func_array($function,$args);
		}
	}
	
	/**
	 * _process_failure method. Successively run on_failure functions
	 *
	 */			
	private function _process_failure()
	{		
		if ( ! $this->_has_error())
			return;
			
		foreach ($this->on_failure as $string)
		{
			list($function, $args) = self::into_function($string);
			call_user_func_array($function,$args);
		}
	}
	
	/**
	 * _instance method. Create a form object from session data
	 *
	 * THIS IS NOT A FUNCTIONAL METHOD
	 */								
	public function instance($name='noname',$redirect='')
	{	
		if ( ! $name)
		{
			$name = 'noname';
		}
		$sess = Session::instance()->get('__'.$name.'_form_object');
		if (get_class($this) != 'Form' AND $sess AND (Input::instance()->post('__form_object') == $name OR Input::instance()->get('__form_object') == $name))
		{
			$form = unserialize($sess);
			$form->prepared = FALSE;
			return $form;
		}
		elseif ($redirect)
		{
			url::redirect($redirect);
		}
		else
		{
			return new Formo($name);
		}
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
	
	private function _has_error()
	{
		foreach (($elements = $this->_find_elements()) as $element)
		{
			if ($this->$element->error)
				return TRUE;
		}
	}

	/**
	 * validate method. Runs validate on each element
	 *
	 * @return object
	 */						
	public function validate($append_errors=FALSE)
	{
		if ($this->was_validated AND ! $append_errors)
			return $this->validated;
						
		if ( ! $this->post_added)
		{
			$this->add_posts();
		}
		
		if ( ! $this->sent)
			return;
		
		foreach (($elements = $this->_find_elements()) as $key)
		{
			if ( ! $this->validated)
			{
				if ($this->$key->validate()) {
					$this->error = TRUE;
				}
			}
			
			if ($append_errors)
			{
				$this->$key->append_errors();
			}
		}
		
		if ($this->was_validated)
			return $this->validated;
		
		$this->was_validated = TRUE;
		
		$this->validated = ($this->error) ? FALSE : TRUE;
		return ($this->error) ? FALSE : TRUE;
	}

	/**
	 * _filter_labels method. Runs filters on labels
	 *
	 * NOT USABLE
	 */							
	private function _filter_label($element)
	{
		foreach ($this->label_filters as $filter)
		{
			$this->$element->label = call_user_func($filter, $this->$element->label);
		}
	}
	
	public function label_filter($function)
	{
		$this->label_filters[] = $function;
		
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
		if ($this->post_added)
			return;
			
		$type = '';
		if (strtoupper(Input::instance()->post('__form_object')) == strtoupper($this->__form_name))
		{
			$type = 'post';
		} 
		elseif (strtoupper(Input::instance()->get('__form_object')) == strtoupper($this->__form_name))
		{			
			$type = 'get';
		}

		if ($type)
		{
			foreach (Input::instance()->$type() as $k=>$v)
			{
				if (isset($this->$k) AND is_object($this->$k))
				{
					switch ($this->$k->type)
					{
						case 'checkbox':
							if ($v == $this->$k->value) $this->$k->checked = TRUE;
							break;
						case 'bool':
							$this->$k->checked = ($v == 1) ? TRUE : FALSE;
						default:
							$this->$k->value = $v;
					}
					foreach ($this->model_array as $model=>$array)
					{
						$model_field = $k;
						if ( ! empty($this->aliases[$model]))
						{
							$model_field = (in_array($k, $this->aliases[$model])) ? array_search($k, $this->aliases[$model]) : $k;
						}						
						
						if (in_array($model_field, $array))
						{
							$this->model[$model]->$model_field = $v;
						}
					}
					$this->$k->value = $v;
				}				
			}
			
			if ($this->auto_save AND $this->model)
			{
				foreach ($this->model as $name=>$model)
				{
					$model->save();
				}
			}
			
			$this->post_added = TRUE;
			$this->sent = TRUE;
		} 
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
		foreach ($this->_find_elements() as $element)
		{
			if (isset($this->pre_filters['all']))
			{
				foreach ($this->pre_filters['all'] as $filter)
				{
					$this->$element->value = call_user_func($filter, $this->$element->value);
				}
			}
			if (isset($this->pre_filters[$element]))
			{
				foreach ($this->pre_filters[$element] as $filter)
				{
					$this->$element->value = call_user_func($filter, $this->$element->value);
				}
			}
		}	
	}

	/**
	 * set method. set form object value
	 * 
	 *
	 * @return object
	 */								
	public function set($tag,$value,$other='')
	{
		if (in_array($tag,$this->elements))
		{
			$this->$tag->$value = $other;
		}
		else
		{
			$value = (is_array($this->$tag)) ? self::into_array($value) : $value;
			$this->$tag = $value;
		}
		return $this;
	}

	/**
	 * quicktags method. Simple method for inputting tag sets
	 *
	 * @return array
	 */										
	public static function quicktags($string, $divider1=',', $divider2='=')
	{
		if ( ! $string)
			return array();
		if (is_array($string))
			return $string;
			
		$groups = split($divider1, $string);
		foreach ($groups as $group)
		{
			$group_parts = split($divider2, $group);
			$tags[trim($group_parts[0])] = trim($group_parts[1]);
		}
		return $tags;
	}

	/**
	 * quicktagss method. Formats tags array into formatted html
	 *
	 * @return string
	 */												
	public static function quicktagss($string, $divider1=',', $divider2='=')
	{
		$tags = self::quicktags($string,$divider1,$divider2);
		$str = '';
		$a = 0;
		foreach ($tags as $k=>$v)
		{
			$pre = ($a==0) ? '' : ' ';
			$str.= $pre.$k.$divider2."'$v'";
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
		
		preg_match_all('/\[([a-z_0-9 ,]+)\]/', $string, $matches);
		$args = array();
		foreach ($matches[1] as $match)
		{
			$args[] = (preg_match('/,/',$match)) ? preg_split('/(?<!\\\\),\s*/', $match) : $match;
		}
		
		return array($function,$args);
	}

	/**
	 * into_array method. Turns $thing into an array if it isn't
	 *
	 * @return array
	 */											
	public function into_array(&$thing)
	{	
		if ( ! is_array($thing))
		{
			$thing = array($thing);
		}

		return $thing;
	}

	/**
	 * _compile_settings method. Turn config
	 *
	 */											
	private function _compile_settings($setting)
	{
		$settings = array
		(
			'type_values' => Kohana::config('formo.'.$this->__form_type.'.'.$setting, FALSE, FALSE),
			'values' => Kohana::config('formo.'.$setting, FALSE, FALSE)
		);
					
		if ($settings['values'])
		{
			$this->$setting = array_merge($this->$setting, $settings['values']);
		}
			
		if ($settings['type_values'])
		{
			$this->$setting = array_merge($this->$setting, $settings['type_values']);
		}
	}

	/**
	 * pre_filter method. Add a pre_filter
	 *
	 * @return object
	 */												
	public function pre_filter($element, $function='')
	{
		$this->pre_filters[$element][] = $function;
		
		return $this;
	}
	
	/**
	 * pre_filters method. Add a pre_filter to a set of elements
	 *
	 * @return object
	 */
	public function pre_filters($function, $elements)
	{
		$_functions = $function;
		if ( ! is_array($function)) $_functions = (preg_match('/\|/', $function)) ? split('\|', $function) : split(',', $function);
				
		if ( ! is_array($elements))
		{
			$_elements = (preg_match('/\|/', $elements)) ? split('\|', $elements) : split(',', $elements);			
		}
		
		foreach ($_functions as $_function)
		{
			foreach ($_elements as $_element)
			{
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
		$_rules = $rule;
		if ( ! is_array($rule)) $_rules = (preg_match('/\|/', $rule)) ? split('\|', $rule) : split(',', $rule);		
		if ( ! is_array($elements))
		{
			$_elements = (preg_match('/\|/', $elements)) ? split('\|', $elements) : split(',', $elements);			
		}
		
		foreach ($_rules as $_rule)
		{
			foreach ($_elements as $_element)
			{
				$this->$_element->add_rule($_rule, $message);
			}		
		}
		
		return $this;
	}
	
		
	/**
	 * _make_defaults method. Append default tags to element
	 *
	 * @return array
	 */
	private function _make_defaults($type, $name, $info)
	{
		// check if this needs to change types first
		if (isset($this->defaults[strtolower($name)]['type']))
		{
			$type = $this->defaults[strtolower($name)]['type'];
		}
		
		if (isset($this->defaults[$type]))
		{
			$info = array_merge($info, $this->defaults[$type]);
		}		
	
		if (isset($this->defaults[strtolower($name)]))
		{
			$info = array_merge($info, $this->defaults[strtolower($name)]);
		}

		
		return $info;
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

		$shortcuts = array('/^ta$/','/^sel$/', '/^hid$/');
		$methods = array('textarea','select', 'hidden');
		$type = preg_replace($shortcuts,$methods,$type);
		
		$info = self::quicktags($info);
		$info = array_merge($this->globals, $info);
		$info = $this->_make_defaults($type, $name, $info);
		
		if ( ! isset($this->{strtolower($name)}))
		{
			$el = new Formo_Element($type,$name,$info);
			$this->{preg_replace('/ /', '_', $el->name)} = $el;
			$this->_attach_auto_rule(strtolower($name));
		}
		
		if ($el->type == 'file')
		{
			$this->open = preg_replace('/>/',' enctype="multipart/form-data">', $this->open);
		}

		return $this;
	}
	
	/**
	 * add_group method. Add a new Form_Group object to form
	 *
	 * @return object
	 */
	public function add_group($type, $name, $values, $info=NULL)
	{
		$add_name = strtolower(preg_replace('/\[\]/','',$name));
		$this->$add_name = Formo_Group::factory($type, $name, $values, $info);
		return $this;
	}
	
	public function orm($_model, $id=0)
	{
		$this->model[$_model] = ORM::factory($_model, $id);
		$this->model_array[$_model] = array_keys($this->model[$_model]->as_array());
		
		$settings = array
		(
			'formo_ignores'			=> 'ignores',
			'formo_globals'			=> 'globals',
			'formo_defaults'		=> 'defaults',
			'formo_rules'			=> 'auto_rules',
			'formo_label_filters'	=> 'label_filters',
			'formo_order'			=> 'order'
		);
		
		foreach ($settings as $orm_name=>$name)
		{
			if ( ! empty($this->model[$_model]->$orm_name))
			{
				$this->$name = array_merge($this->$name, $this->model[$_model]->$orm_name);
			}
		}
		
		foreach ($this->model[$_model]->table_columns as $field => $value)
		{
			$alias_field = $field;
			if (isset($this->aliases[$_model][$field]))
			{
				$alias_field = $this->aliases[$_model][$field];
			}
			
			if (in_array($field, $this->ignores))
				continue;
			
			// relational tables
			$fkey = preg_replace('/_id/','',$field);
			if (in_array($fkey,$this->model[$_model]->belongs_to))
			{
				$values = array('_blank_'=> NULL);
				foreach ($this->model[$_model]->$fkey->find_all() as $value)
				{
					$primary_val = $value->primary_val;
					$primary_key = $value->primary_key;
					$values[$value->$primary_val] = $value->$primary_key;
				}
				$this->add_select($field,$values);
			}
			else
			{
				$this->add($alias_field);
			}			
			$this->$alias_field->value = $this->model[$_model]->$field;
		}
		
		
		return $this;
	}
	
	public function save($name = '')
	{
		if ($name)
		{
			$this->$name->save();
		}
		else
		{
			foreach ($this->model as $name=>$model)
			{
				$model->save();
			}
		}		
		
		return $this;
	}
	
	/**
	 * _attach_auto_rule method. Attach an auto rule to appropriate element
	 *
	 */
	private function _attach_auto_rule($name)
	{
		if ( ! isset($this->auto_rules[$name]))
			return;
		
		if (is_array($this->auto_rules[$name][0]))
		{
			foreach ($this->auto_rules[$name] as $rule)
			{
				$this->add_rule($name, $rule[0], $rule[1]);
			}
		}
		elseif (is_array($this->auto_rules[$name]))
		{
			$this->add_rule($name, $this->auto_rules[$name][0], $this->auto_rules[$name][1]);
		}
		else
		{
			$this->add_rule($name, $this->auto_rules[$name]);
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

	/**
	 * add_radio method. Special function for adding a new radio element object
	 * to form
	 *
	 * UNFINISHED
	 *
	 * @return object
	 */
	public function add_radio()
	{	
		return $this;
	}
		
	/**
	 * add_checkbox method. Special function for adding a new checkbox element object
	 * to form
	 *
	 * UNFINISHED
	 *
	 * @return object
	 */
	public function add_checkbox()
	{
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
				unset($this->elements[$el]);
			}
		}
		else
		{
			unset($this->$element);
			unset($this->elements[$element]);
		}
		
		return $this;
	}

	/**
	 * _find_elements method. return all elements. Use order if applicable
	 *
	 * @return array
	 */	
	private function _find_elements()
	{
		if ($this->order)
		{
			$elements[] = '__form_object';
			foreach ($this->order as $v)
			{
				$elements[] = $v;
			}
			return $elements;
		}
		else
		{
			return array_keys($this->elements);
		}
	}

	/**
	 * _elements_to_string method. Build a string of formatted text with all the
	 * form's elements
	 *
	 * @return string
	 */		
	private function _elements_to_string($return_as_array=FALSE)
	{
		foreach (($elements = $this->_find_elements()) as $key)
		{
			if ($return_as_array)
			{			
				$elements_array[$key] = $this->$key->get(TRUE);
				$elements_array[$key.'_error'] = $this->$key->error;
			}
			else
			{
				$this->_filter_label($key);
				$this->_elements_str.= $this->$key->get();			
			}
	
		}
		if ($return_as_array)
			return $elements_array;
			
		return $this->_elements_str;
	}
	
	/**
	 * _make_opentag method. Format form open tag
	 *
	 * @return string
	 */	
	private function _make_opentag()
	{
		$search = array('/{action}/','/{method}/','/{class}/');
		$replace = array($this->action,$this->method,$this->class);
		return preg_replace($search,$replace,$this->open);
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
		return $this->close;
	}
		
	/**
	 * get method. Retun formatted array or entire form
	 *
	 * @return string or array
	 */			
	public function get($array=FALSE)
	{
		$this->add_posts();
		$this->_do_pre_filters();
		if ($this->sent)
		{
			$this->validate(TRUE);
			$this->_process_success();
			$this->_process_failure();
		}

		if ($array == TRUE)
		{
			return $this->_get_array();
		} 
		else 
		{
			return $this->_get();
		}
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
	
	public function get_values()
	{
		$values = array();
		foreach (($elements = $this->_find_elements()) as $element)
		{
			if (($val = $this->$element->get_value()) === FALSE)
				continue;
				
			$values[$element] = $val;
		}
		return $values;
	}	

}	// End Form