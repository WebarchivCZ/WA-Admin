<?php
class Conspectus_Table_Controller extends Table_Controller {
	protected $title = 'conspectus';
	protected $table = 'resources';
	protected $view = 'tables/table_conspectus';

	public function __construct()
	{
		parent::__construct();
		$this->session->set_flash('request_page', url::current(TRUE));
		$this->template->set_global('search_url', url::site('tables/conspectus_table/search/'));
		$this->insert_filter_form();
	}

	public function index()
	{
		parent::index();
		$this->insert_filter_form();
	}

	// FIXME Metodu kompletne refaktorovat a prepsat
	public function filter()
	{
		$filter_on = $this->input->post('filter', $this->session->get_once('filter'));
		if ($filter_on == TRUE)
		{
			$view = View::factory($this->view);

			$selected_conspectus = $this->input->post('conspectus', $this->session->get_once('conspectus'));
			$selected_conspectus_subcategory = $this->input->post('conspectus_subcategory', $this->session->get_once('conspectus_subcategory'));
			$form = Conspectus_Controller::generate_filter_form($selected_conspectus);
			$form->conspectus->value = $selected_conspectus;
			$form->conspectus_subcategory->value = $selected_conspectus_subcategory;
			$view->form = $form->get(1);

			$this->session->set('filter', TRUE);
			$this->session->set('conspectus', $selected_conspectus);
			$this->session->set('conspectus_subcategory', $selected_conspectus_subcategory);

			$per_page = $this->input->get('limit', 40);
			$page_num = $this->input->get('page', 1);
			$offset = ($page_num - 1) * $per_page;

			$this->session->set('ref_page', $page_num);

			$model = ORM::factory($this->model);

			$items = Resource_Model::get_by_conspectus($selected_conspectus, $selected_conspectus_subcategory, $per_page, $offset);
			//FIXME pocitani zdroju daneho konspektu
			$count = Resource_Model::get_by_conspectus($selected_conspectus, $selected_conspectus_subcategory, 10000, 0)->count();

			$pages = Pagination::dropdown($count, $per_page);

			$pages_inline = Pagination::inline($count, $per_page);

			$view->title = $this->title;
			$view->headers = $model->headers;
			$view->columns = $model->table_columns();
			$view->items = $items;
			$view->pages = $pages.$pages_inline;
			$this->template->content = $view;
		} else
		{
			url::redirect('tables/conspectus_table');
		}
	}

	public function search()
	{
		parent::search();
		$this->insert_filter_form();
	}

	private function insert_filter_form()
	{
		$form = Conspectus_Controller::generate_filter_form();
		$view = $this->template->content;
		$view->form = $form->get(1);
	}

}

?>