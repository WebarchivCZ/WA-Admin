<?php
/**
 * TODO oslovene zdroje se objevi az po mesici, kdy byly naposledy osloveny
 * TODO zobrazit neoslovene zdroje
 * TODO zobrazuji se pouze zdroje, ktere spravuje kurator
 * TODO seradit zdroje podle poctu osloveni a pak podle data (nejdrive neoslovene)
 * TODO odstranit ikony editace zdroju (vsude), vymenit za prokliky
 */

class Addressing_Controller extends Template_Controller {

    protected $title = 'Oslovování';

    public function index() {

        $resources = ORM::factory('resource')
            ->in('resource_status_id', array(2,4))
            ->where('curator_id', $this->user->id)
            ->find_all();

        $view = new View('addressing');
        $view->resources = $resources;

        $this->template->content = $view;
    }
}
?>