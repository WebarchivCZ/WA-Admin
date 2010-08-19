<?php
class display
{
/**
 * Display headers of table
 */
    static function display_headers($headers)
    {
        $return = '';
        $i = 1;
        $l = count($headers);
        foreach ($headers as $header)
        {
            $class = ($i == 1)  ? " class='first'" : "" ;
            $class .= ($i == $l)  ? " class='last'" : "" ;
            $header = Kohana::lang('tables.'.$header);
            $header = ucfirst($header);
            $return .= "<th$class>$header</th>\n";
            $i++;
        }
        return $return;

    }

    static function top_menu()
    {

    }

    static function translate_orm ($column)
    {
        $column = str_replace('_id', '',$column);
        return Kohana::lang('tables.'.$column);
    }

    static function display_rating($resource, $curator, $round)
    {
        if (is_string($curator)) {
            $curator = ORM::factory('curator')->where('username', $curator)->find();
            $curator_id = $curator->id;
        } else {
            $curator_id = $curator;
        }
        $rating = $resource->get_curator_rating($curator_id, $round);

        if ( ! is_null($rating))
        {
            $rating_output = "<span title='{$rating->date}'>{$rating->rating}</span>";
            if ($rating->curator_id == $curator_id)
            {
                $rating_output = "<a href='".url::site('tables/ratings/edit/'.$rating->id)."'>
                    {$rating_output}</a>";
            }
        } elseif ($round > $resource->rating_last_round)
        {
            $rating_output = icon::img('cross', 'Kurátor ještě neohodnotil zdroj');
        } else
        {
            $rating_output = icon::img('bullet_black', 'Kurátor neohodnotil zdroj a hodnocení je již uzavřeno');
        }

        return $rating_output;
    }
}
?>