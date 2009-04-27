<?php
class Addressing_Controller extends Template_Controller {
	
	protected $title = 'Oslovování';
	
	public function index() {
		
		$resources = ORM::factory('resource')
								->in('resource_status_id', array(2,4))
								->where('curator_id', $this->user->id)
								->find_all();
		
		$view = new View('addressing');
		$view->resources = $resources;
		
		$this->template->content = $view;
	}
}
?>