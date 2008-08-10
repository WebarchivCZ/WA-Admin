<?php
class display
{
	/**
	 * Display headers of table
	 */
	static function display_headers($headers) {
		$return = '';
		$i = 1;
		$l = count($headers);
		foreach ($headers as $header) {
			$class = ($i == 1)  ? " class='first'" : "" ;
			$class .= ($i == $l)  ? " class='last'" : "" ;
			$header = Kohana::lang('tables.'.$header);
			$header = ucfirst($header);
			$return .= "<th$class>$header</th>\n";
			$i++;
		}
		return $return;
		
	}
	
	static function top_menu() {
				
	}
}
?>