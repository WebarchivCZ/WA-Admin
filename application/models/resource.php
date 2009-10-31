<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing resource
 *
 */
class Resource_Model extends Table_Model
{

    protected $primary_val = 'short_title';
    protected $sorting = array('title' => 'asc');

    public $headers = array(
    'short_title',
    'url',
    'publisher'
    );

    protected $belongs_to = array(
    'contact' ,
    'creator' => 'curator',
    'curator' => 'curator',
    'publisher' ,
    'contract' ,
    'conspectus' ,
    'crawl_freq' ,
    'resource_status' ,
    'suggested_by');

    protected $has_many = array(
    'seeds' ,
    'ratings' ,
    'correspondence' ,
    'quality_control');

    public function __construct ($id = NULL)
    {
        parent::__construct($id);
        if (is_null($id))
        {
            $date_format = Kohana::config('wadmin.date_format');
            $this->date = date($date_format);
        }
    }

    public function __set ($key, $value)
    {
        if ($key === 'catalogued' AND $value == TRUE)
        {
            $date_format = Kohana::config('wadmin.date_format');
            $value = date($date_format);
        }
        if ($key == 'date' OR $key == 'reevaluate_date')
        {
            if ($value == '')
            {
                $value = NULL;
            } else
            {
                $date = new DateTime($value);
                $value = $date->format(DATE_ATOM);
            }
        }
        if ($key == 'rating_result')
        {
            if ($value == 'NULL')
            {
                $value = NULL;
            }
        }
        parent::__set($key, $value);
    }

    public function __get ($column)
    {
        if ($column == 'short_title')
        {
            $value = parent::__get('title');
            $length = Kohana::config('wadmin.title_length');
            return text::limit_chars($value, $length, '');
        }
        $value = parent::__get($column);
        if ($column === 'date' OR $column === 'catalogued' OR $column === 'reevaluate_date')
        {
            if ( ! is_null($value))
            {
                return date_helper::short_date($value);
            }
        }
        if ($column == 'rating_result' AND $value != NULL)
        {
            $rating_array = Rating_Model::get_final_array();
            $value = $rating_array[$value];
        }
        return $value;
    }

    public static function get_rated_resources ($round = 1, $limit = NULL, $offset = NULL)
    {
        if ( ! is_null ($limit) AND ! is_null($offset))
        {
            $result = ORM::factory('resource')->join('ratings', 'resources.id = ratings.resource_id')
                ->where('ratings.round', 1)
                ->groupby('resources.id')
                ->find_all($limit, $offset);
        } else
        {
            $result = ORM::factory('resource')->join('ratings', 'resources.id = ratings.resource_id')
                ->where('ratings.round', 1)
                ->groupby('resources.id')
                ->find_all();
        }
        return $result;
    }

    public function search($pattern, & $count, $limit = 20, $offset = 0)
    {
        $count = $this->join('publishers', 'resources.publisher_id = publishers.id')
            ->orlike(array('url' => $pattern , 'title' => $pattern, 'publishers.name'=>$pattern))
            ->count_all();
        $records = $this->join('publishers', 'resources.publisher_id = publishers.id')
            ->orlike(array('url' => $pattern , 'title' => $pattern, 'publishers.name'=>$pattern))
            ->find_all($limit, $offset);
        return $records;
    }

    public function is_related ($column)
    {
    // TODO prepsat natvrdo napsaneho kuratora, ktery zdroj vlozil
        return in_array($column, $this->belongs_to) or $column == 'creator';
    }

    /**
     * Rozhoduje, zda zdroj spravuje dany kurator
     * @param Curator_Model $curator
     * @return bool pravda pokud kurator spravuje zdroj
     */
    public function is_curated_by ($curator)
    {
        if ($curator instanceof Curator_Model AND $curator->__isset('id'))
        {
            if ($this->curator_id == $curator->id)
            {
                return TRUE;
            } else
            {
                return FALSE;
            }
        } else
        {
            throw new InvalidArgumentException('Predany argument neni kurator');
        }
    }

    public function add_curator ($curator)
    {
        if ($curator instanceof Curator_Model)
        {
            $this->curator_id = $curator->id;
        } else
        {
            throw new InvalidArgumentException();
        }
    }

    public function add_publisher ($publisher)
    {
        if ($publisher instanceof Publisher_Model)
        {
            $this->publisher_id = $publisher->id;
        } else
        {
            throw new InvalidArgumentException();
        }
    }

