<?php
class Resource_Controller extends Template_Controller
{

	protected $title = 'Zdroj';

	public function index ()
	{}

	public function insert ()
	{
		$view = new View('insert_resource');
		
		$ratings_array = array('1' => 'NE' , '2' => 'ANO' , '3' => 'MOŽNÁ' , '4' => 'TECHNICKÉ NE');
		$form_models = array('publisher' , 'contract');
		
		$resource_status_array = ORM::factory('resource_status')->select_list('id', 'status');
		$conspectus_array = ORM::factory('conspectus')->select_list('id', 'category');
		$crawl_freq_array = ORM::factory('crawl_freq')->select_list('id', 'frequency');
		$curators_array = ORM::factory('curator')->select_list('id', 'lastname');
		$suggested_by_array = ORM::factory('suggested_by')->select_list('id', 'proposer');
		$form = new Forge(NULL, '', 'POST', array('id' => 'resource_form'));
		$form->input('title')->label('Název')->rules('required|length[3,150]');
		$form->input('publisher')->label('Vydavatel')->rules('required|length[3,150]');
		$form->input('url')->label('URL')->value('http://')->rules('required|valid_url');
		$form->input('ISSN')->label('ISSN')->rules('valid_alpha_numeric');
		$form->input('aleph_id')->label('Aleph ID')->rules('valid_alpha_numeric');
		$form->input('contract')->label('Smlouva')->rules('length[6,10]');
		$form->dropdown('suggested_by')->label('Navrhl')->options($suggested_by_array)->rules('required');
		$form->dropdown('resource_status')->label('Status')->options($resource_status_array)->rules('required');
		$form->dropdown('conspectus')->label('Konspekt')->options($conspectus_array)->rules('required');
		$form->dropdown('rating_result')->label('Hodnocení')->options($ratings_array)->rules('required');
		$form->dropdown('curator')->label('Správce')->options($curators_array);
		$form->dropdown('crawl_freq')->label('Frekvence sklizeni')->options($crawl_freq_array);
		$form->checkbox('catalogued')->label('Katalogizovano');
		$form->checkbox('metadata')->label('Metadata');
		$form->checkbox('creative_commons')->label('Creative Commons');
		$form->textarea('tech_problems')->label('Technické problémy');
		$form->textarea('comments')->label('Komentář');
		$form->submit('Vložit');
		
		if ($form->validate()) {
			$resource = ORM::factory('resource');
			
			$publisher_name = $form->publisher->value;
			$publisher = ORM::factory('publisher')->find_insert($publisher_name);
			
			$contract_no = $form->contract->value;
			$contract = ORM::factory('contract')->find_insert($contract_no);
			
			$values = $form->as_array();
			
			foreach ($values as $column => $value) {
				if (! empty($value)) {
					if ($resource->is_related($column)) {
						if ($column === 'publisher' or $column === 'contract') {
							$value = ${$column}->id;
						}
						$column = $column . '_id';
					}
					$resource->{$column} = $value;
				}
			}
			$resource->save();
			
			$values = $resource->as_array();
			$view->values = $values;
		
		} else {
			$view->content = $form;
		}
		$this->template->content = $view;
	}
}
?>