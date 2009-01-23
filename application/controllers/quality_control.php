<?php
class Quality_Control_Controller extends Template_Controller {
	
	protected $title = 'Hodnocení zdrojů';
	
	public function index() {
		$view =	new View('quality_control');
		$this->template->content = $view; 
	}
	
}
?>