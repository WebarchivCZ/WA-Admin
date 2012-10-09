<?php
defined('SYSPATH') or die('No direct script access.');
/**
 * Model representing Contacts
 */
class Rating_Model extends Table_Model {

	public $headers = array('curator', 'resource', 'rating', 'date', 'round');

	protected static $rating_values = array('NULL' => '',
											'-2'   => 'ne',
											'-1'   => 'spíše ne',
											'0'    => 'možná',
											'1'    => 'spíše ano',
											'2'    => 'ano',
											'4'    => 'technické ne');

	protected static $ratings_result = array('NULL' => NULL,
											 '1'    => 'NE',
											 '2'    => 'ANO',
											 '3'    => 'MOŽNÁ',
											 '4'    => 'TECHNICKÉ NE');

	protected $primary_val = 'rating';
	protected $sorting = array('date' => 'asc');

	protected $belongs_to = array('publisher', 'resource', 'curator',
		'round' => 'rating_round');

	/**
	 * @static
	 * @param $resource Resource_Model
	 * @param $curator_id int
	 * @param $rating_value int
	 * @param null $comments String
	 * @return mixed
	 */
	public static function create_instance($resource, $curator_id, $rating_value, $comments = NULL)
	{
		$rating = new self;
		$rating->add_curator((int)$curator_id);
		$rating->resource_id = $resource->id;

		$last_open_rating_round_id = $resource->get_last_rating_round_id(TRUE);

		if ($last_open_rating_round_id == NULL)
		{
			$round = new Rating_Round_Model();
			$round->round = $resource->rating_last_round + 1;
			$round->resource_id = $resource->id;
			$round->date_created = date_helper::mysql_datetime_now();

			$round->save();
		} else
		{
			$round = new Rating_Round_Model($last_open_rating_round_id);
		}
		$rating->round_id = $round->id();
		$rating->date = date_helper::mysql_datetime_now();
		$rating->rating = $rating_value;

		if ($comments != '')
		{
			$rating->comments = $comments;
		}
		return $rating;
	}

	public function __get($column)
	{
		$value = parent::__get($column);

		if ($column == 'rating')
		{
			$value = self::$rating_values [$value];
		}

		if ($column == 'tech_problems')
		{
			if ($value == TRUE)
			{
				$value = 'ANO';
			} else
			{
				$value = 'NE';
			}
		}
		if ($column === 'date')
		{
			if (! is_null($value))
			{
				$value = date('d.m.Y', strtotime($value));
			}
		}
		return $value;
	}

	public function __set($key, $value)
	{
		if ($key == 'date')
		{
			$date = new DateTime($value);
			$value = $date->format(DATE_ATOM);
		}
		if ($key == 'rating')
		{
			$is_tech_problems = ($value == 4) ? TRUE : FALSE;
			parent::__set('tech_problems', $is_tech_problems);
		}
		parent::__set($key, $value);
	}

	public function add_resource($resource)
	{
		if ($resource instanceof Resource_Model)
		{
			$this->resource_id = $resource->id;
		} else
		{
			throw new InvalidArgumentException();
		}
	}

	public function add_curator($curator)
	{
		if (is_int($curator))
		{
			$curator = new Curator_Model($curator);
		}
		if ($curator instanceof Curator_Model && $curator->loaded)
		{
			$this->curator_id = $curator->id;
		} else
		{
			throw new InvalidArgumentException("Curator hasn't been found: ID=[{$curator->id}]");
		}
	}

	public function table_view($limit = 0, $offset = 0)
	{
		$result = Resource_Model::get_rated_resources(1, $limit, $offset);
		return $result;
	}

	public function count_table_view()
	{
		$count = Resource_Model::get_rated_resources(1)->count();
		return $count;
	}

	public function search($pattern, & $count, $limit = 20, $offset = 0)
	{
		$count = Resource_Model::get_rated_resources(1, NULL, NULL, $pattern)->count();
		$records = Resource_Model::get_rated_resources(1, $limit, $offset, $pattern);
		return $records;
	}

	public function get_rating()
	{
		return parent::__get('rating');
	}

	public static function get_final_array()
	{
		return self::$ratings_result;
	}

	public static function get_final_rating($value)
	{
		if (is_string($value))
		{
			$ratings = self::get_final_array();
			return array_search($value, $ratings);
		} else
		{
			return FALSE;
		}
	}

	public static function get_rating_values()
	{
		return self::$rating_values;
	}

	public static function find_resources($user_id, $resource_status = RS_NEW, $only_rated = FALSE)
	{
		$round = ($resource_status == RS_NEW) ? ' = 1' : ' >= 2';
		$reevaluate_constraint = '';

		if ($resource_status == RS_RE_EVALUATE)
		{
			$reevaluate_constraint = 'AND reevaluate_date <= CURDATE()';
		}
		if ($only_rated == TRUE)
		{
			$sql_query = "SELECT g.resource_id AS id
                            FROM ratings g, curators c, resources r, rating_rounds rounds
                            WHERE r.curator_id = {$user_id}
                            AND g.resource_id = r.id
                            AND g.curator_id = c.id
                            AND rounds.id = g.round_id
                            AND rounds.round {$round}
                            AND r.resource_status_id = {$resource_status}
                    {$reevaluate_constraint}
                            GROUP BY g.resource_id
                            HAVING count( * ) >= 1
                        ORDER BY count(g.resource_id) ASC";
		} else
		{
			$sql_query = "SELECT r.id
                        FROM `resources` r
                        WHERE r.resource_status_id = {$resource_status}
                        AND r.id NOT IN
                        (
                            SELECT r.id
                            FROM resources r, curators c, ratings g, rating_rounds rounds
                            WHERE r.id = g.resource_id
                            AND c.id = g.curator_id
                            AND c.id = {$user_id}
                            AND rounds.id = g.round_id
                            AND rounds.round > r.rating_last_round
                        )
                    {$reevaluate_constraint}
                        ORDER BY field(suggested_by_id, 2, 1, 3, 4)";
		}
		return sql::get_id_array($sql_query);
	}
}

?>