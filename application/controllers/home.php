<?php
class Home_Controller extends Template_Controller {
	protected $title = 'Home';
	protected $page_title = 'Dashboard';
        
	public function index() {		
		$content = new View('home');
		$dash_view = new View('dashboard');
		$dash_view->dashboard = Dashboard_Model::factory();
		$content->dashboard = $dash_view;
		$content->stats = Statistic_Model::factory()->getBasic();
		$form = new Forge();
		$form->input('search_string')->label(FALSE);
		$form->submit('Hledat');
		
		$content->form = $form;
		$this->template->content = $content;
	}
	
}
?>