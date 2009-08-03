<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Contract_Model extends Table_Model
{

    protected $primary_val = 'contract_title';
    protected $sorting = array('date_signed' => 'asc');

    public $headers = array(
    'contract_title' ,
    'date_signed' ,
    'addendum' ,
    'cc' ,
    'comments');

    public function _construct ($id = NULL)
    {
        parent::__construct($id);
    }

    /**
     * Vraci hodnotu daneho sloupce.
     * Pokud je sloupec contract_title, pak je vracen formatovany retezec ve
     * tvaru: contract_no/year
     * @param mixed $column sloupec
     * @return mixed
     */
    public function __get($column)
    {
        if ($column == 'contract_title')
        {
            $contract_no = $this->contract_no;
            $year = $this->year;
            return $contract_no.'/'.$year;
        }
        return parent::__get($column);
    }
    
    public function __set ($key, $value)
    {
        if ($key === 'cc' OR $key === 'addendum')
        {
            $value = (boolean) $value;
        }
        parent::__set($key, $value);
    }

    /**
     * Create new contract_no in format count_this_year+1/year
     * @param year
     */
    public function new_contract_no($year = NULL)
    {
        if (is_null($year))
        {
            $year = date('Y');
        }

        $sql = 'select MAX(`contract_no`) as `last_contract` from contracts where year = '.$year;

        $db = Database::instance();
        $result = $db->query($sql)->current();
        return $result->last_contract + 1;
    }

    /**
     * Vraci pole, ktere je mozne pouzit pro select listy, napriklad ve formularich
     * Pole je ve tvaru [id] => [contract_no/year]
     * @param string $key
     * @param string $val
     * @return array pole klic => hodnota
     */
    public function select_list($key = NULL, $val = NULL)
    {
        if (is_null($key) & is_null($val))
        {
            $select_values = array();
            $contracts = $this->find_all();
            foreach ($contracts as $contract)
            {
                $value = $contract->contract_no . '/' . $contract->year;
                $select_values[$contract->id] = $value;
            }
            return $select_values;
        } else
        {
            parent::select_list($key, $val);
        }
    }
}
?>