<?php
class Conspectus_Controller extends Template_Controller {
    protected $title = 'Konspekt - nominace';
    protected $page_title = 'Konspekt';
    
    public function index() {
        $content = View::factory('conspectus');
        
        $nominations = Nomination_Model::get_new($this->user->id);
        
        $content->form = $this->generate_filter_form()->get(1);
        $content->nominations = $nominations;
        $this->template->content = $content;
    }
    
    public function filter() {
        $form = $this->generate_filter_form();
    	    	
    	$filter = null;
        if (isset($_POST ['filter']) and $_POST ['filter'] == true and $_POST ['conspectus'] != '') {
            $selected_conspectus = $_POST ['conspectus'];
            $selected_conspectus_subcategory = $_POST ['conspectus_subcategory'];
            $form->conspectus->value = $selected_conspectus;
            $form->conspectus_subcategory->value = $selected_conspectus_subcategory;
            $filter ['conspectus'] = $selected_conspectus;
            $filter ['conspectus_subcategory'] = $selected_conspectus_subcategory;
        }
        
        $resources = Resource_Model::get_important($this->user->id, $filter);
        
        $content = View::factory('conspectus');
        $content->form = $form->get(1);
        $content->resources = $resources;
        $this->template->content = $content;
    }
    
    public function accept($resource_id) {
        $this->resolve_nomination($resource_id, true);
    }
    
    public function reject($resource_id) {
        $this->resolve_nomination($resource_id, false);
    }
    
    protected function resolve_nomination($resource_id, $accepted) {
        $resource = ORM::factory('resource')->where('resources.id', $resource_id)->with('nomination')->find();
        if ($this->user->id != $resource->curator_id) {
            message::set_flash('Nemáte oprávnění na vyhodnocení nominace.');
            url::redirect('conspectus');
        }
        
        $nomination = $resource->nomination;
        $nomination->date_resolved = date_helper::mysql_date_now();
        $nomination->accepted = $accepted;
        $nomination->save();
        
        if ($accepted === true) {
            $resource->important = true;
            $resource->save();
        }
        if ($nomination->saved) {
            message::set_flash('Rozhodnutí bylo úspěšně uloženo');
        }
        url::redirect('conspectus');
    }

    protected function generate_filter_form($selected_conspectus = 1, $selected_conspectus_subcategory = null) {
    	$conspectus = ORM::factory('conspectus')->select_list('id', 'title');
    	$form = Formo::factory('conspectus_select');
        $form->add_select('conspectus', $conspectus, 'style=width:250px;')->id('category_select')->blank(true);
        $form->add_select('conspectus_subcategory', '', 'style=width:270px;')->id('subcategory_select')->blank(true);
        
        $subcategories = ORM::factory('conspectus_subcategory')->where('conspectus_id', $selected_conspectus)->select_list('id', 'title');
        
        $form->conspectus_subcategory->values = $subcategories;
        
        return $form;
    }
}
?>