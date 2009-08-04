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
        $append_view = View::factory('tables/append_resource');
        $append_view->resource = $this->record;
        $append_view->active_curators = ORM::factory('curator')->where('active', 1)->find_all();
        $append_view->ratings = ORM::factory('rating')->where('resource_id', $this->record->id)
            ->find_all();
        $view = $this->template->content;
        $view->set('append_view', $append_view);
    }

    public function edit($id = FALSE)
    {
        $resource = ORM::factory('resource')->find($id);

        if ($resource->__isset('id'))
        {
            $form = Formo::factory()->orm('resource', $id)
                ->remove(array('id', 'publisher_id', 'contact_id'))
                ->add('contract_cc')
                ->add('contract_comments')
                ->add('submit', 'Upravit')
                ->label_filter('display::translate_orm')
                ->label_filter('ucfirst');

            $form->contract_cc->checked((bool)$resource->contract->cc);
            $form->contract_comments->value($resource->contract->comments)
                ->readonly(true);
            $form->metadata->checked(! is_null($resource->metadata))
                ->title($resource->metadata);
            $form->catalogued->checked(! is_null($resource->catalogued))
                ->title($resource->catalogued);

            $form->_order = array('title', 'url', 'date', 'creator_id', 'curator_id',
                'contract_id', 'contract_cc', 'contract_comments', 'conspectus_id', 'crawl_freq_id',
                'resource_status_id', 'suggested_by_id', 'rating_result',
                'aleph_id', 'issn', 'metadata', 'catalogued',
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
}
?>