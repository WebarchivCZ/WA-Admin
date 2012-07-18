<?php
/**
 * This is just helper class for sql shortcuts.
 */
class sql
{
    /**
     * Retrieve first result by execution of sql on database
     * @static
     * @param $sql
     * @return bool|mixed first result
     */
    public static function get_first_result($sql)
    {
        return Database::instance()->query($sql)->current();
    }

    /**
     * Retrieve result by execution of sql on database
     * @static
     * @param $sql
     * @return Database_Result
     */
    public static function get_result($sql)
    {
        return Database::instance()->query($sql)->result();
    }
}
