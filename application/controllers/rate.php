<?php
class Rate_Controller extends Template_Controller
{

    protected $title = 'Hodnocení zdrojů';

    public function index()
    {
        $view =	new View('rate');
        $db = Database::instance();

        $id_array = $this->find_resources(RS_NEW);
        $resources_new = ($id_array != FALSE) ? ORM::factory('resource')->in('id', $id_array)->find_all() : FALSE;

        $id_array = $this->find_resources(RS_RE_EVALUATE);
        $resources_reevaluate = ($id_array != FALSE) ? ORM::factory('resource')->in('id', $id_array)->find_all() : FALSE;

        $view->resources_new = $resources_new;
        $view->resources_reevaluate = $resources_reevaluate;
        $view->ratings = NULL;
        $this->template->content = $view;
    }

    public function save($status)
    {

        $ratings = $this->input->post('rating');

        foreach ($ratings as $resource_id => $rating)
        {
            if ($rating != 'NULL')
            {
                $o_rating = ORM::factory('rating');
                $o_rating->add_curator($this->user);
                $o_rating->resource_id = $resource_id;
                if ($rating == 4)
                {
                    $o_rating->tech_problems = TRUE;
                }
                if ($status == RS_NEW)
                {
                    $round = 1;
                } else
                {
                    // TODO zmenit kolo hodnoceni pro zdroje k prehodnoceni
                    $round = 2;
//                    $last_round = ORM::factory('rating')
//                        ->select('MAX(round) as last_round')
//                        ->where(array('curator_id'=>$this->user->id, 'resource_id'=>$resource_id))
//                        ->find();
//                    $round = $last_round->last_round + 1;
                }
                $o_rating->round = $round;
                $o_rating->date = date('Y-m-d H:i:s');
                $o_rating->rating = $rating;
                $o_rating->save();
                if ($o_rating->saved)
                {
                //TODO zobrazovat informace
                    $message = "Hodnocení bylo uloženo";
                }
            }
        }

        $view = new View('rate');
        $this->template->content = $view;
    }

    private function find_resources($resource_status = RS_NEW)
    {
        $db = Database::instance();
        $round = ($resource_status == RS_NEW) ? 1: 2;
        $sql_query = "SELECT r.id
                    FROM `resources` r
                    WHERE r.id NOT IN
                    (
                        SELECT r.id
                        FROM resources r, curators c, ratings g
                        WHERE r.id = g.resource_id
                        AND c.id = g.curator_id
                        AND c.id = {$this->user->id}
                        AND g.round = {$round}
                    )

                    AND r.resource_status_id = {$resource_status}
                    ORDER BY date ASC";
        $query = $db->query($sql_query);

        $id_array = array();
        foreach($query->result_array(FALSE) as $row)
        {
            array_push($id_array, $row['id']);
        }
        $result = count($id_array) != 0? $id_array : FALSE;
        return $result;
    }
}
?>