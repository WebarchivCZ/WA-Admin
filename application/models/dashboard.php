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
    protected $user;

    public $to_rate;
    public $new_rated;
    public $re_rate;
    public $to_catalogue;
    public $to_address;
    public $no_response;

    public function fill_dashboard($user)
    {
        $this->user = $user;

        $rate_controller = new Rate_Controller();
        $addressing_controller = new Addressing_Controller();

        $this->to_rate = $rate_controller->count_to_rate(RS_NEW);
        $this->new_rated = $rate_controller->count_rated(RS_NEW);
        $this->re_rate = $rate_controller->count_to_rate(RS_RE_EVALUATE);
        $this->to_catalogue = $this->count_to_catalogue();
        $this->to_address = $addressing_controller->count_to_addressing();
        $this->no_response = -1;
    }

    private function count_to_catalogue() {
        return ORM::factory('resource')
            ->where(array('curator_id'=>$this->user->id,
            'catalogued'=> NULL,
            'rating_result'=>Rating_Model::get_final_rating('ANO')))
            ->count_all();
    }

}
?>