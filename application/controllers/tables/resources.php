<?php
class Resources_Controller extends Table_Controller
{
    protected $table = 'resources';
    protected $title = 'Resources';
    protected $columns_ignored = array('id', 'publisher_id', 'contact_id', 'contract_id');
    protected $columns_order = array('title', 'url', 'creator_id', 'date', 'curator_id',
    'conspectus_id', 'crawl_freq_id', 'resource_status_id',
    'suggested_by_id', 'rating_result', 'aleph_id', 'ISSN',
    'catalogued', 'tech_problems', 'comments');
    protected $header = 'Zdroj';

    public function view($id = FALSE)
    {
        parent::view($id);

        $resource = $this->record;
        /* @var $resource Resource_Model */
        $append_view = View::factory('tables/append_resource');
        $append_view->resource = $resource;
        $append_view->active_curators = ORM::factory('curator')->where('active', 1)->find_all();
        $append_view->ratings = ORM::factory('rating')->where('resource_id', $resource->id)
            ->find_all();
        $append_view->show_final_rating = $resource->is_curated_by($this->user);
        $append_view->user_id = $this->user->id;
        $append_view->seeds = ORM::factory('seed')->where('resource_id', $resource->id)->find_all();

        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }

    public function edit($id = FALSE)
    {
        $resource = ORM::factory('resource')->find($id);

        if ($resource->__isset('id'))
        {
            $form = Formo::factory()->orm('resource', $id)
                ->remove($this->columns_ignored)
                ->add('submit', 'Upravit')
                ->label_filter('display::translate_orm')
                ->label_filter('ucfirst');

            $form->rating_result->type('select');
            $form->rating_result->values(Rating_Model::get_final_array());
            $form->rating_result->value($resource->get_rating_result());
            $form->catalogued->checked(! is_null($resource->catalogued))
                ->title($resource->catalogued);

            $form->_order = array('title', 'url', 'date', 'creator_id', 'curator_id',
                'conspectus_id', 'conspectus_subcategory_id', 'crawl_freq_id',
                'resource_status_id', 'suggested_by_id', 'rating_result', 'reevaluate_date',
                'aleph_id', 'issn', 'catalogued',
                'tech_problems', 'comments', 'upravit');
            
			//vyber podkategorii prislusici dane kategorii
          	$form->conspectus_subcategory_id->values = ORM::factory('conspectus_subcategory')
          												->where('conspectus_id', $resource->conspectus_id)
          												->select_list('id', 'title');
          												
          	// oznaceni selectu pro javascript menici podkategorie											
			$form->conspectus_id->id = 'category_select';
            $form->conspectus_subcategory_id->id = 'subcategory_select';
            
            $view = View::factory('tables/record_edit');
            $view->header = 'Editace zdroje';
            $view->form = $form;
            $this->template->content = $view;
            if ($form->validate())
            {
                $form->save();
                url::redirect("{$this->view_record_url}/{$resource->id}");
            }
        } else
        {
            message::set_flash('Zdroj s daným ID neexistuje');
            url::redirect('tables/resources');
        }
    }

    public function save_final_rating($id, $rating = NULL)
    {
        if ($rating == NULL)
        {
            $rating = $this->input->post('final_rating');
        }
        $resource = ORM::factory('resource')->find($id);
        switch ($rating)
        {
            case 1:
                $status = RS_REJECTED_WA;
                break;
            case 2:
                $status = RS_APPROVED_WA;
                break;
            case 3:
                $status = RS_RE_EVALUATE;
                break;
            case 4:
                $status = RS_REJECTED_WA;
                break;
            default:
                message::set_flash('Nesprávné výsledné hodnocení');
                $status = RS_NEW;
        }
        $resource->resource_status_id = $status;
        $resource->rating_result = $rating;
        $resource->save();
        message::set_flash('Finální hodnocení bylo úspěšně uloženo');

        url::redirect("{$this->view_record_url}/{$resource->id}");
    }


