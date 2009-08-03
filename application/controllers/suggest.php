<?php
class Suggest_Controller extends Template_Controller
{

    protected $title = 'Vložení nového zdroje';

    public function index ()
    {
        $view = View::factory('form');

        $form = Formo::factory('add_form');
        $form->add('title')->label('Název');
        $form->add('publisher')->label('Vydavatel');
        $form->add('url')->label('URL')->value('http://')->add_rule('url', 'url', 'Musí být ve tvaru url.');
        $form->add_rules('required', 'title|publisher|url', 'Povinná položka');
        $form->add('submit', 'Ověřit');

        $view->form = $form;
        $view->header = 'Ověřit vkládaný zdroj';
        
        if ($form->validate())
        {
            $publisher_name = $form->publisher->value;
            $title = $form->title->value;
            $url = $form->url->value;

            // nastaveni promennych pro vyuziti v metode insert()
            $resource_array = array('title' => $title,
                'url' => $url,
                'publisher' => $publisher_name);
            $this->session->set('resource_val', $resource_array);

            $resources = $this->check_records($publisher_name, $title, $url);
            if ($resources->count() == 0) {
                $this->session->set_flash('message', 'Nebyly nalezeny shody.');
                url::redirect('suggest/insert/');
            } else {
            $view = View::factory('match_resources');

            $view->match_resources = $resources;
            $this->help_box = 'Kliknutím na konkrétního vydavatele
                přiřadíte již existujícího vydavatele nově vkládanému zdroji';
            }
        } else
        {
            $view->form = $form->get();
        }

        $this->template->content = $view;
    }

    public function insert ($publisher = NULL)
    {
    // nacteni hodnot z predchoziho formulare
        $resource_val = $this->session->get('resource_val');

        $title = $resource_val['title'];
        $url = $resource_val['url'];

        if ($publisher != NULL) {
            $publisher_name = $publisher;
        } else {
            $publisher_name = $resource_val['publisher'];
        }

        $curators = ORM::factory('curator')->where('active', 1)->select_list('id', 'username');
        $conspectus = ORM::factory('conspectus')->select_list('id', 'category');
        $suggested_by = ORM::factory('suggested_by')->select_list('id', 'proposer');

        $curator_id = Auth::instance()->get_user()->id;

        $form = Formo::factory('insert_resource');
        $form->add('title')->label('Název zdroje')->value($title)->disabled(TRUE);
        $form->add('url')->label('URL')->value($url)->disabled(TRUE);
        $form->add('publisher')->label('Vydavatel')->value($publisher_name)->disabled(TRUE);
        $form->add_select('curator', $curators)->label('Kurátor')->value($curator_id);
        $form->add_select('conspectus', $conspectus)->label('Konspekt');
        $form->add_select('suggested_by', $suggested_by)->label('Navrhl');
        $form->add('submit', 'Vložit zdroj');


        if ($form->validate())
        {

            $publisher = ORM::factory('publisher', $publisher_name);
            if (! $publisher->loaded)
            {
                $publisher->name = $publisher_name;
                $publisher->save();
            }

            $resource = ORM::factory('resource');
            $resource->title = $title;
            $resource->url = $url;
            $resource->publisher_id = $publisher->id;
            $resource->conspectus_id = $form->conspectus->value;
            $resource->creator_id = $curator_id;
            $resource->curator_id = $form->curator->value;
            $resource->suggested_by_id = $form->suggested_by->value;
            $resource->resource_status_id = RS_NEW;
            $resource->save();

            $seed = ORM::factory('seed');
            $seed->url = $url;
            $seed->resource_id = $resource->id;
            $seed->seed_status_id = ORM::factory('seed_status', 1)->id;
            $seed->valid_from = date('Y-m-d');

            $seed->save();

            $this->session->delete('resource_val');

            url::redirect('rate');
        } else
        {
            $this->template->content = View::factory('form')
                                            ->bind('form', $form)
                                            ->set('header', 'Vložit zdroj');
        }
    }
/**
 * Vyhleda zdroje a vydavatele vyhovujici zadanym podminkam a vrati je jako iterator
 * @param String $publisher_name jmeno vydavatele
 * @param String $title nazev zdroje
 * @param String $url url zdroje
 * @return Resource_Iterator mnozina vyhovujicich zdroju
 */
    private function check_records ($publisher_name, $title, $url)
    {
        $resources = ORM::factory('resource')
            ->join('publishers', 'resources.publisher_id = publishers.id')
            ->orlike(array('url' => $url , 'title' => $title, 'publishers.name'=>$publisher_name))
            ->find_all();

        return $resources;
    }

}
?>