<?php
class Addressing_Controller extends Template_Controller {
    protected $title = 'Oslovování';
    protected $page_header = 'Oslovování vydavatelů';

    public function index() {
        $id_array = $this->get_to_addressing();

        if (count ($id_array) > 0) {
            $resources = ORM::factory('resource')->in('id', $id_array)->orderby('date', 'ASC')->find_all();
        } else {
            $resources = NULL;
        }

        $view = new View('addressing');
        $view->resources = $resources;

        $this->template->content = $view;
    }

    public function send($resource_id, $correspondence_type_id) {
        $date_format = Kohana::config('wadmin.date_format');
     
        $correspondence = ORM::factory('correspondence');
        $correspondence->resource_id = $resource_id;
        $correspondence->correspondence_type_id = $correspondence_type_id;
        $correspondence->date = date($date_format);
        $correspondence->save();

        $resource = ORM::factory('resource', $resource_id);
        $resource->resource_status_id = RS_CONTACTED;
        $resource->save();

        url::redirect('addressing');
    }

    /**
     * Method select resources, which has to be addressed by actual curator.
     * The condition to selectin is:
     * it isn't contacted yet or
     * it the last correspondence was sent more than month ago and the status is contacted
     * @return array ids of the resources to addressing
     */
    protected function get_to_addressing () {
        $curator_id = $this->user->id;

        $rs_approved_status = RS_APPROVED_WA;
        $rs_contacted_status = RS_CONTACTED;

        $sql = "(
	                SELECT r.id, r.date AS created, '', 0 as count
	                FROM `resources` r
	                WHERE resource_status_id = {$rs_approved_status}
	                AND r.curator_id = {$curator_id}
                )
                UNION (

	                SELECT r.id, r.date AS created, date_add( MAX( c.date ) , INTERVAL 1
	                MONTH ) AS `new_one`, count(c.resource_id) as count
	                FROM `resources` r, correspondence c
	                WHERE resource_status_id = {$rs_contacted_status}
	                AND c.resource_id = r.id
	                AND r.curator_id = {$curator_id}
	                GROUP BY c.resource_id
	                HAVING new_one <= NOW( )
                )
                ORDER BY count";


        return sql::get_id_array($sql);
    }

    public function count_to_addressing () {
        $count = count ($this->get_to_addressing());
        return $count;
    }
}
?>