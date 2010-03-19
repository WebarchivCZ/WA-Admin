<?php
/**
 * Description of valid_custom
 *
 * @author adam
 */
class valid_custom {
    public static function simple_domain ($value) {
        $pattern = '/^[\w-]+\.\w+$/';
        $result = preg_match($pattern, $value);
        $is_domain = (bool) $result;
        if ($is_domain) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
?>
