<?php
class Home_Controller extends Template_Controller {
	public function index() {		
		$this->template->title = 'Home';
		$content = new View('home');
		$content->info = 'Mate 2 zdroju cekajici na vase hodnoceni >> <a href="">Pokracovat</a>';
		$content->stats = Statistic_Model::factory()->getBasic();
		
		$this->template->content = $content;
	}
	
}
?>