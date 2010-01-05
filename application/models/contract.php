<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Contract_Model extends Table_Model
{

    protected $primary_val = 'contract_title';
    protected $sorting = array('year' => 'asc', 'contract_no' => 'asc');

    public $headers = array(
    'contract_title' ,
    'resource' ,
    'publisher' ,
    );

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
        if ($column == 'resource') {
            return ORM::factory('resource')->where('contract_id', $this->id)->find()->title;
        }
        if ($column == 'publisher') {
            return ORM::factory('resource')->where('contract_id', $this->id)->find()->publisher ;
        }

        $value = parent::__get($column);
        
        return $value;
    }
    
    public function __set ($key, $value)
    {
        $is_duplicate = FALSE;
        if ($key === 'cc' OR $key === 'addendum')
        {
            $value = (boolean) $value;
        }
        elseif ($key == 'year' AND $this->__isset('contract_no')) {
            $is_duplicate = self::is_already_inserted($value, $this->contract_no);
        }
        elseif ($key == 'contract_no' AND $this->__isset('year')) {
            $is_duplicate = self::is_already_inserted($this->year, $value);
        }

        if ($is_duplicate) {
            throw new WaAdmin_Exception('Duplicitní smlouva', 'Smlouva je již obsažena v databázi');
        } else {
            parent::__set($key, $value);
        }
    }

    public function search($pattern, & $count, $limit = 20, $offset = 0)
    {
        $conditions = array();
        if (strpos($pattern, '/')) {
            $contract_array = explode('/', $pattern);
            $year = $contract_array[1];
            $contract_no = $contract_array[0];
            $conditions = array('year'=>$year, 'contract_no'=>$contract_no);
        }
        $count = $this->where($conditions)
            ->select('DISTINCT contracts.*')
            ->orlike(array('resources.title'=>$pattern, 'publishers.name'=>$pattern))
            ->join('resources', 'resources.contract_id = contracts.id')
            ->join('publishers', 'resources.publisher_id = publishers.id')
            ->find_all()->count();

        $records = $this->where($conditions)
            ->select('DISTINCT contracts.*')
            ->orlike(array('resources.title'=>$pattern, 'publishers.name'=>$pattern))
            ->join('resources', 'resources.contract_id = contracts.id')
            ->join('publishers', 'resources.publisher_id = publishers.id')
            ->find_all($limit, $offset);
            
        return $records;
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

    public function get_resources() {
        $resources = ORM::factory('resource')->where('contract_id', $this->id)->find_all();
        return $resources;
    }

    public static function is_already_inserted($year, $contract_no) {
        $condition = array('year'=>$year, 'contract_no'=>$contract_no);
        $contract = new Contract_Model();
        $contract = $contract->where($condition)->find_all();
        return (bool) $contract->count();
    }
}
?>