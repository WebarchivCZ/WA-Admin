<?
View::factory('forms/conspectus_filter')->set('form', $form)->render(TRUE);

if (isset($nominations) and $nominations->count() > 0)
{
	?>
	<?= table::header() ?>
<tr>
	<th class="first">Název</th>
	<th>Vydavatel</th>
	<th>URL</th>
	<th>ANO</th>
	<th class="last">NE</th>
</tr>

<?php
	foreach ($nominations as $nomination)
	{
		$resource = $nomination->resource;
		$publisher = $resource->publisher;
		$resource_title = html::anchor(url::site('/tables/resources/view/'.$resource->id), $resource->title);
		$publisher_title = html::anchor(url::site('/tables/publishers/view/'.$publisher->id), $publisher->short_name);
		$url_icon = html::anchor($resource->url, icon::img('link'), array('target' => '_blank'));
		$accept_icon = icon::img('tick', 'Potvrdit');
		$accept_link = html::anchor(url::site('/conspectus/accept/'.$resource->id), $accept_icon);
		$reject_icon = icon::img('cross', 'Zamítnout');
		$reject_link = html::anchor(url::site('/conspectus/reject/'.$resource->id), $reject_icon);
		echo "<tr>\n
				<td>{$resource_title}</td>\n
				<td>{$publisher_title}</td>\n
				<td class='center'>{$url_icon}</td>\n
				<td class='center'>{$accept_link}</td>\n
				<td class='center'>{$reject_link}</td>\n
			  </tr>\n";
	}

	echo table::footer();
} elseif (isset($nominations) and $nominations->count() == 0)
{
	echo "<h3>Nenalezen žádný zdroj</h3>\n";
}

if (isset($resources) and $resources->count() > 0)
{
	?>
	<?= table::header() ?>
<tr>
	<th class="first">Název</th>
	<th>Vydavatel</th>
	<th>Podkategorie</th>
	<th>Stav</th>
	<th class="last">Oslovení</th>
</tr>

<?php
	foreach ($resources as $resource)
	{
		$publisher = $resource->publisher;
		$resource_title = html::anchor(url::site('/tables/resources/view/'.$resource->id), $resource);
		$publisher_title = html::anchor(url::site('/tables/publishers/view/'.$publisher->id), $publisher->short_name);
		$correspondence = '';
		if (! $resource->has_contract())
		{
			$correspondence = $resource->print_correspondence();
		}
		echo "<tr>\n
				<td>{$resource_title}</td>\n
				<td>{$publisher_title}</td>\n
				<td>{$resource->conspectus_subcategory}</td>\n
				<td class='center'>{$resource->get_icon()}</td>\n
				<td class='center'>".$correspondence."</td>\n
			  </tr>\n";
	}

	echo table::footer();
} elseif (isset($resources) AND $resources->count() == 0)
{
	echo "<h3>Nenalezen žádný zdroj</h3>\n";
}

?>