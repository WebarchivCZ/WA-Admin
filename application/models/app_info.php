<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Model holds application contextual information. This model could be used to retrieve data
 * about application itself. This class was created to move part of configuration from config file wadmin.php
 * to database. In application_info table is very useful info about database version and this number should be increased
 * each time when database migrate is run. Please see SQL template in folder /sql/.
 * Other interesting keys in table
 * <ul>
 *  <li>application_name</li>
 *  <li>application_version</li>
 *  <li>application_build</li>
 *  <li>application_debug_mode</li>
 *  <li>database_version</li>
 *  <li>database_production_db_name</li>
 *  <li>database_test_db_name</li>
 * </ul>
 */
class App_Info_Model extends ORM {
	protected $table_name = 'application_info';
	protected $primary_val = 'value';

	public $key, $value, $group, $description, $date_created, $date_changed;

	/**
	 * Return value of application info
	 * @return mixed value of application variable
	 */
	public function get_value()
	{
		return $this->__get('value');
	}

	public function unique_key($id)
	{
		return 'key';
	}
}