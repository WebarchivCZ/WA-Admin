<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Contract_Model extends Table_Model
{
    protected $primary_val = 'contract_title';
    protected $has_many = array('addendums');
    protected $sorting = array('year' => 'desc', 'contract_no' => 'desc');
    public $headers = array('contract_title', 'resource', 'publisher');
    public $formo_ignores = array('contract_id', 'addendum', 'parent_id');

    public function _construct($id = NULL)
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
        if ($column == 'contract_title') {
            $contract_no = $this->contract_no;
            $year = $this->year;
            return $contract_no . '/' . $year;
        }
        if ($column == 'resource') {
            return ORM::factory('resource')->where('contract_id', $this->id)->find()->title;
        }
        if ($column == 'publisher') {
            return ORM::factory('resource')->where('contract_id', $this->id)->find()->publisher;
        }

        $value = parent::__get($column);

        if ($column == 'date_signed_short') {
            return date_helper::short_date($value);
        }

        return $value;
    }

    public function __set($key, $value)
    {
        if ($key == 'cc' or $key == 'addendum' or $key == 'blanco_contract') {
            $value = (boolean)$value;
        }
        parent::__set($key, $value);
    }

    public static function create($values)
    {
        if (is_array($values)) {
            $contract = ORM::factory('contract');
            foreach ($values as $key => $value) {
                if (in_array($key, array_keys($contract->table_columns))) {
                    $contract->__set($key, $value);
                }
            }
            return $contract;
        }
    }

    public static function get_contract($year, $contract_no)
    {
        if (is_numeric($year) and is_numeric($contract_no)) {
            $contract = ORM::factory('contract')
                ->where(array('contract_no' => $contract_no, 'year' => $year))
                ->find();
            if ($contract->loaded) {
                return $contract;
            } else {
                return FALSE;
            }
        }
    }

    public static function domain_has_blanco($url)
    {
        $sql = "SELECT COUNT(id) as count FROM contracts WHERE '${url}' REGEXP domain
                                                            AND blanco_contract = 1";
        $result = Database::instance()->query($sql)->current();
        return (bool)$result->count;
    }

    public static function domain_get_blanco($url)
    {
        $sql = "SELECT id FROM contracts WHERE '${url}' REGEXP domain
                                        AND blanco_contract = 1
                                        ORDER BY date_signed DESC LIMIT 1";
        $result = Database::instance()->query($sql)->current();
        return ORM::factory('contract', $result->id)->find();
    }

    public static function is_already_inserted($year, $contract_no)
    {
        $condition = array('year' => $year, 'contract_no' => $contract_no);
        $contract = new Contract_Model();
        $contract = $contract->where($condition)->find_all();
        return (bool)$contract->count();
    }

    /**
     * Create new contract_no in format count_this_year+1/year
     * @param $date_signed
     */
    public static function new_contract_no($date_signed = NULL)
    {
        if (is_null($date_signed)) {
            $date_signed = date('Y-m-d');
        }

        $sql = 'select MAX(`contract_no`) AS `last_contract` FROM contracts WHERE year = YEAR("' . $date_signed . '")';
        $db = Database::instance();
        $result = $db->query($sql)->current();
        return $result->last_contract + 1;
    }

    public function search($pattern, & $count, $limit = 20, $offset = 0)
    {
        $conditions = array();
        if (strpos($pattern, '/')) {
            $contract_array = explode('/', $pattern);
            $year = $contract_array [1];
            $contract_no = $contract_array [0];
            $conditions = array('year' => $year, 'contract_no' => $contract_no);
        }
        $count = $this->where($conditions)->select('DISTINCT contracts.*')->orlike(
            array('resources.title' => $pattern, 'publishers.name' => $pattern))
            ->join('resources', 'resources.contract_id = contracts.id')
            ->join('publishers', 'resources.publisher_id = publishers.id')->find_all()->count();

        $records = $this->where($conditions)->select('DISTINCT contracts.*')->orlike(
            array('resources.title' => $pattern, 'publishers.name' => $pattern))
            ->join('resources', 'resources.contract_id = contracts.id')
            ->join('publishers', 'resources.publisher_id = publishers.id')->find_all($limit, $offset);

        return $records;
    }

    public function delete_record()
    {
        $resources = $this->get_resources();
        foreach ($resources as $resource) {
            $resource->contract_id = NULL;
            $resource->save();
        }
        $this->delete();
    }

    public function get_resources($publisher = NULL)
    {
        $conditions = array('contract_id' => $this->id);
        if (!is_null($publisher)) {
            $conditions ['publisher_id'] = $publisher->id;
        }
        $resources = ORM::factory('resource')->where($conditions)->find_all();
        return $resources;
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
        if (is_null($key) & is_null($val)) {
            $select_values = array();
            $contracts = $this->find_all();
            foreach ($contracts as $contract) {
                $value = $contract->contract_no . '/' . $contract->year;
                $select_values [$contract->id] = $value;
            }
            return $select_values;
        } else {
            parent::select_list($key, $val);
        }
    }

    public function has_addendums()
    {
        return (bool)$this->where('parent_id', $this->id)->find_all()->count();
    }

    public function get_addendums()
    {
        return $this->where('parent_id', $this->id)->find_all();
    }
}

?>