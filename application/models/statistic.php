<?php
class Statistic_Model extends Model
{
	private static $allowed_types = array('contracts', 'resources', 'publishers');
	private static $allowed_time = array('alltime' => '01-01-1990', 'year' => 'YEAR(NOW())');
	
	protected $value;
	protected $type;
	protected $result;
	
	public static function get_statistics($type, $time, $curator = NULL) {
		if (! in_array($type, self::$allowed_types)) {
			throw new WaAdmin_Exception('Nepovolený typ statistik');
		}
		
		if ($curator != null) {
			$condition .= " AND curator = {$curator->id}";
		}
		
		$sql = "SELECT COUNT(id) as stat FROM {$type}";
		$result = Database::instance()->query($sql)->current();
		
		$statistic = new Statistic_Model();
		$statistic->result = $result;
		$statistic->type = $type;
		$statistic->value = $result->stat;
		
		return $statistic;
	}
	
	public function get_value() {
		return $this->value;
	}
}
?>