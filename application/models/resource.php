<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing resource
 *
 */
class Resource_Model extends Table_Model {
    
    protected $primary_val = 'short_title';
    protected $sorting = array ('title' => 'asc');
    
    public $headers = array ('short_title', 'icon', 'url', 'publisher');
    
    protected $belongs_to = array ('contact', 'creator' => 'curator', 'curator' => 'curator', 'publisher', 'contract', 'conspectus', 'conspectus_subcategory', 'crawl_freq', 'resource_status', 'suggested_by');
    
    protected $has_one = array ('nomination');
    
    protected $has_many = array ('seeds', 'ratings', 'correspondence', 'qa_checks');
    
    // to speed up loading of forms
    public $formo_ignores = array ('contact_id', 'publisher_id', 'contract_id');
    
    public function __construct($id = NULL) {
        parent::__construct($id);
        if (is_null($id)) {
            $this->date = date_helper::mysql_date_now();
        }
    }
    
    public function __set($key, $value) {
        if ($key === 'catalogued') {
            if ($this->__isset('catalogued')) {
                if ($value == 0) {
                    $this->catalogued = NULL;
                } else {
                    return;
                }
            }
            $date_format = Kohana::config('wadmin.date_format');
            if ($value === TRUE or $value == 1) {
                $value = date($date_format);
            }
        }
        if ($key == 'date' or $key == 'reevaluate_date') {
            if ($value == '') {
                $value = NULL;
            } else {
                $date = new DateTime($value);
                $value = $date->format(DATE_ATOM);
            }
        }
        if ($key == 'rating_result') {
            if ($value == 'NULL') {
                $value = NULL;
            }
        }
        parent::__set($key, $value);
    }
    
    public function __get($column) {
        if ($column == 'icon') {
            return $this->get_icon();
        }
        if ($column == 'short_title') {
            $value = parent::__get('title');
            $length = Kohana::config('wadmin.title_length');
            return text::limit_chars($value, $length, '');
        }
        $value = parent::__get($column);
        if ($column === 'date' or $column === 'catalogued' or $column === 'reevaluate_date') {
            if ( ! is_null($value)) {
                return date_helper::short_date($value);
            }
        }
        if ($column == 'rating_result' and $value != NULL) {
            $rating_array = Rating_Model::get_final_array();
            $value = $rating_array [$value];
        }
        return $value;
    }
    
    public static function get_rated_resources($round = 1, $limit = NULL, $offset = NULL, $pattern = NULL) {
        $conditions = array ('ratings.round' => $round);
        if ( ! is_null($pattern)) {
            $conditions ['resources.title'] = $pattern;
        }
        if ( ! is_null($limit) and  ! is_null($offset)) {
            $result = ORM::factory('resource')->join('ratings', 'resources.id = ratings.resource_id')->like($conditions)->groupby('resources.id')->find_all($limit, $offset);
        } else {
            $result = ORM::factory('resource')->join('ratings', 'resources.id = ratings.resource_id')->like($conditions)->groupby('resources.id')->find_all();
        }
        return $result;
    }
    
    /**
     * Get Resources which have new contract from the last crawl or were evaluated as unsatisfactory
     * @param $curator_id
     */
    public static function get_to_checkQA($curator_id = NULL) {
        // get the date of the last crawl
        $date = Crawl_Model::get_last_crawl()->date;
        
        $where = "contract_id IS NOT NULL
                        AND date_signed < '{$date}'
                        AND curator_id = {$curator_id}
                        AND (
                        resources.id NOT
                        IN (
                            SELECT r.id
                            FROM resources r, qa_checks q
                            WHERE r.id = q.resource_id
                            AND q.date_checked > '{$date}'
                            AND q.result != -1
                            )
                        )";
        if ( ! is_null($curator_id)) {
            $where .= " AND curator_id = {$curator_id}";
        }
        $resources = ORM::factory('resource')->join('contracts', 'contracts.id', 'resources.contract_id')->where($where)->find_all();
        return $resources;
    }
    
    public static function get_new_nominations($curator_id) {
        return ORM::factory('resource')->with('nomination')->where(array ('resources.curator_id' => $curator_id, 'nomination.resource_id IS NOT' => NULL))->find_all();
    }
    
