<?php
class Seeds_Controller extends Table_Controller {
	protected $table = 'seeds';
	protected $title = 'Seeds';
        protected $header = 'Semínko';
        protected $columns_ignored = array('id');

        public function add($resource_id = NULL) {
            if (! is_null($resource_id)) {
                $values = array('resource_id' => $resource_id);
                parent::add($values);
            } else {
                parent::add();
            }
        }
}
?>