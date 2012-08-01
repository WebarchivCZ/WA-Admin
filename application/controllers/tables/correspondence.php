<?php
class Correspondence_Controller extends Table_Controller {
	protected $table = 'correspondence';
	protected $title = 'Correspondence';
	protected $header = 'Oslovení';
	protected $view = 'tables/table_correspondence';
	protected $view_record_url = '/tables/correspondence/';

	public function edit($id)
	{

		if (isset($_POST['date']) AND $_POST['date'] == '')
		{
			ORM::factory('correspondence', $id)->delete();
			message::set_flash('Korespondence byla úspěšně smazána.');

			$this->redirect();
		}
		parent::edit($id);
	}

	protected function redirect($action = 'view', $url = '')
	{
		$url = $this->view_record_url.'index?page='.$this->session->get('ref_page');
		url::redirect($url);
	}
}

?>