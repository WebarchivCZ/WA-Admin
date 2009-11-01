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
            'rating_result'=>Rating_Model::get_final_rating('ANO')))
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