<?php
defined('SYSPATH') or die('No direct script access.');
class Conspectus_Subcategory_Model extends Table_Model {

	public $headers = array(
		'id',
		'subcategory',
		'comments');

	protected $table_name = 'conspectus_subcategories';

	// generovany sloupec title '1 - Kategorie'
	protected $primary_val = 'title';

	protected $has_many = array(
		'resources');

	protected $belogs_to = array('conspectus');

	/**
	 * Vraci hodnotu z databaze
	 * Pro sloupec 'title' vraci '1 - Podkategorie'
	 * @param string $column
	 * @return mixed hodnota sloupce
	 */
	public function __get($column)
	{
		if ($column == 'title')
		{
			$id = parent::__get('subcategory_id');
			$category = parent::__get('subcategory');
			$title = $id.' - '.$category;
			return $title;
		}
		return parent::__get($column);
	}
}

?>