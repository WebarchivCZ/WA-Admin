<?php
class Rate_Controller extends Template_Controller {

    protected $title = 'Hodnocení zdrojů';

    public function index() {
        $view =	new View('rate');

        $status_array = array('resources_new' => RS_NEW, 'resources_reevaluate' => RS_RE_EVALUATE);
        
        foreach ($status_array as $key => $status) {
        	$id_array = $this->find_resources($status);
        	$resources = ORM::factory('resource')
                ->in('id', $id_array)
                ->orderby('date', 'ASC')
                ->find_all();
            $view->{$key} = $resources;
             
            $id_array = $this->find_resources($status, TRUE);
        	$resources = ORM::factory('resource')
                ->in('id', $id_array)
                ->orderby('date', 'ASC')
                ->find_all();
            $view->{"rated_".$key} = $resources; 
        }

        $this->template->content = $view;
    }

    public function save($status) {
        $ratings = $this->input->post('rating');
        $comments = $this->input->post('comments');

        foreach ($ratings as $resource_id => $rating) {
            if ($rating != 'NULL') {
            	$resource = ORM::factory('resource', $resource_id);
            	
                $o_rating = ORM::factory('rating');
                $o_rating->add_curator($this->user);
                $o_rating->resource_id = $resource->id;
                if ($rating == 4) {
                    $o_rating->tech_problems = TRUE;
                }
                if ($resource->rating_last_round == '') {
                    $round = 1;
                } else {
                    $round = $resource->rating_last_round + 1;
                }
                $o_rating->round = $round;
                $o_rating->date = date(Kohana::config('wadmin.date_format'));
                $o_rating->rating = $rating;

                if ($comments[$resource_id] != '') {
                    $o_rating->comments = $comments[$resource_id];
                }
                $o_rating->save();
                if ($o_rating->saved) {
                    message::set_flash('Hodnocení bylo úspěšně uloženo.');
                }
            }
        }
        url::redirect('rate');
    }

    public function count_to_rate($resource_status = RS_NEW) {
        $resources = $this->find_resources($resource_status, FALSE);
        if (is_array($resources)) {
            return count($resources);
        } else {
            return 0;
        }
    }

    public function count_rated($resource_status = RS_NEW) {
        return count($this->find_resources($resource_status, TRUE));
    }


    protected function find_resources($resource_status = RS_NEW, $only_rated = FALSE) {
        $db = Database::instance();
        
        $round = ($resource_status == RS_NEW) ? ' = 1': ' >= 2';
        $reevaluate_constraint = '';

        if ($resource_status == RS_RE_EVALUATE) {
            $reevaluate_constraint = 'AND reevaluate_date <= CURDATE()';
        }
        if ($only_rated == TRUE) {
            $sql_query = "SELECT g.resource_id AS id
                            FROM ratings g, curators c, resources r
                            WHERE r.curator_id = {$this->user->id}
                            AND g.resource_id = r.id
                            AND g.curator_id = c.id
                            AND g.round {$round}
                            AND r.resource_status_id = {$resource_status}
                    {$reevaluate_constraint}
                            GROUP BY g.resource_id
                            HAVING count( * ) >= 1
                        ORDER BY count(g.resource_id) ASC
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
                            AND g.round > r.rating_last_round
                        )
                    {$reevaluate_constraint}
                        ORDER BY field(suggested_by_id, 2, 1, 3, 4)";
        }
        $query = $db->query($sql_query);

// TODO refaktorovat - stejna metoda v addressing
        $id_array = array();
        foreach($query->result_array(FALSE) as $row) {
            array_push($id_array, $row['id']);
        }
        $result = count($id_array) != 0? $id_array : 0;
        return $result;
    }
}
?>