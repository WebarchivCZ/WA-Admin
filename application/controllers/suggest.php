<?php
class Suggest_Controller extends Template_Controller
{
    protected $title = 'Vložení nového zdroje';
    public function index ()
    {
        $form = new Forge('suggest', 'Vložit zdroj', 'POST', array('id' => 'resource_form'));
        $form->set_attr('class', 'form_class')->set_attr('method', 'post');
        $form->input('title')->label('Název')->rules('required|length[3,40]|valid_alpha_numeric');
        $form->input('publisher')->label('Vydavatel')->rules('required|length[3,40]|valid_alpha_numeric');
        $form->input('url')->label('URL')->value('http://')->rules('required|valid_url');
        $form->submit('Vložit');
        
        $view = new View('insert_resource');
        
        if ($form->validate()) {
            $title = $form->title->value;
            $publisher_id = 1;
            $url = $form->url->value;
           
        	$match_resources = ORM::factory('resource')->orwhere(
        	array('title' => $title, 'publisher_id' => $publisher_id, 'url' => $url)
        	)->find();
        	
        	if ($match_resources->count_all() == 0) {
        		echo "x";      	
        	}
        	$view->content = Kohana::debug($match_resources);
        	
        } else {
            $view->content = $form->render();
        }
        $this->template->content = $view;
    }
    
}
?>