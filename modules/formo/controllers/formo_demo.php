 <?php defined('SYSPATH') or die('No direct script access.');

/*==============================================

	Once you include the formo module in your application/config file
	you can view these demos at 'formo_demo', 'formo_demo/demo2', 'formo_demo/demo3', etc.

==============================================*/

class Formo_demo_Controller extends Template_Controller {

	public $template = 'formo_template';
	public $title = "Formo Version 1.0";
	public $header;
	public $content;
	
	private $msg = '<div class="success">Success!</div>';
	
	public function __construct()
	{
		parent::__construct();
		$this->template
			->bind('title', $this->title)
			->bind('header', $this->header)
			->bind('content', $this->content);
	}
		
	/**
	 * Formo Playground. practice building forms
	 *
	 */
	public function index()
	{
		$form = Formo::factory()
			->plugin('habtm')
			->add_habtm('user->1', 'roles', 'role')
			->add('submit');			

		$this->content = $form;

		
		if ($form->validate())
		{
			$this->content = $this->msg.$this->content;
		}
	}
							
	/**
	 * A basic form. All fields are required except "name"
	 *
	 */
	public function demo1()
	{		
		$form = Formo::factory()
			->add('email')
			->add('name', 'required=FALSE')
			->add('ta', 'notes')
			->add('submit');
			
			$form->add_rule('name', array('length[10,20]', 'email'));

												
		$this->header = new View('headers/demo1');
		$this->content = $form;
		
		if ($form->validate())
		{
			$this->content = $this->msg.$this->content;
		}		
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
			->add('email')
			->add('file', 'image', 'allowed_types=png|gif|jpg,max_size=500K,upload_path=modules/formo/uploads/')
			->add('submit', 'Submit', 'class=submit');
		
		
		$form->name->class = 'input';
		$data = $form->get(TRUE);
		
		
		$this->header = new View('headers/demo2');
		$this->content = new View('demo2', $data);
		
		if ($form->validate())
		{
			$this->content = $this->msg.$this->content;
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
		
		
		$this->header = new View('headers/demo3');
		$this->template->content = $form;

		if ($form->validate())
		{
			$this->content = $this->msg.$this->content;
		}
	}

	/**
	 * Radio and checkbox groups intermingled with other stuff
	 *
	 */	
	public function demo4()
	{
		$skills = array(1=>'Poet', 25=>'Artist', 3=>'Television');
		$hobbies = array('run'=>'Run', 'jump'=>'Jump', 'swim'=>'Swim');

		$form = Formo::factory()
			->add('name')
			->add('state')
			->add_group('skill', $skills)
			->add_group('hobbies[]', $hobbies)
			->add('submit');
							
								
		$this->header = new View('headers/demo4');
		$this->content = $form;

		if ($form->validate())
		{
			$this->content = $this->msg.$this->content;
		}		
	}
	
	/**
	 * Using the comments plugin
	 *
	 */	
	public function demo5()
	{
		$form = Formo::factory()
			->plugin('comments')
			->add('username', 'comment=Please do not be obscene,passed=Thank You')
			->add('email', 'comment=Must be a valid email,passed=Good Job,rule=email')
			->add('submit');	
		
		
		$this->header = new View('headers/demo5');
		$this->content = $form;
		
		if ($form->validate())
		{
			$this->content = $this->msg.$this->content;
		}
		
	}
	
}