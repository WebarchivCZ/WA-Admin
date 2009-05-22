<?php
// TODO zobrazovat hodnoceni jiz ohodnocenych zdroju (vsemi aktivnimi uzivateli)
class Rate_Controller extends Template_Controller
{

    protected $title = 'Hodnocení zdrojů';

    public function index()
    {
        $view =	new View('rate');

        $id_array = $this->find_resources(RS_NEW);
        $resources_new = ($id_array != FALSE) ? ORM::factory('resource')->in('id', $id_array)->find_all() : FALSE;

        $id_array = $this->find_resources(RS_RE_EVALUATE);
        $resources_reevaluate = ($id_array != FALSE) ? ORM::factory('resource')->in('id', $id_array)->find_all() : FALSE;

        $id_array = $this->find_resources(RS_NEW, true);
        $resources_rated_new = ($id_array != FALSE) ? ORM::factory('resource')->in('id', $id_array)->find_all() : FALSE;

        $id_array = $this->find_resources(RS_RE_EVALUATE, true);
        $resources_rated_reevaluate = ($id_array != FALSE) ? ORM::factory('resource')->in('id', $id_array)->find_all() : FALSE;

        $view->resources_new = $resources_new;
        $view->resources_reevaluate = $resources_reevaluate;

        $view->rated_resources_new = $resources_rated_new;
        $view->rated_resources_reevaluate = $resources_rated_reevaluate;
        $view->ratings = NULL;
        $this->template->content = $view;
    }

    public function save($status)
    {

        // TODO neukladat hodnoceni znovu, pokud bylo zmacknuto f5 - redirect
        // TODO message ukladat do session

        $view = new View('rate');
        
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
                    $view->message = "Hodnocení bylo úspěšně uloženo";
                }
            }
        }
        $this->template->content = $view;
    }

    private function find_resources($resource_status = RS_NEW, $only_rated = FALSE)
    {
        $db = Database::instance();
        $round = ($resource_status == RS_NEW) ? 1: 2;
        if ($only_rated == TRUE) {
            $sql_query = "SELECT g.resource_id AS id
                            FROM ratings g, curators c, resources r
                            WHERE r.curator_id = {$this->user->id}
                            AND g.resource_id = r.id
                            AND g.curator_id = c.id
                            GROUP BY g.resource_id
                            HAVING count( * ) >= (
                            SELECT count( id )
                            FROM curators
                            WHERE active =1 )
                        ORDER BY g.date ASC
                        ";
        } else {
            $sql_query = "SELECT r.id
                        FROM `resources` r
                        WHERE r.resource_status_id = {$resource_status}
                        AND r.id NOT IN
                        (
                            SELECT r.id
                            FROM resources r, curators c, ratings g
                            WHERE r.id = g.resource_id
                            AND c.id = g.curator_id
                            AND c.id = {$this->user->id}
                            AND g.round = {$round}
                        )
                        ORDER BY date ASC";
        }
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