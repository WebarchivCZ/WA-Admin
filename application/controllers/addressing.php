<?php
/**
 * TODO oslovene zdroje se objevi az po mesici, kdy byly naposledy osloveny
 * DONE zobrazit neoslovene zdroje
 * DONE zobrazuji se pouze zdroje, ktere spravuje kurator
 * TODO seradit zdroje podle poctu osloveni a pak podle data (nejdrive neoslovene)
 * DONE odstranit ikony editace zdroju, vymenit za prokliky
 * TODO send() - zaslat korespondenci - vytvorit objekt correspospondence a ulozit do db
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

    public function send($resource_id, $correspondence_type_id) {
        $correspondence = ORM::factory('correspondence');
        $correspondence->resource_id = $resource_id;
        $correspondence->correspondence_type_id = $correspondence_type_id;
        // TODO format presunout do configu
        $correspondence->date = date('Y-m-d H:m:s');
        $correspondence->save();
        url::redirect('addressing');
    }
}
?>