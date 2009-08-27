<?php
class Resources_Controller extends Table_Controller
{
    protected $table = 'resources';
    protected $title = 'Resources';
    protected $columns_ignored = array('id', 'publisher_id', 'contact_id', 'contract_id');
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
                'conspectus_id', 'crawl_freq_id',
                'resource_status_id', 'suggested_by_id', 'rating_result', 'reevaluate_date',
                'aleph_id', 'issn', 'catalogued',
                'tech_problems', 'comments', 'upravit');

            $view = View::factory('tables/record_edit');
            $view->header = 'Editace zdroje';
            $view->form = $form;
            $this->template->content = $view;
            if ($form->validate())
            {
                $form->save();
                url::redirect('tables/resources/view/'.$resource->id);
            }
        } else
        {
            $this->session->set_flash('message', 'Zdroj s daným ID neexistuje');
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
                $this->session->set_flash('message', 'Nesprávné výsledné hodnocení');
                $status = RS_NEW;
        }
        $resource->resource_status_id = $status;
        $resource->rating_result = $rating;
        $resource->save();
        $this->session->set_flash('message', 'Finální hodnocení bylo úspěšně uloženo');

        url::redirect(url::site('tables/resources/view/'.$resource->id));
    }

    public function search($konspekt_id = NULL) {
        if ($konspekt_id == NULL) {
            $search_string = $this->input->post('search_string');
            parent::search(array('title' => $search_string));
        } else {
            parent::search(array('conspectus_id' => $konspekt_id));
        }
    }
}
?>