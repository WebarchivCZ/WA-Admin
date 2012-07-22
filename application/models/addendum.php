<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Addendum for existing and blanco contracts.
 */

class Addendum_Model extends Contract_Model
{
    protected $belongs_to = array('parent' => 'contract');
    protected $table_name = 'contracts';

    /**
     * Constructor of new addendum. For create new one based on existing contract, needs to be called (NULL, parent_id)
     *
     * @param int $id id of existing addendum
     * @param Contract_Model $parent_contract
     * @throws WaAdmin_Exception
     */
    public function __construct($id = NULL, $parent_contract = NULL)
    {
        parent::__construct($id);
        // create new addendum based on existing contract
        if (!is_null($parent_contract) AND is_null($id)) {
            if ($parent_contract instanceof Contract_Model) {
                $this->parent_id = $parent_contract->id;
                $this->addendum = TRUE;
                $this->active = TRUE;
                if ($parent_contract->is_blanco()) {
                    $this->comments .= "Přísluší k blanco smlouvě: {$parent_contract}. ";
                } else {
                    $this->comments .= "Doplňek pro smlouvu {$parent_contract}. ";
                }
            } else {
                throw new WaAdmin_Exception('Nesprávný argument',
                    'Doplnek smlouvy musi mit pri svem vytvoreni zadanu rodicovskou smlouvu');
            }
        }
    }

    public function is_blanco()
    {
        return $this->parent->is_blanco();
    }
}