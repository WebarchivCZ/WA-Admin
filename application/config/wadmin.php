<?php
$config = array(
	'top_menu' => array(
		'home' , 
		'suggest' , 
		'rate' , 
		'addressing' , 
		'progress' , 
		'catalogue' , 
		'quality_control') , 
	
	'ratings_result' => array(
		'1' => 'NE' , 
		'2' => 'ANO' , 
		'3' => 'MOŽNÁ' , 
		'4' => 'TECHNICKÉ NE') , 
	
	'rating_values' => array(
		'NULL'   => '' , 
		'-2' => 'ne' , 
		'-1' => 'spíše ne' , 
		'0'  => 'možná' , 
		'1'  => 'spíše ano' , 
		'2'  => 'ano' , 
		'4'  => 'technické ne') ,

        'date_format' => 'Y-m-d H:i:s' , );

/**
 * Enable debug mode. Display errors and profiler info.
 * Error messages can be set by variable $this->template->debug
 */
$config['debug_mode'] = TRUE;

$config['version'] = '2.011';

$config['ticket_url'] = 'http://raptor.webarchiv.cz:8000/trac/newticket?component=wa_admin&amp;milestone=WA Admin v2.02&amp;owner=brokes';
?>