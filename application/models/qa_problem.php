<?php
defined('SYSPATH') or die ('No direct script access.');
class Qa_Problem_Model extends Table_Model {

	protected $primary_val = 'id';

	protected $has_and_belongs_to_many = array('qa_checks');
}

?>