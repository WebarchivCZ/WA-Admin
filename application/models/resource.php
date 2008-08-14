<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing resource
 *
 */
class Resource_Model extends Table_Model
{
	protected $default_column = 'title';
	public $headers = array('id' , 'curator_id' , 'contacts_id' , 'publishers_id' , 'contracts_id' , 'title' , 'url' , 'rating_result' , 'aleph_id' , 'ISSN' , 'conspectus' , 'status' , 'creative_commons' , 'metadata' , 'catalogued' , 'crawl_frq' , 'tech_problems' , 'comments');

	public function __construct($id = NULL)
	{
		// load database library into $this->db (can be omitted if not required)
		parent::__construct($id);
	}
}
?>