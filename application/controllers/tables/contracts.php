<?php
class Contracts_Controller extends Table_Controller
{
    protected $table = 'contracts';
    protected $title = 'Contracts';
    protected $header = 'Smlouva';
    protected $columns_ignored = array('id');
    protected $view = 'tables/table_contracts';

    public function view ($id = NULL)
    {
        parent::view($id);

        $contract = $this->record;
        $resources = $contract->get_resources();

        $append_view = View::factory('tables/append_contract');
        $append_view->resources = $resources;

        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }    
}
?>