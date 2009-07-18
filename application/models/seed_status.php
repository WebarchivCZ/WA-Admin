<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing status of a seed
 */
class Seed_Status_Model extends Table_Model
{

    public $headers = array(
    'id' ,
    'status' ,
    'comments');

    protected $primary_val = 'status';

    protected $has_many = array('seeds');

    protected $table_name = 'seed_status';

    public function __construct ($id = NULL)
    {
        parent::__construct($id);
    }

    public function __set ($key, $value)
    {
        if ($key === 'status' AND strlen($value) > 45)
        {
            throw new InvalidArgumentException('Nazev stavu seminka je prilis dlouhy');
        }
        parent::__set($key, $value);
    }
}
?>