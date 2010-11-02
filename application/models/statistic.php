<?php
class Statistic_Model extends Model {
    private static $allowed_types = array ('contracts', 'resources', 'publishers');
    
    protected $value;
    protected $type;
    protected $result;
    
    public static function get_resource_statistic($type, $curator_id = null, $year = null, $month = null) {
        $settings = self::get_settings($type);
        $conditions = array ();
        if ( ! is_null($settings ['conditions'])) {
            $conditions [] = $settings ['conditions'];
        }
        if ( ! is_null($curator_id)) {
            if ($type == 'suggested') {
                $conditions [] = "creator_id = {$curator_id}";
            } elseif ($type == 'rated') {
            	$conditions [] = "t.curator_id = {$curator_id}";
            } 
            else {
                $conditions [] = "r.curator_id = {$curator_id}";
            }
        }
        if ( ! is_null($year)) {
            $conditions [] = "YEAR({$settings['date_column']}) = {$year}";
        }
        if ( ! is_null($month)) {
            $conditions [] = "MONTH({$settings['date_column']}) = {$month}";
        }
        
        $distinct = (isset($settings ['distinct']) and $settings ['distinct'] === true) ? 'DISTINCT' : '';
        
        if ( ! empty($conditions)) {
            $conditions = implode(' AND ', $conditions);
            $where = ' WHERE ' . $conditions;
        } else {
            $where = '';
        }
        $sql = "SELECT {$distinct} r.id FROM resources r{$settings['tables_add']} {$where}";
        return self::evaluate_sql($sql);
    }
    
    public static function get_contracts($year = null, $month = null) {
    	$conditions = array();
        if ( ! is_null($year)) {
            $conditions [] = "year = {$year}";
        }
        if ( ! is_null($month)) {
            $conditions [] = "MONTH(date_signed) = {$month}";
        }
        
        if ( ! empty($conditions)) {
            $conditions = implode(' AND ', $conditions);
            $where = ' WHERE ' . $conditions;
        } else {
            $where = '';
        }
        
        $sql = "SELECT c.id FROM contracts c {$where}";
        return self::evaluate_sql($sql);
    }
    
	public static function get_rated($year = null, $month = null) {
    	$conditions = array();
        if ( ! is_null($year)) {
            $conditions [] = "YEAR(last_date) = {$year}";
        }
        if ( ! is_null($month)) {
            $conditions [] = "MONTH(last_date) = {$month}";
        }
        
        if ( ! empty($conditions)) {
            $conditions = implode(' AND ', $conditions);
            $where = ' HAVING ' . $conditions;
        } else {
            $where = '';
        }
        
        $sql = "SELECT id, MAX(date) AS last_date FROM ratings GROUP BY resource_id, round {$where}";
        return self::evaluate_sql($sql);
    }
    
    protected static function get_resources() {
        $settings ['conditions'] = null;
        $settings ['tables_add'] = null;
        $settings ['date_column'] = 'date';
        return $settings;
    }
    
    protected static function get_catalogued() {
        $settings ['conditions'] = 'catalogued IS NOT NULL';
        $settings ['tables_add'] = null;
        $settings ['date_column'] = 'catalogued';
        return $settings;
    }
    
    protected static function get_suggested($suggested_by = 'curator') {
        switch($suggested_by) {
            case 'ISSN' :
                $suggested_by_id = 4;
                break;
            case 'web-visitor' :
                $suggested_by_id = 3;
                break;
            case 'web-publisher' :
                $suggested_by_id = 2;
                break;
            case 'curator' :
            default :
                $suggested_by_id = 1;
                break;
        }
        $settings ['conditions'] = "suggested_by_id = {$suggested_by_id}";
        $settings ['tables_add'] = null;
        $settings ['date_column'] = 'date';
        return $settings;
    }
    
    protected static function get_addressed() {
        $settings ['conditions'] = 'r.id = c.resource_id';
        $settings ['tables_add'] = ', correspondence c';
        $settings ['date_column'] = 'c.date';
        $settings ['distinct'] = true;
        return $settings;
    }
    
    protected static function get_contracted() {
        $settings ['conditions'] = 'r.contract_id = c.id';
        $settings ['tables_add'] = ', contracts c';
        $settings ['date_column'] = 'c.date_signed';
        return $settings;
    }
    
    protected static function get_ratings() {
        $settings ['conditions'] = 'r.id = t.resource_id';
        $settings ['tables_add'] = ', ratings t';
        $settings ['date_column'] = 't.date';
        return $settings;
    }
    
    private static function get_settings($type) {
        $settings = null;
        switch($type) {
            case "resources" :
                $settings = self::get_resources();
                break;
            case "ratings" :
                $settings = self::get_ratings();
                break;
            case "contracted" :
                $settings = self::get_contracted();
                break;
            case "suggested" :
                $settings = self::get_suggested();
                break;
            case "suggested_issn" :
                $settings = self::get_suggested('ISSN');
                break;
            case "suggested_publisher" :
                $settings = self::get_suggested('web-publisher');
                break;
            case "suggested_visitor" :
                $settings = self::get_suggested('web-visitor');
                break;
            case "catalogued" :
                $settings = self::get_catalogued();
                break;
            case "addressed" :
                $settings = self::get_addressed();
                break;
            default :
                throw new WaAdmin_Exception('Nesprávný typ statistik', 'Nebyl zadán správný typ statistik');
        }
        return $settings;
    }
    
    private static function evaluate_sql($sql) {
        $db = Database::instance();
        return $db->query($sql);
    }
}
?>