    public static function get_important($curator_id = null, $filter = null) {
        $conditions = array ('important' => true);
        if ($curator_id != null) {
            $conditions ['curator_id'] = $curator_id;
        }
        if ($filter != null) {
            $conditions ['conspectus_id'] = $filter ['conspectus'];
            if ($filter ['conspectus_subcategory'] != '') {
                $conditions ['conspectus_subcategory_id'] = $filter ['conspectus_subcategory'];
            }
        }
        return ORM::factory('resource')->with('nomination')->where($conditions)->orderby(array ('conspectus_id' => 'asc', 'title' => 'asc'))->find_all();
    }
    
    public static function get_by_conspectus($conspectus_id = '', $subcategory_id = '', $limit = 20, $offset = 0) {
    	$conditions = array();
    	if ($conspectus_id != '') {
    		$conditions['conspectus_id'] = $conspectus_id;
    	}
    	if ($subcategory_id) {
    		$conditions['conspectus_subcategory_id'] = $subcategory_id;
    	}
    	return ORM::factory('resource')->where($conditions)->find_all($limit, $offset);
    }
    
    public function search($pattern, & $count, $limit = 20, $offset = 0) {
        $count = $this->join('publishers', 'resources.publisher_id', 'publishers.id', 'LEFT')->orlike(array ('url' => $pattern, 'title' => $pattern, 'publishers.name' => $pattern))->count_all();
        $records = $this->join('publishers', 'resources.publisher_id', 'publishers.id', 'LEFT')->orlike(array ('url' => $pattern, 'title' => $pattern, 'publishers.name' => $pattern))->orwhere('publisher_id', NULL)->find_all($limit, $offset);
        return $records;
    }
    
    public function is_related($column) {
        // TODO prepsat natvrdo napsaneho kuratora, ktery zdroj vlozil
        return in_array($column, $this->belongs_to) or $column == 'creator';
    }
    
    /**
     * Rozhoduje, zda zdroj spravuje dany kurator
     * @param Curator_Model $curator
     * @return bool pravda pokud kurator spravuje zdroj
     */
    public function is_curated_by($curator) {
        if ($curator instanceof Curator_Model and $curator->__isset('id')) {
            if ($this->curator_id == $curator->id) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            throw new InvalidArgumentException('Predany argument neni kurator');
        }
    }
    
    public function add_curator($curator) {
        if ($curator instanceof Curator_Model) {
            $this->curator_id = $curator->id;
        } else {
            throw new InvalidArgumentException();
        }
    }
    
    public function add_publisher($publisher) {
        if ($publisher instanceof Publisher_Model) {
            $this->publisher_id = $publisher->id;
        } else {
            throw new InvalidArgumentException();
        }
    }
    
    /**
     * Funkce vraci korespondenci daneho typu, ktera je vedena k danemu zdroji
     * Bez parametru vraci vsechna osloveni
     * @param int $type
     */
    public function get_correspondence($type = NULL) {
        if ( ! is_null($type)) {
            $correspondence = ORM::factory('correspondence')->where(array ('resource_id' => $this->id, 'correspondence_type_id' => $type))->find();
        } else {
            $correspondence = ORM::factory('correspondence')->where('resource_id', $this->id)->find_all();
        }
        return $correspondence;
    }
    
    /**
     * Funkce vraci datum posledniho kontaktaktovani vydavatele zdroje
     * return date datum posledniho kontaktu
     */
    public function get_last_contact() {
        $correspondence = ORM::factory('correspondence')->where('resource_id', $this->id)->orderby('date', 'DESC')->find();
        if ($correspondence->date != '') {
            return date_helper::short_date($correspondence->date);
        } else {
            return 'Nekontaktován';
        }
    }
    
    /**
     * Funkce vraci datum posledniho kola hodnoceni (alespon jeden kurator hodnotil)
     * Muze byt odlisne od atributu rating_last_round v DB, ktera obsahuje pouze uzavrena hodnoceni.
     */
    public function get_last_rating_round() {
        $sql = "SELECT MAX(round) as round FROM ratings WHERE resource_id = {$this->id}";
        $result = Database::instance()->query($sql);
        $round = $result->current()->round;
        return $round;
    }
    
