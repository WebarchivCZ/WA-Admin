<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Trida reprezentujici dodatek ke smlouve.
 * Pri vytvoreni je nutne predat konstruktoru
 */

class Addendum_Model extends Contract_Model
{
    protected $belongs_to = array('parent' => 'contract');
    protected $table_name = 'contracts';

    /**
     * Pro vytvoreni noveho dodatku je nutne pri volani new predat parametry (NULL, smlouva)
     * @throws WaAdmin_Exception
     * @param null $id
     * @param null $parent_contract
     */
    public function __construct($id = NULL, $parent_contract = NULL)
    {
        parent::__construct($id);

        // vytvoreni noveho dodatku na zaklade existujici smlouvy
        if (!is_null($parent_contract) AND is_null($id)) {
            if ($parent_contract instanceof Contract_Model) {
                $this->parent_id = $parent_contract->id;
                $this->addendum = TRUE;
                $this->active = TRUE;
                $this->comments .= "Doplňek pro smlouvu {$parent_contract}. ";
            } else {
                throw new WaAdmin_Exception('Nespravny argument',
                    'Doplnek smlouvy musi mit pri svem vytvoreni zadanu rodicovskou smlouvu');
            }
        }
    }
}

?>