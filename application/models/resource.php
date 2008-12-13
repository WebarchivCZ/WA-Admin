<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing resource
 *
 */
class Resource_Model extends Table_Model
{
    protected $default_column = 'title';
    public $headers = array(
        'id' , 
        'curator_id' , 
        'contacts_id' , 
        'publishers_id' , 
        'contracts_id' , 
        'title' , 
        'url' , 
        'rating_result' , 
        'aleph_id' , 
        'ISSN' , 
        'conspectus' , 
        'status' , 
        'creative_commons' , 
        'metadata' , 
        'catalogued' , 
        'crawl_frq' , 
        'tech_problems' , 
        'comments');
    
    protected $has_one = array(
        'contact' , 
        'curator' , 
        'publisher' , 
        'contract' , 
        'conspectus' , 
        'crawl_freq' , 
        'resource_status' , 
        'suggested_by');
    protected $has_many = array(
        'seeds' , 
        'ratings' , 
        'correspondence' , 
        'quality_control');

    
    public function __construct ($id = NULL)
    {
        // load database library into $this->db (can be omitted if not required)
        parent::__construct($id);
    }
    
    public function is_related($column) {
    	return in_array($column, $this->has_one);
    }
}
?>