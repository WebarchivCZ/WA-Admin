<?php
class Quality_Control_Controller extends Template_Controller {
	
	protected $title = 'Hodnocení zdrojů';
	
	public function index() {
		$view =	new View('quality_control');
		$this->template->content = $view; 
	}
	
	public function edit($id = NULL) {
		$view = new View('quality_control_form');
                
		/*$form = new Forge();
		$form->radiolist('quality')->options(array('co', 'neco'));
		$view->form = $form;*/
		
		$this->template->content = $view;
	}
	
}
?>