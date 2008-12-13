<?php
class Resource_Controller extends Template_Controller
{

    protected $title = 'Zdroj';

    public function index ()
    {

    }

    public function insert ()
    {
        
        $conspectus_array = array(
            '1' => 'neco');
        
        $ratings_array = array(
            '0' => 'NE' , 
            '1' => 'ANO' , 
            '2' => 'MOŽNÁ' , 
            '3' => 'TECHNICKÉ NE');
        
        $curators_array = array(
            '0' => 'Coufal' , 
            '1' => 'Sibek' , 
            '2' => 'Gruber');
        
        $crawl_freq_array = array(
            '0' => '14 dni' , 
            '1' => '1 mesic' , 
            '2' => '2 mesice' , 
            '3' => '3 mesice' , 
            '4' => '6 mesicu' , 
            '5' => '12 mesicu' , 
            '6' => 'jednou');
        
        $suggested_by_array = array(
            '0' => 'kurator' , 
            '1' => 'web/vydavatatel' , 
            '2' => 'web/navstevnik' , 
            '3' => 'ISSN');
        
        $resource_status_array = array(
            '0' => 'novy' , 
            '1' => 'schvalen' , 
            '2' => 'neschvalen' , 
            '3' => 'k prehodnoceni');
        
        $form_models = array('publisher', 'contract');
        
        $crawl_freq_m = new Crawl_Freq_Model();
        $crawl_freq_array = $crawl_freq_m->find_all()->as_array();
        
        $form = new Forge(NULL, '', 'POST', array(
            'id' => 'resource_form'));
        $form->input('title')->label('Název')->rules('required|length[3,40]|valid_alpha_numeric');
        $form->input('publisher')->label('Vydavatel')->rules('required|length[3,40]|valid_alpha_numeric');
        $form->input('url')->label('URL')->value('http://')->rules('required|valid_url');
        $form->input('ISSN')->label('ISSN')->rules('valid_alpha_numeric');
        $form->input('aleph_id')->label('Aleph ID')->rules('valid_alpha_numeric');
        $form->input('date')->label('Datum')->value(date('d-m-Y h:i:s'));
        $form->input('contract')->label('Smlouva');
        $form->dropdown('suggested_by')->label('Navrhl')->options($suggested_by_array)->rules('required');
        $form->dropdown('resource_status')->label('Status')->options($resource_status_array)->rules('required');
        $form->dropdown('conspectus')->label('Konspekt')->options($conspectus_array)->rules('required');
        $form->dropdown('rating_result')->label('Hodnocení')->options($ratings_array);
        $form->dropdown('curator')->label('Správce')->options($curators_array);
        $form->dropdown('crawl_freq')->label('Frekvence sklizeni')->options($crawl_freq_array);
        $form->checkbox('catalogued')->label('Katalogizovano');
        $form->checkbox('metadata')->label('Metadata');
        $form->checkbox('creative_commons')->label('Creative Commons');
        $form->textarea('tech_problems')->label('Technické problémy');
        $form->textarea('comments')->label('Komentář');
        $form->submit('Vložit');
        
        $p_form = new Forge();
        $p_form->input('name')->label('Jmeno vydavatele');
        $p_form->submit('Hledat');
        
        $view = new View('insert_resource');
        
        if ( $form->validate() ) {
            $publisher_name = $form->publisher->value;
            
            $publisher = ORM::factory('publisher')->like('name', $publisher_name);
            
            if ( empty($publisher->name) ) {
                $publisher->name = $publisher_name;
                $publisher->save();
            }
            
            $contract_no = $form->contract->value;
            
            if ( ! empty($contract_no) ) {
            	$contract = ORM::factory('contract')->where('contract_no', $contract_no);
            	if (empty($contract->contract_no)) {
            		$contract = ORM::factory('contract')->contract_no;
            		$contract->save;
            	}
            }
                
                $resouce = ORM::factory('resource');
            $values = $form->as_array();
            
            foreach ($values as $column => $value) {
                if ( $resouce->is_related($column) ) {
                    if (in_array($column, $form_models)){
                    	$value = ${$column}->id;
                    }
                    $column = $column . '_id';
                }
                $resouce->$column = $value;
            }
            
            $view->content = Kohana::debug($resouce);
        } else {
            $view->content = $form;
        }
        
        $this->template->content = $view;
    }

}
?>