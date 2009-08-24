<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Conspectus category
 */
class Conspectus_Model extends Table_Model
{

	public $headers = array(
		'id' , 
		'category' , 
		'comments');
	
	protected $table_name = 'conspectus';

	protected $primary_val = 'title';

	protected $has_many = array(
		'resources');

	public function __construct ($id = NULL)
	{
		parent::__construct($id);
	}

	public function __set ($key, $value)
	{
		parent::__set($key, $value);
	}

        public function __get ($column) {
            if ($column == 'title') {
                $id = parent::__get('id');
                $category = parent::__get('category');
                return $id.' - '.$category;
            }
            return parent::__get($column);
        }
}
?>