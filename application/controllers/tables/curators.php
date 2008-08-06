<?php
class Curators_Controller extends Controller {
	public function index()
	{
		$curators = new Curator_Model();
		$curators = $curators->orderby('lastname', 'asc')->limit(10)->find_all();
		
		echo '<ol>';
		
		foreach($curators as $curator) {
			echo '<li>' . $curator->firstname.' '.$curator->lastname . '</li>'; 
		}
		echo '</ol>';
		
	}
 
	public function insert()
	{
		$form = new Forge('curator/insert', 'Add curator', 'POST', array('id' => 'curator_form'));
		$form->input('firstname')->label(true);
		$form->input('lastname')->label(true);
		$form->input('email')->label(true);
		$form->submit('submit');
		
		if ($form->validate()) {
			$curator = new Curator_Model();
			$curator->firstname = $form->firstname->value;
			$curator->lastname = $form->lastname->value;
			$curator->email = $form->email->value;
			if ($curator->save()) {
				echo "saved";
			}
		} else {
			echo $form->render();
		}
	}
	public function view($id = 1) 
	{
		$curator = new Curator_Model($id);
		if ($curator->id = '') {
			Event::run('system 404');
		}
		echo '<pre>'.print_r($curator, true).'</pre>';
	}
	
	public function find($firstname = '')
	{
		$curator = new Curator_Model();
		$curator = $curator->find_by_firstname($firstname);
		if ($curator->id = '') {
			Event::run('system 404');
		}
		echo '<pre>'.print_r($curator, true).'</pre>';
	}
	
}
?>