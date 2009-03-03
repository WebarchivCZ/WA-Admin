<?php
class Suggest_Controller extends Template_Controller
{

	protected $title = 'Vložení nového zdroje';

	public function index ()
	{
		$form = new Forge('suggest', '', 'POST', array(
			'id' => 'resource_form'));
		
		$form->set_attr('class', 'form_class')->set_attr('method', 'post');
		$form->input('title')->label('Název')->rules('required|length[1,100]');
		$form->input('publisher')->label('Vydavatel')->rules('required|length[1,100]');
		$form->input('url')->label('URL')->value('http://')->rules('required|valid_url');
		$form->submit('Ověřit', 'check_button');
		
		$view = new View('suggest');
		
		if ($form->validate()) {
			
			$publisher_name = $form->publisher->value;
			$title = $form->title->value;
			$url = $form->url->value;
			
			$curators = ORM::factory('curator')->select_list('id', 'username');
			$conspectus = ORM::factory('conspectus')->select_list('id', 'category');
			$suggested_by = ORM::factory('suggested_by')->select_list('id', 'proposer');		
			
			$form->dropdown('curator')
					->label('Kurátor')
					->options($curators)
					->value(Auth::instance()->get_user());
			$form->dropdown('conspectus')
					->label('Konspekt')
					->options($conspectus);
			$form->submit('Vložit', 'insert_button');
			
			if (isset($_POST['check_button'])) {

			$publishers = ORM::factory('publisher')->like('name', $publisher_name)->find_all();
			$resources = ORM::factory('resource')->orlike(array(
				'title' => $title , 
				'url' => $url))->find_all();
			
			if (($publishers->count() != 0) or ($resources->count() != 0)) {
				$view->message = 'Byly nalezeny shody:';
				$view->match_publishers = $publishers;
				$view->match_resources = $resources;
			} else {
				$view->message = 'Nenalezeny shody.';
			}
			
			}
			if (isset($_POST['insert_button'])) {
				$form->curator->selected($_POST['curator']);
				$form->conspectus->selected($_POST['conspectus']);
				
				$curator = $form->curator->selected;
				$conspectus = $form->conspectus->selected;
								
				$publisher = ORM::factory('publisher');
				$publisher->name = $publisher_name;
				$publisher->save();
				$resource = new Resource_Model();
				$resource->title = $title;
				$resource->url = $url;
				$resource->publisher_id = $publisher->id;
				$resource->conspectus_id = $conspectus;
				$resource->curator_id = $curator;
				//navrhl kurator
				$resource->suggested_by_id = 1;
				$resource->save();
				//url::redirect('suggest/insert');
			}
		}
		
		$view->form = $form->render();

		$this->template->content = $view;
	}
	
	

}
?>