    /**
     * Funkce vraci korespondenci daneho typu, ktera je vedena k danemu zdroji
     * Bez parametru vraci vsechna osloveni
     * @param int $type
     */
    public function get_correspondence ($type = NULL)
    {
        if (! is_null($type))
        {
            $correspondence = ORM::factory('correspondence')
                ->where(array('resource_id' => $this->id, 'correspondence_type_id' => $type))
                ->find();
        } else
        {
            $correspondence = ORM::factory('correspondence')
                ->where('resource_id', $this->id)
                ->find_all();
        }
        return $correspondence;
    }

    /**
     * Funkce vraci datum posledniho kontaktaktovani vydavatele zdroje
     * return date datum posledniho kontaktu
     */
    public function get_last_contact()
    {
        $correspondence = ORM::factory('correspondence')
            ->where('resource_id', $this->id)
            ->orderby('date', 'DESC')
            ->find();
        if ($correspondence->date != '')
        {
            return date_helper::short_date($correspondence->date);
        } else
        {
            return 'Nekontaktován';
        }
    }

    /**
     * Pokud je jiz zaznam finalniho hodnoceni v databazi (rating_result sloupec), pak je vracena tato hodnota.
     * V opacnem pripade je hodnoceni spocitano z hodnoceni jednotlivych kuratoru.
     * @param int $round
     * @param String $return_type
     * @return int
     */
    public function compute_rating($round = 1, $return_type = 'string')
    {
    //$ratings_result = Kohana::config('wadmin.ratings_result');
    // FIXME zjistit hodnoceni daneho kola
        $value = parent::__get('rating_result');
        if ($value == '')
        {
            $ratings = ORM::factory('rating')->where(array('resource_id'=> $this->id))->find_all();
            if ($ratings->count() == 0)
            {
                return FALSE;
            }
            $result = 0;
            foreach ($ratings as $rating)
            {
                $rating = $rating->get_rating();
                if ($rating == 4)
                {
                    $final_rating = $rating;
                }
                $result += $rating;
            }
            $result = $result / $ratings->count();
            if ($result < 0.5)
            {
                $final_rating = 1;
            } elseif ($result >= 0.5 AND $rating < 1)
            {
                $final_rating = 3;
            } else
            {
                $final_rating = 2;
            }
        } else
        {
            $final_rating = $value;
        }
        if ($return_type == 'string')
        {
            $values = Rating_Model::get_final_array();
            return $values[$final_rating];
        } else
        {
            return $final_rating;
        }
    }

    public function rating_count($round = 1)
    {
        $ratings = ORM::factory('rating')->where(array('resource_id'=> $this->id,
            'round' => $round))
            ->find_all();
        return $ratings->count();
    }

    public function has_rating($round)
    {
        if ($this->rating_count($round) > 0)
        {
            return TRUE;
        } else
        {
            return FALSE;
        }
    }

    /**
     * Vraci ciselnou hodnotu rating_result pro zdroj. Vhodne napr. pro dropdown menu.
     * @return int rating_result
     */
    public function get_rating_result()
    {
        return parent::__get('rating_result');
    }

    /**
     * Vrati datum posledniho hodnoce zdroje v danem kole
     * @param int $round kolo hodnoceni
     * @return String datum
     */
    public function get_ratings_date($round = 1)
    {
        $sql = "SELECT MAX(date) as datum FROM ratings WHERE resource_id = $this->id AND round = 1";
        $result = Database::instance()->query($sql);
        $datum_result = $result->current()->datum;
        $datum = date("d.m.Y", strtotime($datum_result));
        return $datum;
    }

    /**
     * Vraci hodnoceni od daneho kuratora pro dany zdroj a dane kolo
     * @param <int/string> $curator_id
     * @param <int> $round
     * @return <Rating_Model>
     */
    public function get_curator_rating($curator, $round = 1)
    {
        if (is_string($curator))
        {
            $curator = ORM::factory('curator')->where('username', $curator)->find();
            $curator_id = $curator->id;
        } else
        {
            $curator_id = $curator;
        }
        $conditons = array('round'=>$round, 'curator_id'=>$curator_id, 'resource_id'=>$this->id);
        $rating = ORM::factory('rating')->where($conditons)->find();
        if ($rating->id == 0)
        {
            $rating = NULL;
        }
        return $rating;
    }
}
?>