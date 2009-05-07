<?php defined('SYSPATH') or die('No direct script access.');

/*=====================================

Formo Plugin Modelval

Version 1.0b

If a form passes basic validation, the values
are passed to a model to validate and enter stuff.

Formo Functions Added:
	add_model

Formo Properties Bound:
	orm
	
Formo Events Used:
	post_validate

=====================================
Usage
=====================================

$form
	->plugin('mval')
	->add_model('model_name', 'my_method', 'element|element2' (optional), $construct_data (optional));
	
// Then in your model, create a method:

public function my_method()
{
	// if there is an error, use add_error():
	foreach (Formo_mval::$data as $element => $value)
	{
		if ( ! $value_passess_test)
		{
			Formo_mval::$form->add_error($element, 'This is an error message');
		}
	}	
}

Note the $data passed to the method is all of the values of the
form by default, and only the defined elements if specified.

=====================================*/

class Formo_mval {
	
	public static $form;
	public static $data = array();
	
	public $models = array();
	
	public function __construct( & $form)
	{
		// reference the form object
		self::$form = $form;
		
		// attach events
		Event::add('formo.post_validate', array($this, 'validate'));
		
		// attach functions
		self::$form
			->add_function('add_model', array($this, 'add_model'));
	}

	public static function load( & $form)
	{
		return new Formo_mval($form);
	}
	
	/**
	 * add_model function.
	 * 
	 * @access public
	 * @param mixed $model
	 * @param mixed $method
	 * @param array $data. (default: array()
	 * @return void
	 */
	public function add_model($model, $method, $data = array(), $construct_data = NULL)
	{
		$this->models[] = array('model'=>$model, 'method'=>$method, 'data'=>Formo::splitby($data), 'construct_data'=>$construct_data);
	}
	
	/**
	 * validate function.
	 * 
	 * @access public
	 * @return void
	 */ 
	public function validate()
	{
		if ( ! self::$form->_validated)
			return;
		
		foreach ($this->models as $values)
		{
			$data = NULL;
			$model = $values['model'];
			$method = $values['method'];

			if ($values['data'])
			{
				foreach ($values['data'] as $element)
				{
					$data[$element] = self::$form->get_values($element);
				}
			}
			else
			{
				$data = self::$form->get_values();
			}
			
			self::$data = $data;
			
			if ( ! is_object($model))
			{
				$model_class = ucfirst($model).'_Model';
			
				$m = new $model_class($values['construct_data']);
				$m->$method();
			}
			else
			{
				$model->$method();
			}
			
		}
		
		foreach (self::$form->find_elements() as $element)
		{
			if (self::$form->$element->error)
			{
				self::$form->error = TRUE;
				self::$form->validated = FALSE;
			}
		}
	}

}