    public function get_icon() {
        if ($this->has_contract()) {
            return icon::img('page', 'Zdroj má přiřazenu smlouvu');
        } elseif ($this->rating_result == 'TECHNICKÉ NE') {
            return icon::img('page_white_flash', 'Zdroj má hodnocení technické ne.');
        }
        switch($this->resource_status_id) {
            case RS_NEW :
            case RS_APPROVED_WA :
            case RS_RE_EVALUATE :
                return icon::img('tick', 'Zdroj byl schválen, k přehodnocení nebo je nový.');
            case RS_REJECTED_PUB :
            case RS_NO_RESPONSE :
                return icon::img('cross', 'Zdroj byl odmítnut vydavatelem nebo je bez odezvy.');
            case RS_REJECTED_WA :
                return icon::img('status_busy', 'Zdroj byl odmítnut WA.');
            case RS_CONTACTED :
                return icon::img('email_open', 'Zdroj je osloven.');
            case RS_END_PUBLISHING :
                return icon::img('stop', 'Zdroj ukončil vydávání.');
        }
    }
    
    public function get_nomination_icon($get_result = false) {
        if ($get_result) {
            $value = $this->nomination->accepted;
            if ($this->has_nomination()) {
                if (is_null($value)) {
                    return icon::img('bullet_red', 'Zdroj nebyl vyhodnocen.');
                } elseif ($value == 1) {
                    return icon::img('tick', 'Zdroj byl schválen jako významný.');
                } elseif ($value == 0) {
                    return icon::img('cancel', 'Zdroj byl zamítnut jako významný.');
                }
            } else {
                return '';
            }
        } else {
            if ($this->has_nomination()) {
                return icon::img('tick', 'Zdroj byl již nominován.');
            } else {
            	$icon = icon::img('pencil', 'Nominovat zdroj'); 
                return html::anchor(url::site('/tables/resources/nominate/'.$this->id), $icon);
            }
        }
    }
    
    public function print_correspondence() {
        $correspondence = $this->get_correspondence();
        $last_contact = $this->get_last_contact();
        $result = '';
        
        $i = 0;
        foreach($correspondence as $corr_object) {
            $result .= icon::img('email_open', $last_contact) . ' ';
            $i ++ ;
        }
        return $result;
    }
    
    /**
     * Pokud je jiz zaznam finalniho hodnoceni v databazi (rating_result sloupec), pak je vracena tato hodnota.
     * V opacnem pripade je hodnoceni spocitano z hodnoceni jednotlivych kuratoru.
     * @param int $round
     * @param String $return_type
     * @return int
     */
    public function compute_rating($round = 1, $return_type = 'string') {
        $value = parent::__get('rating_result');
        if ($value == '') {
            $ratings = ORM::factory('rating')->where(array ('resource_id' => $this->id, 'round' => $round))->find_all();
            if ($ratings->count() == 0) {
                return FALSE;
            }
            $result = 0;
            $is_technical_problem = false;
            foreach($ratings as $rating) {
                $rating = $rating->get_rating();
                if ($rating == 4) {
                    $is_technical_problem = true;
                }
                $result += $rating;
            }
            
            $result = $result / $ratings->count();
            if ($result < 0.5) {
                $final_rating = 1;
            } elseif ($result >= 0.5 and $rating < 1) {
                $final_rating = 3;
            } elseif ($is_technical_problem === true) {
                $final_rating = 4;
            } else {
                $final_rating = 2;
            }
        } else {
            $final_rating = $value;
        }
        if ($return_type == 'string') {
            $values = Rating_Model::get_final_array();
            return $values [$final_rating];
        } else {
            return $final_rating;
        }
    }
    
    public function rating_count($round = 1) {
        $ratings = ORM::factory('rating')->where(array ('resource_id' => $this->id, 'round' => $round))->find_all();
        return $ratings->count();
    }
    
    public function get_round_count() {
        $sql = "SELECT MAX(round) as round FROM ratings WHERE resource_id = {$this->id}";
        $result = Database::instance()->query($sql);
        return $result->current()->round;
    
    }
    
