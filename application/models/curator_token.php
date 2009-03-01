<?php defined('SYSPATH') OR die('No direct access allowed.');

class Curator_Token_Model extends Auth_Token_Model {

	protected $belongs_to = array('curator');

} // End User Token Model