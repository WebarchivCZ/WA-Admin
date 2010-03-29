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

        'date_format' => 'Y-m-d H:i:s' ,

        'short_date_format' => 'd.m.Y',

        'title_length' => 35);

$config['wayback_url'] = 'http://raptor.webarchiv.cz:8080/wayback_old/wexp/query?type=urlquery&Submit=Take+Me+Back&url=';

/**
 * Enable debug mode. Display errors and profiler info.
 * Error messages can be set by variable $this->template->debug
 */
$config['debug_mode'] = TRUE;

$config['version'] = '2.2';

$config['build'] = '01';

$config['ticket_url'] = 'http://raptor.webarchiv.cz:8000/trac/newticket?component=wa_admin&amp;milestone=WA Admin v2.2&amp;owner=brokes';
?>