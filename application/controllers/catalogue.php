<?php
/**
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

        $resources = $this->get_to_catalogue();
        $view->resources = $resources;
    }

    protected function get_to_catalogue()
    {
        $resources = ORM::factory('resource')
            ->where(array('curator_id'=>$this->user->id,
            'catalogued'=> NULL,
            'resource_status_id'=>RS_APPROVED_PUB))
            ->find_all();
        return $resources;
    }

    /**
     * Ulozi informaci o provedene akci u daneho zdroje. Povolene akce - katalogizace
     * @param <type> $action provedena akce (odpovida sloupci v tabulce), povoleno - catalogued
     * @param <type> $resource_id id zdroje, ktereho se uprava tyka
     */
    public function save ($action, $resource_id)
    {
        $allowed_actions = array('catalogued');
        $resource = ORM::factory('resource', $resource_id);
        if (isset($_POST['aleph_id']) and $_POST['aleph_id'] != '') {
                $resource->aleph_id = $_POST['aleph_id'];
            
        if (in_array($action, $allowed_actions))
        {   
            $date_format = Kohana::config('wadmin.date_format');
            $resource->{$action} = date($date_format);
            $message = 'Informace o zdroji: <i>'.$resource->title.'</i> byla uložena';
            message::set_flash($message);
            $resource->save();
        } else
        {
            message::set_flash('Nesprávný parametr');
        }
        } else {
            message::set_flash('Není vyplněno Aleph ID.');
        }
        url::redirect('catalogue');
    }
}
?>