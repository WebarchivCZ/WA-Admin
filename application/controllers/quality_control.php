<?php
class Quality_Control_Controller extends Template_Controller {
	
	protected $title = 'Kontrola kvality';
	
	public function index() {
		$view =	new View('quality_control');
		$this->template->content = $view; 
	}
	
	public function edit($id = NULL) {
		$view = new View('quality_control_form');
                
		$this->template->content = $view;
	}
	
}
?>