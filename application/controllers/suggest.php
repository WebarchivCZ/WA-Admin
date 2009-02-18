<?php
class Suggest_Controller extends Template_Controller
{

	protected $title = 'Vložení nového zdroje';

	public function index ()
	{
		$curators = ORM::factory('curator')->select_list('id', 'username');
		$conspectus = ORM::factory('conspectus')->select_list('id', 'category');
		
		$form = new Forge('suggest','', 'POST', array(
			'id' => 'resource_form'));
		$form->set_attr('class', 'form_class')->set_attr('method', 'post');
		$form->input('title')->label('Název')->rules('required|length[1,100]');
		$form->input('publisher')->label('Vydavatel')->rules('required|length[1,100]');
		$form->input('url')->label('URL')->value('http://')->rules('required|valid_url');
		$form->submit('Ověřit', 'check');
		
		$view = new View('suggest');
		
		if ($form->validate() AND isset($form->insert)) {
			//TODO vlozeni zdroje
			$view->message = "Vložit zdroj";
		}
		else if ($form->validate()) {
			$publisher = $form->publisher->value;
			$resource = $form->title->value;
			$url = $form->url->value;
			
			$publishers = ORM::factory('publisher')->like('name', $publisher)->find_all();
			$resources = ORM::factory('resource')->orlike(array('title' => $resource, 'url' => $url))->find_all();
			
			if (($publishers->count() != 0) OR ($resources->count() != 0)) {
				$view->message = 'Byly nalezeny shody:';
				$view->match_publishers = $publishers;
				$view->match_resources = $resources;
			} else {
				$view->message = 'Nenalezeny shody.';
			}
			// TODO nastavit kuratora podle prihlaseni
			$form->dropdown('curator')->label('Kurátor')->options($curators);
			$form->dropdown('conspect')->label('Konspekt')->options($conspectus);
			$form->submit('Vložit', 'insert');
			unset($form->inputs['check']);
		}
		
		
		
		$view->form = $form->render();
		$this->template->content = $view;
	}

}
?>