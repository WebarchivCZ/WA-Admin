<?php
class Catalogue_Controller extends Template_Controller {
	
	protected $title = 'Katalogizace';
	
	public function index() {
		$view = new View('catalogue');
		$this->template->content = $view;
	}
}
?>