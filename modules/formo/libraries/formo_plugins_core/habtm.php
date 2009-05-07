<?php defined('SYSPATH') or die('No direct script access.');

/*=======================================

Formo Plugin HABTM

Version 1.0

Must be loaded instead of orm plugin (this extends it), and requires orm plugin to be loaded

Formo Functions Added:
	add_habtm
	all orm functions

Formo Properties Bound:
	
Formo Events Used:
	habtm_pre_addpost


=======================================*/

Formo::include_file('plugin', 'orm');

class Formo_habtm extends Formo_orm {

	protected $elements = array();
	
	protected $habtm_model = array();
	protected $habtm_plural = array();
	protected $habtm_table = array();
	protected $habtm_name = array();
	
	public function __construct( & $form)
	{
		parent::__construct($form);
								
		$this->form
			->add_function('add_habtm', array($this, 'add_habtm'));
	}
	
	public static function load( & $form)
	{
		return new Formo_habtm($form);
	}
			
	public function add_habtm($model, $plural = NULL, $table_var = NULL)
	{
		if ( ! $table_var)
		{
			$table_var = $plural;			
			$plural = $model;

			// if no model is specified, use the last loaded model
			foreach ($this->form->model as $key => $_model)
			{
				$model = $this->form->model[$key]; 
				break;
			}
		}
		elseif (empty($this->form->model[$model]))
		{
			$parts = explode('->', $model);
			$_model = $parts[0];
			$_id = (isset($parts[1])) ? $parts[1] : NULL;
			$model = ORM::factory($_model, $_id);
			$model = ORM::factory('user', 1);
		}
		elseif ( ! is_object($model))
		{
			$model = $this->form->model[$model];
		}
				
		$tables = explode('->', $table_var);
		$_table = $tables[0];
		$keyname = "$model.$_table";
				
		$this->habtm_name[$keyname] = ( ! empty($tables[1])) ? $tables[1] : 'name';
		$this->habtm_plural[$keyname] = $plural;
		$this->habtm_table[$keyname] = $_table;
		$this->habtm_model[$keyname] = $model;
		
		$values = array();
		foreach (ORM::factory($this->habtm_table[$keyname])->find_all() as $option)
		{
			$values[$option->id] = $option->{$this->habtm_name[$keyname]};
			$this->elements[$keyname][] = $option->{$this->habtm_name[$keyname]};
		}		
		
		$this->form->add_group($this->habtm_table[$keyname].'[]', $values)->set($this->habtm_table[$keyname], 'required', FALSE);
		
		$this->fill_initial_values($keyname);
	}
	
	protected function fill_initial_values($keyname)
	{
		foreach ($this->habtm_model[$keyname]->{$this->habtm_plural[$keyname]} as $checked)
		{
			$this->form->check($this->habtm_table[$keyname], $checked->{$this->habtm_name[$keyname]});
		}	
	}
	
	public function save($name = '')
	{
		parent::save($name);
		$this->habtm_save();
	}

	public function auto_save()
	{
		parent::auto_save();
		if ( ! $this->form->_error AND $this->auto_save === TRUE AND $this->habtm_model)
		{
			$this->habtm_save();
		}
	}
	
	protected function habtm_save($keyname = '')
	{
		if ( ! empty($keyname))
		{
			foreach ($this->elements[$keyname] as $element)
			{
				if ($this->form->{$this->habtm_table[$keyname]}->$element->checked === TRUE)
				{
					$this->habtm_model[$keyname]->add(ORM::factory($this->habtm_table[$keyname])->where($this->habtm_name[$keyname], $element)->find());
				}
				else
				{
					$this->habtm_model[$keyname]->remove(ORM::factory($this->habtm_table[$keyname])->where($this->habtm_name[$keyname], $element)->find());
				}
			}
			
			return $this->habtm_model[$keyname]->save();	

		}

		foreach ($this->elements as $keyname => $elements)
		{
			$this->habtm_save($keyname);
		}

	}

}