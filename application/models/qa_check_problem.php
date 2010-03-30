<?php
defined ( 'SYSPATH' ) or die ( 'No direct script access.' );
class Qa_Check_Problem_Model extends Table_Model {

    protected $primary_val = 'id';

    protected $belongs_to = array ('resource', 'problem');

   	protected $table_name = 'qa_checks_qa_problems';
}
?>