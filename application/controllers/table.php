<?php
abstract class Table_Controller extends Template_Controller
{
    protected $table;
    protected $title;
    protected $model;
    protected $view = 'table';
    protected $columns_ignored = array();

    protected $view_record_url;

    protected $record = NULL;
    protected $header = 'Záznam';

    public function __construct()
    {
        parent::__construct();
        $this->model = inflector::singular($this->table);
        if (!isset($this->view_record_url)) {
            $this->view_record_url = "tables/{$this->table}/view";
        }
        $this->template->title = Kohana::lang('tables.' . $this->title);
        $search_url = url::site('tables/' . $this->table . '/search/');
        $this->template->set_global('search_url', $search_url);
        $this->template->set_global('table', $this->table);
    }

    public function index()
    {
        $this->template->content = $this->show_items_view();
        $this->template->title = Kohana::lang('tables.' . $this->title) . " | " . Kohana::lang('tables.index');
    }

    protected function show_items_view($items = null)
    {
        $per_page = $this->input->get('limit', 40);
        $page_num = $this->input->get('page', 1);
        $offset = ($page_num - 1) * $per_page;

        $this->session->set('ref_page', $page_num);

        $model = ORM::factory($this->model);
        if (is_null($items)) {
            $items = $model->table_view($per_page, $offset);
        }
        $count = $model->count_table_view();
        $pages = Pagination::dropdown($count, $per_page);

        $pages_inline = Pagination::inline($count, $per_page);

        $view = View::factory($this->view);
        $view->title = $this->title;
        $view->headers = $model->headers;
        $view->columns = $model->table_columns();
        $view->items = $items;
        $view->pages = $pages . $pages_inline;
        return $view;

    }

    public function view($id = FALSE)
    {
        $this->template->title = 'Zobrazení záznamu';
        $this->view = 'tables/record_view';
        if (is_null($this->record)) {
            if (isset($this->columns_order)) {
                $record = ORM::factory($this->model)->where('id', $id)->find();
            } else {
                $record = ORM::factory($this->model, $id);
            }

            $record_values = $record->as_array();
        }

        $values = array();
        foreach ($record_values as $key => $value) {
            if ($record->__isset($key) and  !in_array($key, $this->columns_ignored)) {
                // TODO elegantnejsi vypisovani cizich klicu
                if ($record->is_related(str_replace('_id', '', $key))) {
                    $key = str_replace('_id', '', $key);
                }
                $values [$key] = $record->{$key};
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
        if ($id) {
            $this->record = ORM::factory($this->model, $id);
        }
        $form = Formo::factory()->orm($this->model, $id)->add('submit', 'Upravit')->remove($this->columns_ignored)->label_filter('display::translate_orm')->label_filter('ucfirst');
        $view = new View('tables/record_edit');
        $view->bind('header', $this->header);
        $view->form = $form->get();
        $this->template->content = $view;
        if ($form->validate()) {
            $form->save();
            message::set_flash('Záznam byl úspěšně změněn');
            $this->redirect('view');
        }
    }

    public function add($values = NULL)
    {
        $form = Formo::factory()->orm($this->model)
            ->label_filter('display::translate_orm')
            ->label_filter('ucfirst')
            ->add('submit', 'Vlozit')
            ->remove($this->columns_ignored);

        if (!is_null($values)) {
            foreach ($values as $column => $value) {
                $form->{$column}->value = $value;
            }
        }
        $view = new View('tables/record_add');
        $view->form = $form->get();
        $view->bind('header', $this->header);
        $this->template->content = $view;
        if ($form->validate()) {
            $form->save();
            $this->record = $form->get_model($this->model);

            message::set_flash('Záznam úspěšně přidán');
            $this->redirect('view');
        }
    }

    public function delete($id = FALSE)
    {
        if (Auth::instance()->logged_in('admin')) {
            if ($id) {
                $this->record = ORM::factory($this->model, $id);
            }
            if (isset($_POST ['sent'])) {
                if (isset($_POST ['confirm'])) {
                    $this->record->delete_record();
                    message::set_flash('Záznam byl úspěšně smazán.');
                    url::redirect(url::site('tables/' . $this->table));
                } else {
                    $this->redirect();
                }
            }
            $view = new View('tables/record_delete');
            $view->bind('header', $this->header);

            $this->template->content = $view;
        } else {
            message::set_flash('Nemáte právo mazání.');
            url::redirect(url::site("tables/{$this->table}"));
        }
    }

    /**
     *
     * @param array $conditions podminky za WHERE
     */
    public function search($conditions = NULL)
    {
        $search_string = $this->input->get('search_string');
        if (!is_null($conditions)) {
            $search_string = $conditions;
        }
        $per_page = $this->input->get('limit', 20);
        $page_num = $this->input->get('page', 1);
        $offset = ($page_num - 1) * $per_page;

        $count = 0;
        $model = ORM::factory($this->model);
        $items = $model->search($search_string, $count, $per_page, $offset);
        $pages_inline = Pagination::inline($count, $per_page);

        // create and display the view
        $view = new View($this->view);
        $view->title = $this->title;
        $view->headers = $model->headers;
        $view->columns = $model->table_columns();
        $view->items = $items;
        $view->pages = $pages_inline;

        $this->template->content = $view;
        $this->template->title = Kohana::lang('tables.' . $this->title) . " | " . Kohana::lang('tables.index');
    }

    protected function redirect($action = 'view')
    {
        if ($action == 'view' or $action = 'edit') {
            url::redirect("/tables/{$this->table}/{$action}/{$this->record->id}");
        } elseif ($action == 'list') {
            url::redirect("/tables/{$this->table}/");
        }
    }

}

?>