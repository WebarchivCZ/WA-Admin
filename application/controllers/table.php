<?php
abstract class Table_Controller extends Template_Controller
{
	protected $table;
	protected $title;

	public function index()
	{
		$model = ORM::factory($this->table);
		$view = new View('table');
		$view->title = $this->title;
		$view->headers = $model->headers;
		$view->columns = $model->table_columns();
		$view->items = $model->find_all();
		$this->template->content = $view;
		$this->template->title = Kohana::lang('tables.'.$this->title) . " | " . Kohana::lang('tables.index');
	}

	public function view($id = false)
	{}

	public function add()
	{}

	public function delete($id = false)
	{
		$form = new Formation();
		$form->add_element('submit', 'Delete');
		if ($form->validate())
		{
			ORM::factory($this->table, (int) $id)->delete();
			Flash::redirect('tables/' . $this->table, 'Deleted', 1);
		}
		else
		{
			$this->view->form = $form;
		}
	}

	public function find()
	{}
}
?>