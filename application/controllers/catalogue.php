<?php
/**
 * TODO zobrazovat jen zdroje, ktere spravuje kurator a ktere nebyly katalogizovany AND zapsany metadata
 * TODO proklik na editace zdroje
 *
 */
class Catalogue_Controller extends Template_Controller {
	
	protected $title = 'Katalogizace';
        protected $page_header = 'Zdroje ke katalogizaci';
	
	public function index() {
		$view = new View('catalogue');
		$this->template->content = $view;
	}
}
?>