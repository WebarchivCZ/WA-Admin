<?php
class Statistic_Model extends Model {
	
	public static function factory() {
		return new Statistic_Model();
	}
	
	public function getBasic() {
		$resource = new Resource_Model();
		$contract = new Contract_Model();
		$publishers = new Publisher_Model();
		
		$stats = '<table>
					<tr>
						<td>Pocet zdroju</td>
						<td>'.$resource->count_all().'</td>
					</tr>
					<tr>
						<td>Pocet smluv</td>
						<td>'.$contract->count_all().'</td>
					</tr>
					<tr>
						<td>Pocet vydavatelu</td>
						<td>'.$publishers->count_all().'</td>
					</tr>
				</table>';
		return $stats;
	}
}
?>