<?php
class Resources_Controller extends Table_Controller
{
    protected $table = 'resources';
    protected $title = 'Resources';
    protected $columns_ignored = array('id', 'publisher_id');
    protected $header = 'Zdroj';
    
    public function view($id = FALSE)
    {
        parent::view($id);
        $append_view = View::factory('tables/append_resource');
        $append_view->resource = $this->record;
        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }
}
?>