    public function search_by_conspectus ($conspectus_id = NULL)
    {
        if ( ! is_null( $conspectus_id ))
        {
            $search_string = $this->input->post('search_string');

            $model = ORM::factory($this->model);

            $per_page = $this->input->get('limit', 20);
            $page_num = $this->input->get('page', 1);
            $offset   = ($page_num - 1) * $per_page;

            $result = ORM::factory('resource')->where('conspectus_id', $conspectus_id)->find_all();

            $count = $result->count();
            $pages = Pagination::dropdown($count, $per_page);
            $pages_inline = Pagination::inline($count, $per_page);

            $view = new View('tables/table_conspectus');
            $view->items = $result;
            $view->pages = $pages . $pages_inline;
            $this->template = $view;
            $this->template->title = Kohana::lang('tables.'.$this->title) . " | " . Kohana::lang('tables.index');
        }
    }

    public function add_publisher ($resource_id = NULL, $publisher_id = NULL)
    {
        $resource_url = "{$this->view_record_url}/{$resource_id}";
        if (! is_null($publisher_id))
        {
            $this->set_publisher($resource_id, $publisher_id);
        }

        $view = View::factory('form');

        $form = Formo::factory('add_form');
        $form->add('publisher')->label('Vydavatel');
        $form->add_rules('required', 'publisher', 'Povinná položka');
        $form->add('submit', 'odeslat')->value('Ověřit');

        $view->form = $form;
        $view->header = 'Ověřit vkládaného vydavatele';

        $publisher_checked = (bool) $this->session->get('publisher_checked');

        if ($publisher_checked == TRUE)
        {
            $form->set('odeslat','value','Vložit');
            $view->header = "Vložit vydavatele.";
            $form->set('action', url::site("tables/resources/insert_publisher/{$resource_id}"));
        }
        elseif ($form->validate())
        {

            $publisher_name = $form->publisher->value;

            $resources = $this->check_publishers($publisher_name);
            if ($resources->count() == 0)
            {
                $form->set('odeslat','value','Vložit');
                $view->header = "Nebyly nalezeny shody - vložit vydavatele.";
                $form->set('action', url::site("tables/resources/insert_publisher/{$resource_id}"));
            } else
            {
                $view = View::factory('match_resources');

                $redirect_urls = array();
                $redirect_urls['insert'] = "tables/resources/add_publisher/{$resource_id}/";
                $redirect_urls['back'] = 'tables/resources/add_publisher';
                $redirect_urls['continue'] = $redirect_urls['insert'];

                $this->session->set_flash('publisher_checked', TRUE);

                $view->redirect_urls = $redirect_urls;

                $view->match_resources = $resources;
                $this->help_box = 'Kliknutím na konkrétního vydavatele
                přiřadíte již existujícího vydavatele';
            }
        } else
        {
            $view->form = $form->get();
        }

        $this->template->content = $view;
    }

    public function insert_publisher ($resource_id)
    {
        $publisher_name = $_POST['publisher'];
        $publisher = ORM::factory('publisher');
        $publisher->name = $publisher_name;
        $publisher->save();
        $resource = ORM::factory('resource', $resource_id);
        $resource->publisher_id = $publisher->id;
        $resource->save();
        message::set_flash('Ke zdroji byl přiřazen vydavatel: '.$publisher->name);
        url::redirect("{$this->view_record_url}/{$resource_id}");
    }

    private function set_publisher ($resource_id, $publisher_id)
    {
        $publisher = ORM::factory('publisher', $publisher_id);
        if($publisher->id == '')
        {
            message::set_flash('Vydavatel neexistuje');
        } else
        {
            $resource = ORM::factory('resource', $resource_id);
            $resource->publisher_id = $publisher->id;
            $resource->save();
            message::set_flash("Ke zdroji byl úspěšně uložen vydavatel: {$publisher->name}");
        }
        url::redirect("{$this->view_record_url}/{$resource_id}");
    }

    private function check_publishers ($publisher_name)
    {
        $resources = ORM::factory('resource')
            ->join('publishers', 'resources.publisher_id = publishers.id')
            ->orlike(array('publishers.name'=>$publisher_name))
            ->find_all();

        return $resources;
    }
}
?>