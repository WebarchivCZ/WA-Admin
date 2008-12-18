<?php defined('SYSPATH') or die('No direct script access.');
class valid_Extend extends valid_Core {

	/**
	 * Checks whether a string is valid contract number in format 44/2008
	 *
	 * @param   string   input string
	 * @return  boolean
	 */
	public static function contract_no($str)
	{
		$parts = split('/', $str, 2);
		$contract_no = $parts[0];
		$year = $parts[1];
		if (valid::digit($contract_no) AND valid::digit($year) AND strlen($year) == 4) {
			return true;
		} else {
			return false;
		}
	}


}