<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model kategorie konspektu
 * Obsahuje sloupce id, category, comments
 * Primarne se reprezentuje pomoci nazvu kategorie
 */
class Conspectus_Model extends Table_Model {

	public $headers = array(
		'id',
		'category',
		'comments');

	protected $table_name = 'conspectus';

	// generovany sloupec title '1 - Kategorie'
	protected $primary_val = 'title';

	protected $has_many = array(
		'resources', 'conspectus_subcategories');

	/**
	 * Vraci hodnotu z databaze
	 * Pro sloupec 'title' vraci '1 - Kategorie'
	 * @param string $column
	 * @return mixed hodnota sloupce
	 */
	public function __get($column)
	{
		if ($column == 'title')
		{
			$id = parent::__get('id');
			$category = parent::__get('category');
			$title = $id.' - '.$category;
			return $title;
		}
		return parent::__get($column);
	}
}

?>