<?php
class Rate_Controller extends Template_Controller {
	
	protected $title = 'Hodnocení zdrojů';
	
	public function index() {
		$view =	new View('rate');
		$this->template->content = $view; 
	}
	
	public function save() {
		$view = new View('rating_save');
		$this->template->content = $view;
	}
}
?>