    public function has_rating($round) {
        if ($this->rating_count($round) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Vraci ciselnou hodnotu rating_result pro zdroj. Vhodne napr. pro dropdown menu.
     * @return int rating_result
     */
    public function get_rating_result() {
        return parent::__get('rating_result');
    }
    
    /**
     * Vrati datum posledniho hodnoce zdroje v danem kole
     * @param int $round kolo hodnoceni
     * @return String datum
     */
    public function get_ratings_date($round = 1) {
        $sql = "SELECT MAX(date) as datum FROM ratings WHERE resource_id = {$this->id} AND round = {$round}";
        $result = Database::instance()->query($sql);
        $datum_result = $result->current()->datum;
        $datum = date("d.m.Y", strtotime($datum_result));
        return $datum;
    }
    
    public function save_final_rating($rating = NULL) {
        switch($rating) {
            case 1 :
                $status = RS_REJECTED_WA;
                break;
            case 2 :
                $status = RS_APPROVED_WA;
                break;
            case 3 :
                $status = RS_RE_EVALUATE;
                break;
            case 4 :
                $status = RS_REJECTED_WA;
                break;
            default :
                return false;
        }
        $this->resource_status_id = $status;
        $this->rating_result = $rating;
        // set rating round to resource
        $last_round = $this->rating_last_round;
        if ($last_round == '') {
            $round = 1;
        } else {
            $round = $last_round + 1;
        }
        $this->rating_last_round = $round;
        $this->save();
        if ($this->saved) {
            return true;
        } else {
            return false;
        }
    }
    
    public function nominate($proposer_id = null) {
        $nomination = new Nomination_Model();
        $nomination->resource_id = $this->id;
        $nomination->proposer_id = $proposer_id;
        $nomination->save();
    }
    
    /**
     * Vraci hodnoceni od daneho kuratora pro dany zdroj a dane kolo
     * @param <int/string> $curator_id
     * @param <int> $round
     * @return <Rating_Model>
     */
    public function get_curator_rating($curator, $round = 1) {
        if (is_string($curator)) {
            $curator = ORM::factory('curator')->where('username', $curator)->find();
            $curator_id = $curator->id;
        } else {
            $curator_id = $curator;
        }
        $conditons = array ('round' => $round, 'curator_id' => $curator_id, 'resource_id' => $this->id);
        $rating = ORM::factory('rating')->where($conditons)->find();
        
        return $rating;
    }
    
    public function get_ratings_with_comment() {
    	return ORM::factory('rating')->where(array ('resource_id' => $this->id, 'comments !=' => ''))->find_all();
    }
    
    /**
     * Maze zdroj a prislusne zaznamy
     *zdroj
     * vydavatel (pokud ma jen tento zdroj) LiCo?: OK
     * smlouva (pokud ma jen tento zdroj) LiCo?: OK
     * kontakt (viz vyse - pozn. o funkcionalite) - LiCo?: v soucasne verzi ano, pokud by se v pristi verzi upravovala funcionalita, bylo by treba upravit stejne jako u vydavatele a smlouvy
     * hodnoceni (vsechna) LiCo?: OK
     * seminka (vsechna) LiCo?: OK
     * osloveni (vsechna) LiCo?: OK
     * nominace
     */
    public function delete_record() {
        // contact
        ORM::factory('contact', $this->contact_id)->delete();
        
        // ratings
        ORM::factory('rating')->where('resource_id', $this->id)->delete_all();
        
        // seeds
        ORM::factory('seed')->where('resource_id', $this->id)->delete_all();
        
        //nomination
        ORM::factory('nomination')->where('resource_id', $this->id)->delete_all();
        
        // correspondence
        ORM::factory('correspondence')->where('resource_id', $this->id)->delete_all();
        
        // publisher (if has only one resource)
        $publisher = new Publisher_Model($this->publisher_id);
        if (count($publisher->get_resources()) == 1) {
            $publisher->delete();
        }
        
        // contract (if has only one resource)
        $contract = new Contract_Model($this->contract_id);
        if (count($contract->get_resources()) == 1) {
            $contract->delete();
        }
        // resource
        $this->delete();
    }
    
    public function has_contract() {
        if ($this->contract_id != '') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function has_nomination() {
        $sql = "SELECT resource_id FROM nominations WHERE resource_id = {$this->id}";
        $count = Database::instance()->query($sql)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
?>
