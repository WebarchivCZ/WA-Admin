<?php
class Conspectus_Controller extends Template_Controller {
	protected $title = 'Konspekt - významné zdroje';
	protected $page_title = 'Konspekt';

	public function index()
	{
		$content = View::factory('conspectus');

		$nominations = Nomination_Model::get_new($this->user->id);

		$content->form = self::generate_filter_form()->get(1);
		$content->nominations = $nominations;
		$this->template->content = $content;
	}

	public function filter()
	{
		$filter = NULL;
		if (isset($_POST ['filter']) and $_POST ['filter'] == TRUE and $_POST ['conspectus'] != '')
		{
			$selected_conspectus = $_POST ['conspectus'];
			$selected_conspectus_subcategory = $_POST ['conspectus_subcategory'];
			$form = self::generate_filter_form($selected_conspectus);
			$form->conspectus->value = $selected_conspectus;
			$form->conspectus_subcategory->value = $selected_conspectus_subcategory;
			$filter ['conspectus'] = $selected_conspectus;
			$filter ['conspectus_subcategory'] = $selected_conspectus_subcategory;
		} else
		{
			$form = self::generate_filter_form();
		}
		$resources = Resource_Model::get_important(NULL, $filter);

		$content = View::factory('conspectus');
		$content->form = $form->get(1);
		$content->resources = $resources;
		$this->template->content = $content;
	}

	public function accept($resource_id)
	{
		$this->resolve_nomination($resource_id, TRUE);
	}

	public function reject($resource_id)
	{
		$this->resolve_nomination($resource_id, FALSE);
	}

	protected function resolve_nomination($resource_id, $accepted)
	{
		$resource = ORM::factory('resource')->where('resources.id', $resource_id)->with('nomination')->find();
		if ($this->user->id != $resource->curator_id)
		{
			message::set_flash('Nemáte oprávnění na vyhodnocení nominace.');
			url::redirect('conspectus');
		}

		$nomination = $resource->nomination;
		$nomination->date_resolved = date_helper::mysql_date_now();
		$nomination->accepted = $accepted;
		$nomination->save();

		$resource->important = $accepted;
		$resource->save();

		if ($nomination->saved)
		{
			message::set_flash('Rozhodnutí bylo úspěšně uloženo');
		}

		$page = $this->session->get_once('request_page', 'conspectus');
		url::redirect($page);
	}

	public static function generate_filter_form($selected_conspectus = 1, $selected_conspectus_subcategory = NULL)
	{
		$conspectus = ORM::factory('conspectus')->select_list('id', 'title');
		$form = Formo::factory('conspectus_select');
		$form->add_select('conspectus', $conspectus, 'style=width:250px;')->id('category_select')->blank(TRUE);
		$form->add_select('conspectus_subcategory', '', 'style=width:270px;')->id('subcategory_select')->blank(TRUE);

		$subcategories = ORM::factory('conspectus_subcategory')->where('conspectus_id', $selected_conspectus)->select_list('id', 'title');

		$form->conspectus_subcategory->values = $subcategories;

		return $form;
	}
}

?>