<div class="top-bar" id ="solo">
    <h1>Smazat - <?= $publisher->name ?></h1>
</div>
<?php
echo table::header();
echo '<tr><th class="first" width="75%">Zdroj</th><th class="last">Odstranit propojení</th></tr>';
if (isset($resources) AND $resources->count() > 0)
{
	$delete_icon = icon::img('delete', 'Odstranit propojení vydavatele a zdroje.');
	foreach ($resources as $resource) {
		$delete_url = url::site('/tables/publishers/remove_from_resource/'.$resource->id);
		$resource_title = html::anchor(url::site('/tables/resources/view/'.$resource->id),$resource->title);
		echo "<tr>
				<td>{$resource_title}</td>
				<td class='center'><a href='{$delete_url}' class='remove_from_resource_conf'>{$delete_icon}</a></td>
			  </tr>";
	}	
}

echo table::footer();

$delete_url = url::site('/tables/publishers/erase/'.$publisher->id);
?>
<div class="center">
	<a href="<?= $delete_url ?>" class="delete_publisher_conf"><button>Smazat vydavatele</button></a>
</div>