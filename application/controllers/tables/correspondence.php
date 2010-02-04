<?php
class Correspondence_Controller extends Table_Controller {
	protected $table = 'correspondence';
	protected $title = 'Correspondence';
        protected $header = 'Oslovení';
        protected $view = 'tables/table_correspondence';

        public function edit($id) {
            if (isset($_POST['date']) AND $_POST['date']=='') {
                ORM::factory('correspondence', $id)->delete();
                message::set_flash('Korespondence byla úspěšně smazána.');
                url::redirect(url::site('tables/correspondence'));
            }
            parent::edit($id);
        }
}
?>