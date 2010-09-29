<?php
class Statistic_Model extends Model {
    private static $allowed_types = array ('contracts', 'resources', 'publishers');
    
    protected $value;
    protected $type;
    protected $result;
    
    public static function get_resource_statistic($type, $curator_id = null, $year = null, $month = null) {
        $settings = self::get_settings($type);
        $conditions = $settings['conditions'];
        if ( ! is_null($curator_id)) {
            $conditions .= " AND curator_id = {$curator_id}";
        }
        if ( ! is_null($year)) {
            $conditions .= " AND YEAR({$settings['date_column']}) = {$year}";
        }
        if ( ! is_null($month)) {
            $conditions .= " AND MONTH({$settings['date_column']}) = {$month}";
        }
        
        $sql = "SELECT r.id FROM resources r{$settings['tables_add']} WHERE {$conditions}";
        return self::evaluate_sql($sql);
    }
    
    protected static function get_catalogued() {
        $settings ['conditions'] = 'catalogued IS NOT NULL';
        $settings ['tables_add'] = '';
        $settings ['date_column'] = 'catalogued';
        return $settings;
    }
    
    protected static function get_suggested() {
        $settings ['conditions'] = 'suggested_by_id = 1';
        $settings ['tables_add'] = '';
        $settings ['date_column'] = 'date';
        return $settings;
    }
    
    protected static function get_addressed() {
        $settings ['conditions'] = 'r.id = c.resource_id';
        $settings ['tables_add'] = ', correspondence c';
        $settings ['date_column'] = 'c.date';
        return $settings;
    }
    
    protected static function get_contracted() {
        $settings ['conditions'] = 'r.contract_id = c.id';
        $settings ['tables_add'] = ', contracts c';
        $settings ['date_column'] = 'c.date_signed';
        return $settings;
    }
    
    private static function get_settings($type) {
    	$settings = null;
        switch($type) {
            case "contracted" :
                $settings = self::get_contracted();
                break;
            case "suggested" :
                $settings = self::get_suggested();
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