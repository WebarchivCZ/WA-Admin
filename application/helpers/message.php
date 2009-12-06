<?php
class message
{
/**
 * Display headers of table
 */
    public static function set_flash($message)
    {
        Session::instance()->set_flash('message', $message);
    }
}
?>