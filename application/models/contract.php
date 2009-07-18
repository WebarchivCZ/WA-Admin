<?php
defined('SYSPATH') or die('No direct script access.');

/**
 * Class representing Contracts
 */

class Contract_Model extends Table_Model {

    protected $primary_val = 'contract_no';

    public $headers = array(
    'id' ,
    'contract_no' ,
    'date_signed' ,
    'addendum' ,
    'cc' ,
    'comments');

    public function _construct ($id = NULL) {
        parent::__construct($id);
    }

    public function __set ($key, $value) {
        if ($key === 'cc' OR $key === 'addendum') {
            $value = (boolean) $value;
        }
        parent::__set($key, $value);
    }

    /**
     * Create new contract_no in format count_this_year+1/year
     * @param year
     */
    public function new_contract_no($year = NULL) {
        if (is_null($year)) {
            $year = date('Y');
        }

        $sql = 'select MAX(`contract_no`) as `last_contract` from contracts where year = '.$year;

        $db = Database::instance();
        $result = $db->query($sql)->current();
        return $result->last_contract + 1;
    }
}
?>