<?php
class Home_Controller extends Template_Controller {
	protected $title = 'Home';
	
	public function index() {		
		$content = new View('home');
		$dash_view = new View('dashboard');
		$dash_view->dashboard = Dashboard_Model::factory();
		$content->dashboard = $dash_view;
		$content->stats = Statistic_Model::factory()->getBasic();
		
		$this->template->content = $content;
	}
	
}
?>