<?php
class Contacts_Controller extends Table_Controller
{
    protected $table = 'contacts';
    protected $title = 'Contacts';
    protected $header = 'Kontakt';
    protected $columns_ignored = array('id');

    public function view($id = FALSE)
    {
        parent::view($id);
        $append_view = View::factory('tables/append_contact');
        $append_view->resources = ORM::factory('resource')
            ->where('contact_id', $id)
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
        $form = Formo::factory();
        //TODO presunout do vlastni metody
        if ($publisher_id)
        {
            $form->add('publisher_id');
            $form->publisher_id->disabled(TRUE);
            $form->publisher_id->value = $publisher_id;
        } else
        {
            $publishers = ORM::factory('publisher')->select_list();
            $form->add_select('publisher_id', $publishers);
        }
        if ($resource_id)
        {
            $form->add('resource_id');
            $form->resource_id->value = $resource_id;
            $form->resource_id->disabled(TRUE);
        } else
        {
            $resources = ORM::factory('resource')->select_list();
            $form->add_select('resource_id', $resources);
        }
        $form->add('name')->add('email');
        $form->remove($this->columns_ignored);
        $form->add('submit', 'Vložit')
            ->label_filter('display::translate_orm')
            ->label_filter('ucfirst');
        $view = new View('tables/record_add');
        $view->header = $this->header;
        $view->type = 'edit';
        $view->form = $form->get();
        $this->template->content = $view;
        if ($form->validate())
        {
            $form->save();
            $contact_id = $this->session->get('__formo_model_contact');
            $resource = ORM::factory('resource', $resource_id);
            echo($form->resource_id->value);
            $resource->contact_id = $contact_id;
        //$resource->save();
        }
    }
}
?>