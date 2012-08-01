<?php echo table::header(); ?>
<tr>
	<th class="first">Zdroj</th>
	<th class="last">Vydavatel</th>
</tr>
<?php foreach ($resources as $resource)
{
	$resource_url = 'tables/resources/view/'.$resource->id;
	$publisher_url = 'tables/publishers/view/'.$resource->publisher->id;
	?>
<tr>
	<td><a href="<?= url::site($resource_url) ?>"><?= $resource->title ?></a></td>
	<td><a href="<?= url::site($publisher_url) ?>"><?= $resource->publisher ?></a></td>
</tr>
<?
}
echo table::footer();
?>