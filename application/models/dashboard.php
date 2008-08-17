<?php

/**
 * Dashboard  from use case:
 * 
 * Ahoj Libore, máš:
 *	
 *	5 zdrojů k hodnocení – proklik na modul hodnocení
 *	3 nově hodnocené – proklik na modul pro správu zdrojů (ekvivalent formuláře upravit zdroj v současné WA Admin); bude obsahovat jednak schválené a jednak odmítnuté zdroje
 *	2 zdroje k přehodnocení – podobné jako u zdrojů k hodnocení, ale jde o věci, které už byly dříve hodnoceny a bylo rozhodnuto dát je k novému hodnocení později (momentálně půl roku)
 *	3 zdroje ke katalogizaci
 *	2 zdroje k oslovení – bude obsahovat 1. a 2. oslovení, v některých případech i třetí; dále by mělo obsahovat zdroje, které byly navrženy přes webový formulář nebo ISSN – u těchto věcí se posílá buďto vyrozumění o přijetí nebo zamítnutí návrhu (v současnosti není evidováno ve WA Admin kromě poznámky)
 *	1 zdroj bez odezvy – po 1 měsíci, pokud nepřišla odpověď ani na druhé oslovení – kurátor má možnost zvážit ještě jedno oslovení
 * 
 *
 */
class Dashboard_Model extends Model
{
	public $to_rate;
	public $new_rated;
	public $re_rate;
	public $to_catalogue;
	public $to_address;
	public $no_response;
	
	
	/**
	 * Method returning new instance of Dashboard model.
	 */
	public static function factory()
	{
		return new Dashboard_Model();
	}
	
	public function __construct() {
		$this->fill_dashboard();
	}
	
	private function fill_dashboard() {
		$res = new Resource_Model();
		
		$this->to_rate = 5;
		$this->new_rated = 4;
		$this->re_rate = 3;
		$this->to_catalogue = 2;
		$this->to_address = 1;
		$this->no_response = 0;
	}
}
?>