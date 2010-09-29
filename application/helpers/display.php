<?php
class display {
    /**
     * Display headers of table
     */
    static function display_headers($headers) {
        $return = '';
        $i = 1;
        $l = count($headers);
        foreach($headers as $header) {
            $class = ($i == 1) ? " class='first'" : "";
            $class .= ($i == $l) ? " class='last'" : "";
            $header = Kohana::lang('tables.' . $header);
            $header = ucfirst($header);
            $return .= "<th$class>$header</th>\n";
            $i ++ ;
        }
        return $return;
    
    }
    
    static function top_menu() {
    
    }
    
    static function translate_orm($column) {
        $column = str_replace('_id', '', $column);
        return Kohana::lang('tables.' . $column);
    }
    
    static function rating($resource, $curator, $round, $static = false) {
        if (is_string($curator)) {
            $curator = ORM::factory('curator')->where('username', $curator)->find();
            $curator_id = $curator->id;
        } else {
            $curator_id = $curator;
        }
        $user_id = Session::instance()->get('auth_curator')->id;
        $rating = $resource->get_curator_rating($curator_id, $round);
        if ($rating->loaded) {
            if ($user_id == $rating->curator_id AND $round == $resource->rating_last_round + 1 AND $resource->is_ratable() AND ! $static) {
                $rating_output = display::rating_form($rating->get_rating());
            } else {
                $rating_output = "<span title='{$rating->date}'>{$rating->rating}</span>";
            }
        } elseif ($round > $resource->rating_last_round) {
            if ($user_id == $curator_id) {
                $rating_output = display::rating_form();
            } else {
                $rating_output = icon::img('cross', 'Kurátor ještě neohodnotil zdroj');
            }
        } else {
            $rating_output = icon::img('bullet_black', 'Kurátor neohodnotil zdroj a hodnocení je již uzavřeno');
        }
        
        return $rating_output;
    }
    
    /*
     * Funkce zobrazuje hodnoceni aktivniho kuratora v dropboxu
     */
    static function rating_form($resource_rating = null) {
        $rating_options = Rating_Model::get_rating_values();
        
        return form::dropdown('rating', $rating_options, $resource_rating);
    }

}
?>