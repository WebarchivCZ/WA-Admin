<?php defined('SYSPATH') or die('No direct script access.');

/*=====================================

Formo Plugin Orm

Version 1.0b

Adds a bunch of shortcut methods to

Formo Functions Added:
	add_ta, ta  - textarea
	add_ra, ra  - radio
	add_g, g    - group
	add_cb, cb  - checkbox
	add_sel, sel - select
	add_hid, hid - hidden
	add_sub, sub - submit
	add_but, but - button
	add_txt, txt - text
	add_pass, pass - password
	add_bool, bool - bool
	add_cap, cap - captcha

Formo Properties Bound:
	none
		
Formo Events Used:
	none

=====================================*/


class Formo_shortcuts {

	protected $form;
	protected static $shortcuts = array
	(
		'ta'	=> 'textarea',
		'ra'	=> 'radio',
		'cb'	=> 'checkbox',
		'g'		=> 'group',
		'sel'	=> 'select',
		'img'	=> 'image',
		'but'	=> 'button',
		'hid'	=> 'hidden',
		'sub'	=> 'submit',
		'pass'	=> 'password',
		'txt'	=> 'text',
		'bool'	=> 'bool',
		'cap'	=> 'captcha',
		'file'	=> 'file',
	);

	public function __construct( & $form)
	{
		$this->form = $form;
		foreach (self::$shortcuts as $short => $long)
		{
			$form->add_function('add_'.$short, array($this, $long));
			$form->add_function($short, array($this, $long));
		}
	}

	public static function load( & $form)
	{
		return new Formo_shortcuts($form);
	}
		
	// =======================================================

	public function __call($method, $values)
	{
		$values[1] = ( ! isset($values[1])) ? array() : $values[1];
		$this->form->add($method, $values[0], $values[1]);
	}	
		
	public function select($name, $values=array(), $info=array())
	{
		$info = Formo::quicktags($info);
		$info['values'] = $values;
		$this->form->add('select', $name, $info);
	}
			
	public function group($name, $values, $info=NULL)
	{
		$this->form->add_group($name, $values, $info);
	}
	
	public function image($name, $src, $info=array())
	{
		$info = Formo::quicktags($info);
		$info['src'] = $src;
		$this->form->add('image',$name,$info);	
	}
	
	public function button($value, $info=array())
	{
		$info = Formo::quicktags($info);
		$info['value'] = $value;
		$this->form->add('button', $value, $info);	
	}
		
}