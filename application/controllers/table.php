<?php
class Table_Controller extends Template_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->template->title = "Tabulka";
	}

	public function index()
	{
		$this->template->content = View::factory('select_table');		
	}

	public function view($model)
	{
		if (class_exists($model."_Model"))
		{
			$m = ORM::factory($model);

			if ($m instanceof Viewable_Table)
			{
				$view = new View('table');
				$view->model = $model;
				
				$headers = $m->table_headers();
				
				$view->headers = $headers;
				
				//$m->select($headers);
				
				$view->items = $m->find_all();	
				$this->template->content = $view;
				
			}
			else
			{
				$this->template->content = "Tabulku nelze zobrazit";
			}
		}
		else {
			$this->template->content = "Nejde o model";
		}


	}

	public function add()
	{

	}
	
	public function search($where, $what) {
		
	}

}
?>