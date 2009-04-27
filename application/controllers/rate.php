<?php
class Rate_Controller extends Template_Controller {
	
	protected $title = 'Hodnocení zdrojů';
	
	public function index() {
		$view =	new View('rate');
		$resources = ORM::factory('resource')
									->in('resource_status_id', array(1, 3))
									->find_all();
									
		$ratings = array();
		foreach ($resources as $resource) {
			$rating = ORM::factory('rating')
									->where(array('curator_id'=>$this->user->id, 'resource_id'=>$resource->id))
									->orderby('round', 'DESC')
									->find();
			if ($rating->id == 0) {
				$rating = NULL;
				$this->debug($rating);
			} else {
				$rating = $rating->rating;
			}
			$ratings[$resource->id] = $rating;
		}
		$view->resources = $resources;
		$view->ratings = $ratings;
		$this->template->content = $view; 
	}
	
	public function save() {
				
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
	}
}
?>