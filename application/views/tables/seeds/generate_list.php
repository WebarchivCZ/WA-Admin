<?php
// zobrazeni seminek (v novem okne a bez sablony)
if (isset($seedlist) AND $seedlist->count() > 0)
{
	echo "#Seedlist generated: ".date('d.m.Y H:i')."<br />\n";
	echo "#Seeds count: ".$seedlist->count()."<br />\n";
	$output = '<table>';
	foreach ($seedlist as $seed)
	{
		$output .= "<tr><td>{$seed->url}</td></tr>";
	}
	$output .= '</table>';

	echo $output;
}
// zobrazeni zdroju
else if (isset($resources) AND $resources->count() > 0)
{
	$output = "<button onclick='window.history.back()'>Zpět</button>";
	$output .= table::header();
	$output .= "<tr><th class='first'>Zdroj</th><th class='last'>Kurátor</th>";
	foreach ($resources as $resource)
	{
		$resource_link = html::anchor(url::site('/tables/resources/view/'.$resource->id), $resource->title);
		$output .= "<tr><td>{$resource_link}</td><td>{$resource->curator}</td></tr>";
	}
	$output .= table::footer();
	echo $output;
}
// formular
else
{
	$crawl_freq_array = ORM::factory('crawl_freq')->select_list('id', 'frequency');
	$crawl_freq_array['null'] = 'bez frekvence';
	echo '<h2>Vygenerovat seznam semínek a zdrojů</h2>';
	echo form::open();
	echo form::dropdown('crawl_freq_id', $crawl_freq_array);
	echo form::submit('get_seeds', 'Vygenerovat SEMÍNKA', 'class=send_new_window');
	echo form::submit('send', 'Vygenerovat ZDROJE');
	echo "<br/>".form::submit('get_archive_it', 'Archive-IT',
		'class=send_new_window title="Seminka s malou frekvecni sklizeni (1x, 2x rocne) a jednorazove za uplynuly mesic"');
	echo form::close();
}
?>
