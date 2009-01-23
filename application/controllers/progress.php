<?php
class Progress_Controller extends Template_Controller {
	
	protected $title = 'V jednání';
	
	public function index() {
		$view = new View('progress');
		$this->template->content = $view;
	}
}
?>