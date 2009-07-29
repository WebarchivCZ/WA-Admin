<?php
class Contacts_Controller extends Table_Controller
{
    protected $table = 'contacts';
    protected $title = 'Contacts';
    protected $columns_ignored = array('id', 'publisher_id');

    public function view($id = FALSE)
    {
        parent::view($id);
        $append_view = View::factory('tables/append_contact');
        $append_view->resources = ORM::factory('resource')
            ->where('contact_id', $id)
            ->find_all();
        $append_view->publishers = ORM::factory('publisher')
            ->where('id', $this->record->publisher_id)
            ->find_all();
        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }

    /**
     *
     * @param int $publisher_id id vydavatele, ke kteremu patri kontakt
     * @param int $resource_id id zdroje, ke kteremu patri kontakt
     */
    public function add($publisher_id = FALSE, $resource_id = FALSE)
    {
    // TODO refaktorovat duplicitu s table_controller
        $form = Formo::factory()->orm($this->model)
            ->remove('id')
            ->set('publisher_id', 'value', $publisher_id)
            ->add('resource')->set('resource', 'value', $resource_id)
            ->add('submit', 'Upravit')
            ->label_filter('display::translate_orm')
            ->label_filter('ucfirst');
        $view = new View('edit_table');
        $view->type = 'edit';
        $view->form = $form->get();
        $this->template->content = $view;
        if ($form->validate())
        {
            $form->save();
            $contact_id = $this->session->get('__formo_model_contact');
            $resource_id = $form->resource->value;
            $resource = ORM::factory('resource', $resource_id);
            echo $resource_id;
            echo $contact_id;
            $resource->contact_id = $contact_id;
            $resource->save();
        }
    }
}
?>