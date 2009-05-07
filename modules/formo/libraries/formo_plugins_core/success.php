<?php defined('SYSPATH') or die('No direct script access.');

/*=====================================

Formo Plugin Success

Version 1.0b

Run successive on_success or on_failure
functions automatically upon validation success
and failure.

Formo Functions Added:
	add_success
	add_failure

Formo Properties Bound:
	
Formo Events Used:
	post_validate

=====================================*/


class Formo_success {

	public $form;
	
	public $on_success = array();
	public $on_failure = array();
	
	public function __construct( & $form)
	{
		$this->form =& $form;
		Event::add('formo.post_validate', array($this, 'do_functions'));
		
		$this->form
			->add_function('add_success', array($this, 'add_success'))
			->add_function('add_failure', array($this, 'add_failure'));
	}
	
	public static function load( & $form)
	{
		return new Formo_success($form);
	}
			
	public function add_success($function, $args=NULL)
	{
		$this->on_success[] = array
		(
			'function'	=> $function,
			'args'		=> $args
		);
	}
	
	public function add_failure($function, $args=NULL)
	{
		$this->on_failure[] = array
		(
			'function'	=> $function,
			'args'		=> $args
		);
	}
	
	public function do_functions()
	{
		$use = ( ! $this->form->_validated) ? 'on_failure' : 'on_success';

		foreach ($this->$use as $array)
		{
			list($function, $args) = Formo::into_function($array['function']);
			
			if ($array['args'])
			{
				array_unshift($args, $array['args']);
			}
			array_unshift($args, $this->form->get_values());

			switch ($function)
			{
				case 'url::redirect':
					url::redirect($args[count($args)-1]);
					break;
				default:
					call_user_func_array($function, $args);
					return;	
			}			
		}
	}

}