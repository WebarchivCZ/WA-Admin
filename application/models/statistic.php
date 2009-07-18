<?php
class Statistic_Model extends Model
{
    public $value;
    public $name;

    public function __construct($value, $name)
    {
        parent::__construct();
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * Vrati pole statistickych hodnot, kde klic je nazev hodnoty
     * @return array vrati pole statistickych hodnot - objektu Statistic_Model
     */
    public static function getBasic()
    {
        $keys = array('resource' => 'Počet zdrojů',
            'contract' => 'Počet smluv',
            'publisher' => 'Počet vydavatelů');
        $stats = array();

        foreach (array_keys($keys) as $key)
        {
            $value = ORM::factory($key)->count_all();
            $name = $keys[$key];
            array_push($stats, new Statistic_Model($value, $name));
        }

        return $stats;
    }
}
?>