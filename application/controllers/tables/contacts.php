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
            $publisher = ORM::factory('publisher', $publisher_id);
            $form->add('publisher')->required(TRUE);
            $form->publisher->readonly(TRUE);
            $form->publisher->value = $publisher->name;
        } else
        {
            $publishers = ORM::factory('publisher')->select_list();
            $form->add_select('publisher', $publishers);
        }
        if ($resource_id)
        {
            $resource = ORM::factory('resource', $resource_id);
            $form->add('resource')->required(TRUE);
            $form->resource->readonly(TRUE);
            $form->resource->value = $resource->title;
        } else
        {
            $resources = ORM::factory('resource')->select_list();
            $form->add_select('resource', $resources);
        }
        $form->add('name')
             ->add('email')->required(TRUE)
             ->add('phone')
             ->add('address')
             ->add('position')
             ->add('comments');
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
            $publisher_title = $form->publisher->value;
            
            $contact = ORM::factory('contact');
            $contact->publisher_id = ORM::factory('publisher', $publisher_title)->id;
            $contact->name = $form->name->value;
            $contact->email = $form->email->value;
            $contact->phone = $form->phone->value;
            $contact->address = $form->address->value;
            $contact->position = $form->position->value;
            $contact->comments = $form->comments->value;
            
            $contact->save();
            
            $resource = ORM::factory('resource', $resource_id);
            $resource->contact_id = $contact->id;
            $resource->save();

            message::set_flash('Kontakt byl úspěšně přidán');
            url::redirect('tables/contacts/view/'.$contact->id);
        }
    }
}
?>