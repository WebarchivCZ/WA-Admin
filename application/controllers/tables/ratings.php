<?php
class Ratings_Controller extends Table_Controller {
	protected $table = 'ratings';
	protected $title = 'Ratings';
        protected $header = 'Hodnocení';

        public function edit ($id = NULL) {
            $rating = ORM::factory('rating')->find($id);

            if ($rating->__isset($id)) {
                $this->session->set_flash('message', 'Požadované hodnocení není obsaženo v databazi.');
                url::redirect('/tables/ratings/');
            }
            if ($rating->curator_id != $this->user->id) {
                $this->session->set_flash('message', 'Toto hodnocení nemáte právo editovat.');
                url::redirect('/tables/resources/view/'.$rating->resource_id);
            }
            
            $form = Formo::factory();
            $form->add_select('rating', Rating_Model::get_rating_values())
                 ->label('Hodnocení')->value($rating->get_rating());
            $form->add('textarea', 'comments')
                 ->label('Komentář')->value($rating->comments);
            $form->add('bool', 'tech_problems')
                 ->label('Technické problémy')->checked((bool) $rating->tech_problems);
            $form->add('submit', 'Odeslat');

            $view = new View('tables/record_edit');
            $view->type = 'edit';
            $view->form = $form->get();
            $view->header = 'Editace hodnocení - ' . $rating->resource;
            $this->template->content = $view;

            if ($form->validate()) {
                $values = $form->get_values();
                $rating->rating = $values['rating'];
                $rating->comments = $values['comments'];
                $rating->tech_problems = $values['tech_problems'];
                $rating->date = date(Kohana::config('wadmin.date_format'));
                $rating->save();

                $message = 'Hodnocení bylo úspěšně změněno';
                $this->session->set_flash($message);
                url::redirect('tables/resources/view/'.$rating->resource_id);
            }
        }
}
?>