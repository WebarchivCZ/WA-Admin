<?php
/**
 * TODO oslovene zdroje se objevi az po mesici, kdy byly naposledy osloveny
 * TODO seradit zdroje podle poctu osloveni a pak podle data (nejdrive neoslovene)
 */

class Addressing_Controller extends Template_Controller {

    protected $title = 'Oslovování';
    protected $page_header = 'Oslovování vydavatelů';

    public function index() {

        $resources = ORM::factory('resource')
            ->in('resource_status_id', array(2, 8))
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
        $date_format = Kohana::config('wadmin.date_format');
        $correspondence->date = date($date_format);
        $correspondence->save();
        $resource = ORM::factory('resource', $resource_id);
        $resource->resource_status_id = RS_CONTACTED;
        $resource->save();
        url::redirect('addressing');
    }
}
?>