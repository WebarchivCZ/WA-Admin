<?php
/**
 * Exception thrown by Wa Admin
 *
 * @author adam
 */
class WaAdmin_Exception extends Kohana_User_Exception {
    public function __construct($title, $message, $template = FALSE)
    {
        parent::__construct($title, $message, $template);
    }

}
?>
