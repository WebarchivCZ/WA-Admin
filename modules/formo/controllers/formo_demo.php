<?php defined('SYSPATH') or die('No direct script access.');

/*==============================================

	Once you include the formo module in your application/config file
	you can view these demos at 'formo_demo', 'formo_demo/demo2', 'formo_demo/demo3', etc.

==============================================*/

class Formo_demo_Controller extends Template_Controller {

	public $template = 'formo_demo';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * A basic form. All fields are required except "name"
	 *
	 */
	public function index()
	{
		$form = Formo::factory()
			->add('email')
			->add('name','required=FALSE')
			->add('ta', 'notes')
			->add('submit');
		
		$this->template->content = $form->get();
	}
		
	/**
	 * this is an example of working with arrays
	 * to test out the file upload capability, set the uploads folder inside /formo to 777
	 *
	 */ 
	public function demo2()
	{
		$form = Formo::factory()
			->add('name')
			->add('file', 'image', 'allowed_types=png|gif|jpg,max_size=500K,upload_path=modules/formo/uploads/')
			->add('submit', 'Submit', 'class=submit');
		
		$form->name->class = 'input';
		$data = $form->get(TRUE);
		
		if ( ! $form->validate())
		{
			$this->template->content = new View('demo2', $data);
		}
		else
		{
			$this->template->content = "You did it!";
			echo Kohana::debug($form->get_values());
		}					
		
	}
	
	/**
	 * A more complicated form that includes settings set on the fly.
	 * Generally, you would set these settings in the config file
	 *
	 */
	public function demo3()
	{	
		$defaults = array('email'=>array('label'=>'E-mail'));
		$favorites = array('_blank_'=>'', 'Run'=>'run', 'Jump'=>'jump', 'Swim'=>'swim');
		
		$form = Formo::factory()
			->set_defaults($defaults) // you can add defaults on the fly like so
			->add('username')
			->add('email')
			->add('phone')

			->add_html('space', '<div style="height:15px"></div>')
			->add_select('activity', $favorites, array('label'=>'Favorite Activity', 'required'=>TRUE, 'style'=>'width:150px'))

			->add_html('space2', '<div style="height:15px"></div>')
			->add('password', 'password', 'required=true')
			->add('password', 'password2')
			
			->add_html('space3', '<div style="height:15px"></div>')			
			->add('ta', 'notes')
			->add('submit', 'Submit', 'class=submit')
			
			->label_filter('ucwords')
			->pre_filter('all', 'trim')
			->add_rule('password', 'match[password2]', "Doesn't match")
			->add_rule('password2', 'match[password]', "Doesn't match")
			->add_rule('phone', 'phone[10]');
		
		if ( ! $form->validate())
		{
			$this->template->content = $form->get();
		}
		else
		{
			$this->template->content = "You did it!";
			echo Kohana::debug($form->get_values());
		}		
	}
	

}