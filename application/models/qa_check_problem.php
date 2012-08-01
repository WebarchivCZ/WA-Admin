<?php
defined('SYSPATH') or die ('No direct script access.');
class Qa_Check_Problem_Model extends Table_Model {

	protected $primary_val = 'comments';

	protected $belongs_to = array('qa_check', 'qa_problem');

	protected $table_name = 'qa_checks_qa_problems';

	public function __get($column)
	{
		if ($column == 'id')
		{
			$value = md5($this->qa_check_id.$this->qa_problem_id);
		} else
		{
			$value = parent::__get($column);
		}
		return $value;
	}
}

?>