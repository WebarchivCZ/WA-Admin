<?php
if (isset($form)) { ?>
<form method="POST">
<input type='hidden' name='filter' value='true' />
<p>
    <?=$form['conspectus']?>
    <?=$form['conspectus_subcategory']?>
    <button class='floatright'>Filtrovat</button>
</p>
</form>
<? }

if (isset($nominations) AND $nominations->count() > 0) { ?>
	<?= table::header() ?>
	<tr>
		<th class="first">Název</th>
		<th>Vydavatel</th>
		<th>URL</th>
		<th>ANO</th>
		<th class="last">NE</th>
	</tr>
	
	<?php
	foreach ($nominations as $nomination) {
		$resource = $nomination->resource;
		$resource_title = html::anchor(url::site('/tables/resources/view/'.$resource->id), $resource->title);
		$url_icon = html::anchor($resource->url, icon::img('link'), array('target'=>'_blank'));
		$accept_icon = icon::img('tick', 'Potvrdit');
		$accept_link = html::anchor(url::site('/conspectus/accept/'.$resource->id), $accept_icon);
		$reject_icon = icon::img('cross', 'Zamítnout');
		$reject_link = html::anchor(url::site('/conspectus/reject/'.$resource->id), $reject_icon);
		echo "<tr>\n
				<td>{$resource_title}</td>\n
				<td>{$resource->publisher}</td>\n
				<td class='center'>{$url_icon}</td>\n
				<td class='center'>{$accept_link}</td>\n
				<td class='center'>{$reject_link}</td>\n
			  </tr>\n";
	}
	
	echo table::footer();
} else {
	echo "<h3>Nenalezen žádný zdroj</h3>\n";
}

?>