<?php
class Publishers_Controller extends Table_Controller
{
    protected $table = 'publishers';
    protected $title = 'Publishers';

    public function view($id = FALSE)
    {
        parent::view($id);
        $append_view = View::factory('tables/append_publisher');
        $append_view->resources = ORM::factory('resource')
                                                ->where('publisher_id', $id)
                                                ->find_all();
        $append_view->contacts = ORM::factory('contact')
                                                ->where('publisher_id', $id)
                                                ->find_all();
        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }
}
?>