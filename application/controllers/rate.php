<?php
class Rate_Controller extends Template_Controller {

    protected $title = 'Hodnocení zdrojů';
    
    public function index() {
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

    public function save() {

        //FIXME ulozi se vzdy vsechny hodnoceni, i kdyz nebyly vyplnene

        $curator = $this->user;

        $ratings = $this->input->post('rating');
        foreach ($ratings as $resource_id => $rating) {
            $round = ORM::factory('rating')
                ->select('MAX(round) as last_round')
                ->where(array('curator_id'=>$curator->id, 'resource_id'=>$resource_id))
                ->find();
            $o_rating = ORM::factory('rating');
            $o_rating->add_curator($curator);
            $o_rating->resource_id = $resource_id;

            if (empty($round)) {
                $round = 1;
            } else {
                $round = $round->last_round + 1;
            }
            $o_rating->round = $round;
            $this->debug("zdroj: $resource_id kolo: $round");
            if ($rating == 4) {
                $o_rating->tech_problems = TRUE;
            }
            $o_rating->rating = $rating;
            $o_rating->save();

        }
        $view = new View('rating_save');
        $this->template->content = $view;
        url::redirect('rate');
    }

    private function find_resources($resource_status = RS_NEW) {
        $db = Database::instance();
        
        $sql_query = 'SELECT r.id
                    FROM `resources` r
                    WHERE r.id NOT IN (

                    SELECT r.id
                    FROM resources r, curators c, ratings g
                    WHERE r.id = g.resource_id
                    AND c.id = g.curator_id
                    AND c.id = '.$this->user->id."
                    )

                    AND r.resource_status_id = {$resource_status}
                    ORDER BY date ASC";
        $query = $db->query($sql_query);
        
        $id_array = array();
        foreach($query->result_array(FALSE) as $row) {
            array_push($id_array, $row['id']);
        }
        $result = count($id_array) != 0? $id_array : FALSE;
        return $result;
    }
}
?>