<?php
/**
 * DONE proklik na editace zdroje
 * TODO zobrazovat zdroje, ktere vyhovuji podminkam - zjistit
 *
 */
class Catalogue_Controller extends Template_Controller
{

    protected $title = 'Katalogizace';
    protected $page_header = 'Zdroje ke katalogizaci';

    public function index()
    {
        $view = new View('catalogue');
        $this->template->content = $view;

        $resources = ORM::factory('resource')
            ->in('resource_status_id', array(2, 3, 4, 5, 6, 7, 8))
            ->where('curator_id', $this->user->id)
            ->orwhere('catalogued', 'NULL')
            ->find_all();

        $view->resources = $resources;
    }

    /**
     * Ulozi informaci o provedene akci u daneho zdroje. Povolene akce - katalogizace a metadata.
     * @param <type> $action provedena akce (odpovida sloupci v tabulce), povoleno - catalogued, metadata
     * @param <type> $resource_id id zdroje, ktereho se uprava tyka
     */
    public function save ($action, $resource_id)
    {
        $allowed_actions = array('catalogued', 'metadata');
        $resource = ORM::factory('resource', $resource_id);
        if (in_array($action, $allowed_actions))
        {
            $date_format = Kohana::config('wadmin.date_format');
            $resource->{$action} = date($date_format);
            $message = 'Informace o zdroji: <i>'.$resource->title.'</i> byla uložena';
            $this->session->set_flash('message', $message);
            $resource->save();
            url::redirect('catalogue');
        } else
        {
            $this->session->set_flash('message', 'Nesprávný parametr');
        }
    }
}
?>