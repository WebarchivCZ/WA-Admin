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

        $this->to_rate = $this->count_to_rate(RS_NEW);
        $this->new_rated = $this->count_to_rate(RS_NEW, TRUE);
        $this->re_rate = $this->count_to_rate(RS_RE_EVALUATE);
        $this->to_catalogue = $this->count_to_catalogue();
        $this->to_address = $this->count_to_addressing();
        $this->no_response = -1;

    }

    private function count_to_catalogue()
    {
        return ORM::factory('resource')
        ->where(array('curator_id'=>$this->user->id,
        'catalogued'=> NULL,
        'rating_result'=>Rating_Model::get_final_rating('ANO')))
        ->count_all();
    }

    private function count_to_rate($resource_status = RS_NEW, $only_rated = FALSE)
    {
        {
            $db = Database::instance();
            $round = ($resource_status == RS_NEW) ? 1: 2;
            $reevaluate_constraint = '';
            if ($resource_status == RS_RE_EVALUATE)
            {
                $reevaluate_constraint = 'AND reevaluate_date <= CURDATE()';
            }
            if ($only_rated == TRUE)
            {
                $sql_query = "SELECT g.resource_id AS id
                            FROM ratings g, curators c, resources r
                            WHERE r.curator_id = {$this->user->id}
                            AND g.resource_id = r.id
                            AND g.curator_id = c.id
                            AND g.round = {$round}
                            AND r.resource_status_id = {$resource_status}
                    {$reevaluate_constraint}
                            GROUP BY g.resource_id
                            HAVING count( * ) >= 1
                        ORDER BY count(g.resource_id) ASC
                    ";
            } else
            {
                $sql_query = "SELECT r.id
                        FROM `resources` r
                        WHERE r.resource_status_id = {$resource_status}
                        AND r.id NOT IN
                        (
                            SELECT r.id
                            FROM resources r, curators c, ratings g
                            WHERE r.id = g.resource_id
                            AND c.id = g.curator_id
                            AND c.id = {$this->user->id}
                            AND g.round = {$round}
                        )
                    {$reevaluate_constraint}
                        ORDER BY field(suggested_by_id, 2, 1, 3, 4)";
            }
            $query = $db->query($sql_query);

            $id_array = array();
            foreach($query->result_array(FALSE) as $row)
            {
                array_push($id_array, $row['id']);
            }
            return count($id_array);
        }

    }

    private function count_to_addressing () {
        $rs_approved_status = RS_APPROVED_WA;
        $rs_contacted_status = RS_CONTACTED;

        $sql = "(
                SELECT r.id, r.date AS created, '', 0 as count
                FROM `resources` r
                WHERE resource_status_id = {$rs_approved_status}
                AND r.curator_id = {$this->user->id}
                )
                UNION (

                SELECT r.id, r.date AS created, date_add( MAX( c.date ) , INTERVAL 1
                MONTH ) AS `new_one`, count(c.resource_id) as count
                FROM `resources` r, correspondence c
                WHERE resource_status_id = {$rs_contacted_status}
                AND c.resource_id = r.id
                AND r.curator_id = {$this->user->id}
                GROUP BY c.resource_id
                HAVING new_one <= NOW( )
                )
                ORDER BY count";


        $result = Database::instance()->query($sql);
        $id_array = array();

        foreach($result->result_array(FALSE) as $row)
        {
            array_push($id_array, $row['id']);
        }
        return count($id_array);
    }
}
?>