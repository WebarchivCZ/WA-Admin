<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing resource
 *
 */
class Resource_Model extends Table_Model
{

    protected $primary_val = 'title';
    protected $sorting = array('title' => 'asc');

    public $headers = array(
    'title',
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
        if (is_null($id)) {
            $date_format = Kohana::config('wadmin.date_format');
            $this->date = date($date_format);
        }
    }

    public function __set ($key, $value)
    {
        if (($key === 'metadata' OR $key === 'catalogued') AND $value == TRUE)
        {
            $date_format = Kohana::config('wadmin.date_format');
            $value = date($date_format);
        }
        parent::__set($key, $value);
    }

    public function __get ($column)
    {
        if ($column === 'date' OR $column === 'metadata' OR $column === 'catalogued')
        {
            $value = parent::__get($column);
            if ( ! is_null($value))
            {
                return date('d.m.Y', strtotime($value));
            }
        }
        return parent::__get($column);
    }

    public function is_related ($column)
    {
        // TODO prepsat natvrdo napsaneho kuratora, ktery zdroj vlozil
        return in_array($column, $this->belongs_to) or $column == 'creator';
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
     */
    public function get_correspondence ($type)
    {
        $correspondence = ORM::factory('correspondence')
            ->where(array('resource_id' => $this->id, 'correspondence_type_id' => $type))
            ->find();
        return $correspondence;
    }

    public function compute_rating($round = 1)
    {
        $ratings_result = Kohana::config('wadmin.ratings_result');
        // FIXME zjistit hodnoceni daneho kola
        $ratings = ORM::factory('rating')->where(array('resource_id'=> $this->id))->find_all();
        $result = 0;
        foreach ($ratings as $rating)
        {
            $rating = $rating->rating;
            if ($rating == 4)
            {
                return $rating;
            }
            $result += $rating;
        }
        $result = $result / $ratings->count();
        if ($result < 0.5)
        {
            return 1;
        } elseif ($result >= 0.5 AND $rating < 1)
        {
            return 3;
        } else
        {
            return 2;
        }
    }

}
?>