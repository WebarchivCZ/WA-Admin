<?php
abstract class Table_Controller extends Template_Controller
{
	protected $table;
	protected $title;

	public function index()
	{			
		
		$per_page = $this->input->get('limit', 20);
		$page_num = $this->input->get('page', 1);
		$offset   = ($page_num - 1) * $per_page;
		 
		$model = ORM::factory($this->table);
		$pages = Pagination::factory(array
		(
		    'style' => 'dropdown',
		    'items_per_page' => $per_page,
		    'query_string' => 'page',
		    'total_items' => $model->count_all(),
		
		));
		
		$pages_inline = Pagination::factory(array
		(
		    'style' => 'digg',
		    'items_per_page' => $per_page,
		    'query_string' => 'page',
		    'total_items' => $model->count_all(),
		
		));
		
		$view = new View('table');
		$view->title = $this->title;
		$view->headers = $model->headers;
		$view->columns = $model->table_columns();
		$view->items = $model->find_all($per_page,$offset);
		$view->pages = $pages . $pages_inline;
		$this->template->content = $view;
		$this->template->title = Kohana::lang('tables.'.$this->title) . " | " . Kohana::lang('tables.index');
	}

	public function view($id = false)
	{
		
	}

	public function add()
	{}

	public function delete($id = false)
	{
		
	}

	public function find()
	{}
	
	public function search($search_string)
	{
		$per_page = $this->input->get('limit', 20);
		$page_num = $this->input->get('page', 1);
		$offset   = ($page_num - 1) * $per_page;
		 
		$model = ORM::factory($this->table);
		$pages = Pagination::factory(array
		(
		    'style' => 'dropdown',
		    'items_per_page' => $per_page,
		    'query_string' => 'page',
		    'total_items' => $model->count_all(),
		
		));
		
		$pages_inline = Pagination::factory(array
		(
		    'style' => 'digg',
		    'items_per_page' => $per_page,
		    'query_string' => 'page',
		    'total_items' => $model->count_all(),
		
		));
		
		$view = new View('table');
		$view->title = $this->title;
		$view->headers = $model->headers;
		$view->columns = $model->table_columns();
		$view->items = $model->find_all($per_page,$offset)->where($model->get_default(), $search_string);
		$view->pages = $pages . $pages_inline;
		$this->template->content = $view;
		$this->template->title = Kohana::lang('tables.'.$this->title) . " | " . Kohana::lang('tables.index');
	}
}
?>