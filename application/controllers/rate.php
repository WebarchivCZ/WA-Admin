<?php
class Rate_Controller extends Template_Controller {

    protected $title = 'Hodnocení zdrojů';

    public function index() {
        $view =	new View('rate');

        $status_array = array('resources_new' => RS_NEW, 'resources_reevaluate' => RS_RE_EVALUATE);
        
        foreach ($status_array as $key => $status) {
        	$id_array = Rating_Model::find_resources($this->user->id, $status, FALSE);
        	$resources = ORM::factory('resource')
                ->in('id', $id_array)
                ->orderby('date', 'ASC')
                ->find_all();
            $view->{$key} = $resources;
             
            $id_array = Rating_Model::find_resources($this->user->id, $status, TRUE);
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
        $resources = Rating_Model::find_resources($resource_status, FALSE);
        if (is_array($resources)) {
            return count($resources);
        } else {
            return 0;
        }
    }

    public function count_rated($resource_status = RS_NEW) {
        return count(Rating_Model::find_resources($resource_status, TRUE));
    }
}
?>