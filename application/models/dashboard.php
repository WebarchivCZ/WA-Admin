<?php

/**
 * Dashboard  from use case:
 *
 * Ahoj Libore, máš:
 *
 * 5 zdrojů k hodnocení – proklik na modul hodnocení
 * 3 nově hodnocené – proklik na modul pro správu zdrojů (ekvivalent formuláře upravit zdroj v současné WA Admin); bude obsahovat jednak schválené a jednak odmítnuté zdroje
 * 2 zdroje k přehodnocení – podobné jako u zdrojů k hodnocení, ale jde o věci, které už byly dříve hodnoceny a bylo rozhodnuto dát je k novému hodnocení později (momentálně půl roku)
 * 3 zdroje ke katalogizaci
 * 2 zdroje k oslovení – bude obsahovat 1. a 2. oslovení, v některých případech i třetí; dále by mělo obsahovat zdroje, které byly navrženy přes webový formulář nebo ISSN – u těchto věcí se posílá buďto vyrozumění o přijetí nebo zamítnutí návrhu (v současnosti není evidováno ve WA Admin kromě poznámky)
 * 1 zdroj bez odezvy – po 1 měsíci, pokud nepřišla odpověď ani na druhé oslovení – kurátor má možnost zvážit ještě jedno oslovení
 *
 *
 */
class Dashboard_Model extends Model {
	protected $user;

	public $to_rate;
	public $re_rate;
	public $new_rated;
	public $new_rerated;
	public $to_catalogue;
	public $to_address;
	public $to_qa;
	public $no_response;

	public function fill_dashboard($user)
	{
		$this->user = $user;

		$this->to_rate = count(Rating_Model::find_resources($user->id, RS_NEW, FALSE));
		$this->re_rate = count(Rating_Model::find_resources($user->id, RS_RE_EVALUATE, FALSE));
		$this->new_rated = count(Rating_Model::find_resources($user->id, RS_NEW, TRUE));
		$this->new_rerated = count(Rating_Model::find_resources($user->id, RS_RE_EVALUATE, TRUE));
		$this->to_catalogue = $this->count_to_catalogue();
		$this->to_address = $this->count_to_addressing();
		$this->to_qa = Resource_Model::get_to_checkQA($user->id)->count();
		$this->in_progress = $this->count_in_progress();
		$this->nominated = Nomination_Model::get_new($this->user->id)->count();

	}

	private function count_in_progress()
	{
		return ORM::factory('resource')
			->in('resource_status_id', RS_CONTACTED)
			->where('curator_id', $this->user->id)
			->orderby('title', 'ASC')
			->find_all()->count();
	}

	private function count_to_catalogue()
	{
		$conditions = array('curator_id'         => $this->user->id,
							'catalogued'         => NULL,
							'resource_status_id' => RS_APPROVED_PUB);
		return ORM::factory('resource')->where($conditions)->find_all()->count();
	}

	private function count_to_addressing()
	{
		$sql = "(
                    SELECT r.id, r.date AS created, '', 0 as count
                    FROM `resources` r
                    WHERE resource_status_id = ".RS_APPROVED_WA."
                    AND r.curator_id = {$this->user->id}
                )
                UNION
                (
                    SELECT r.id, r.date AS created, date_add( MAX( c.date ) , INTERVAL 1
                    MONTH ) AS `new_one`, count(c.resource_id) as count
                    FROM `resources` r, correspondence c
                    WHERE resource_status_id = ".RS_CONTACTED."
                    AND c.resource_id = r.id
                    AND r.curator_id = {$this->user->id}
                    GROUP BY c.resource_id
                    HAVING new_one <= NOW( )
                )
                ORDER BY count";

		$id_array = sql::get_id_array($sql);
		return count($id_array);
	}
}

?>