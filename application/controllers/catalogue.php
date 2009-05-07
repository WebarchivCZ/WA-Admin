<?php
/**
 * TODO zobrazovat jen zdroje, ktere spravuje kurator a ktere nebyly katalogizovany AND zapsany metadata
 *
 */
class Catalogue_Controller extends Template_Controller {
	
	protected $title = 'Katalogizace';
	
	public function index() {
		$view = new View('catalogue');
		$this->template->content = $view;
	}
}
?>