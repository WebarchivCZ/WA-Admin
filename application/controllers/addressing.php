<?php
/**
 * TODO oslovene zdroje se objevi az po mesici, kdy byly naposledy osloveny
 * TODO seradit zdroje podle poctu osloveni a pak podle data (nejdrive neoslovene)
 */

class Addressing_Controller extends Template_Controller
{

    protected $title = 'Oslovování';
    protected $page_header = 'Oslovování vydavatelů';

    public function index()
    {

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


        $result = Database::instance()->query($sql);
        $id_array = array();

        foreach($result->result_array(FALSE) as $row)
        {
            array_push($id_array, $row['id']);
        }
        if (count ($id_array) > 0)
        {
            $resources = ORM::factory('resource')->in('id', $id_array)->orderby('date', 'ASC')->find_all();
        } else {
            $resources = NULL;
        }

        $view = new View('addressing');
        $view->resources = $resources;

        $this->template->content = $view;
    }

    public function send($resource_id, $correspondence_type_id)
    {
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