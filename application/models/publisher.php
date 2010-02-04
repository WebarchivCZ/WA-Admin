<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Model representing Publishers
 * available attributes
 * 	- id
 * 	- name
 */

class Publisher_Model extends Table_Model
{

    public $headers = array(
            'name');

    protected $primary_val = 'name';
    protected $sorting = array('name' => 'asc');

    protected $has_many = array(
            'contact' ,
            'resource');

    public function __construct ($id = NULL)
    {
        parent::__construct($id);
    }

    public function delete_record()
    {
        $resources = $this->get_resources();
        foreach($resources as $resource)
        {
            $resource->publisher_id = NULL;
            $resource->save();
        }
        $this->delete();
    }

    //TODO opravit prazdny nazev vydavatele

    /**
     * Zjisti, jestli ma vydavatel jiz podepsanou smlouvu
     * @return bool TRUE, pokud vydavatel ma jiz sepsanou nejakou smlouvu
     */
    public function has_contract()
    {
        $sql = "SELECT COUNT(c.id) as 'count' FROM contracts c, resources r WHERE
                                   r.publisher_id = {$this->id} AND
                                   r.contract_id = c.id";

        $db = Database::instance();
        $count = $db->query($sql)->current();
        if ($count->count > 0)
        {
            return TRUE;
        } else
        {
            return FALSE;
        }
    }

    /**
     * Vraci vsechny smlouvy, ktere ma vydavatel podepsane
     * @return ORM_Iterator smlouvy
     */
    public function get_contracts()
    {
        $contracts = ORM::factory('contract')
                ->select('DISTINCT contracts.id')
                ->join('resources', 'contract_id', 'contracts.id')
                ->where('resources.publisher_id', $this->id)
                ->find_all();
        return $contracts;
    }

    /**
     * Vraci vsechny zdroje, ktere patri k danemu vydavateli
     * @return Resource_Model zdroje nalezici danemu vydavateli
     */
    public function get_resources()
    {
        $resources = ORM::factory('resource')
                ->where('publisher_id', $this->id)
                ->find_all();
        return $resources;
    }
}

?>