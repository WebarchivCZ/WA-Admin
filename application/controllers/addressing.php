<?php
class Addressing_Controller extends Template_Controller {
	
	protected $title = 'Oslovování';
	
	public function index() {
		$view = new View('addressing');
		$this->template->content = $view;
	}
}
?>