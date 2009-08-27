<?php
/**
 * DONE prokliky z jednotlivych radku na prohlizeni konkretnich zaznamu
 */
abstract class Table_Controller extends Template_Controller
{
    protected $table;
    protected $title;
    protected $model;
    protected $view = 'table';
    protected $columns_ignored = array();
    protected $columns_order = array();
    protected $record = NULL;
    protected $header = 'Záznam';

    public function __construct()
    {
        $this->model = inflector::singular($this->table);
        parent::__construct();
        $this->template->title = Kohana::lang('tables.'.$this->title);
    }

    public function index()
    {
        $per_page = $this->input->get('limit', 20);
        $page_num = $this->input->get('page', 1);
        $offset   = ($page_num - 1) * $per_page;

        $model = ORM::factory($this->model);
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

        $view = View::factory($this->view);
        $view->title = $this->title;
        $view->headers = $model->headers;
        $view->columns = $model->table_columns();
        $view->items = $model->find_all($per_page,$offset);
        $view->pages = $pages . $pages_inline;
        $this->template->content = $view;
        $this->template->title = Kohana::lang('tables.'.$this->title) . " | " . Kohana::lang('tables.index');
    }

    public function view($id = FALSE)
    {
        $this->template->title = 'Zobrazení záznamu';
        $this->view = 'tables/record_view';
        if (is_null($this->record))
        {
            $record = ORM::factory($this->model, $id);
        }
        $record_values = $record->as_array();
        $values = array();
        foreach ($record_values as $key => $value)
        {
            if ($record->__isset($key) AND ! in_array($key, $this->columns_ignored))
            {
            // TODO elegantnejsi vypisovani cizich klicu
                if ($record->is_related(str_replace('_id', '', $key)))
                {
                    $key = str_replace('_id', '',$key);
                }
                $values[$key] = $record->{$key};

            }
        }
        $this->record = $record;
        $url = url::site("/tables/{$this->table}/edit/{$id}");
        $view = View::factory($this->view);
        $view->bind('values', $values);
        $view->bind('header', $this->header);
        $view->set('edit_url', $url);
        $this->template->content = $view;
    }

    public function edit($id = FALSE)
    {
        $form = Formo::factory()->orm($this->model, $id)
            ->add('submit', 'Upravit')
            ->remove($this->columns_ignored)
            ->label_filter('display::translate_orm')
            ->label_filter('ucfirst');
        $view = new View('tables/record_edit');
        $view->bind('header', $this->header);
        $view->type = 'edit';
        $view->form = $form->get();
        $this->template->content = $view;
        if ($form->validate())
        {
            $form->save();
            $this->session->set_flash('message', 'Záznam byl úspěšně změněn');
            $url = 'tables/'.$this->uri->segment(2).'/view/'.$id;
            url::redirect($url);
        }
    }

    public function add($values = NULL)
    {
        $form = Formo::factory()->orm($this->model)
            ->label_filter('display::translate_orm')
            ->label_filter('ucfirst')
            ->add('submit', 'Vložit')
            ->remove($this->columns_ignored);

        if (! is_null($values))
        {
            foreach ($values as $column => $value)
            {
                $form->{$column}->value = $value;
            }
        }
        $view = new View('tables/record_add');
        $view->form = $form->get();
        $view->bind('header', $this->header);
        $this->template->content = $view;
        if ($form->validate())
        {
            $form->save();
            $this->record = $form->get_model($this->model);

            $this->session->set_flash('message', 'Záznam úspěšně přidán');
            url::redirect('/tables/'.$this->table.'/view/'.$this->record->id);
        }
    }

    public function delete($id = FALSE)
    {
        $form = Formo::factory()->orm($this->model, $id)->add('submit', 'SMAZAT');
        // TODO vypisovani labelu
        $view = new View('edit_table');
        $view->type = 'edit';
        $view->form = $form->get();
        $this->template->content = $view;
        if ($form->validate())
        {
            ORM::factory($this->model)->delete($id);
            $this->session->set_flash('message', 'Záznam úspěšně smazán');
            url::redirect(url::site('/tables/'.$this->table));
        }

    }

    /**
     *
     * @param array $conditions podminky za WHERE
     */
    public function search($conditions = NULL)
    {
        $search_string = $this->input->post('search_string');

        $per_page = $this->input->get('limit', 20);
        $page_num = $this->input->get('page', 1);
        $offset   = ($page_num - 1) * $per_page;

        $model = ORM::factory($this->model);
        if (! is_null($conditions))
        {
            $result = $model->like($conditions)->find_all();
        } else
        {
            $result = $model->like($model->__get('primary_val'), $search_string)
                ->find_all($per_page,$offset);
        }
        $pages = Pagination::factory(array
            (
            'style' => 'dropdown',
            'items_per_page' => $per_page,
            'query_string' => 'page',
            'total_items' => $result->count(),

        ));

        $pages_inline = Pagination::factory(array
            (
            'style' => 'digg',
            'items_per_page' => $per_page,
            'query_string' => 'page',
            'total_items' => $result->count(),

        ));

        $view = new View('table');
        $view->title = $this->title;
        $view->headers = $model->headers;
        $view->columns = $model->table_columns();
        // TODO predefinovat hledani - prohledavane sloupce definovat v modelu
        $view->items = $result;
        $view->pages = $pages . $pages_inline;
        $this->template->content = $view;
        $this->template->title = Kohana::lang('tables.'.$this->title) . " | " . Kohana::lang('tables.index');
    }

    //TODO dokumentace, overit funkcnost
    protected function get_record ($id = NULL)
    {
        $record = ORM::factory($this->model);
        if (! $record->__isset('id') OR ! is_null($id))
        {
            $this->session->set_flash('message', 'Záznam neexistuje');
            url::redirect("tables/{$this->table}");
        } else
        {
            return $record;
        }
    }
}
?>