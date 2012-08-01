<?php
if (isset($resources) AND $resources->count() != 0)
{
	echo table::header();
	?>
<tr>
	<th class="first">Název</th>
	<th>URL</th>
	<th>Kontakt</th>
	<th>Smlouva</th>
	<th>Odmítnuto</th>
	<th class="last">Bez odezvy</th>
</tr>
<?php
	foreach ($resources as $resource)
	{
		?>
	<tr>
		<td class="first">
			<?= html::anchor('tables/resources/view/'.$resource->id, $resource) ?>
		</td>
		<td class="center">
			<a href='<?= $resource->url ?>' target="_blank"><?= icon::img('link', $resource->url) ?></a>
		</td>
		<td width="14%">
			<?php
			echo $resource->print_correspondence();
			?>

		</td>
		<td class='center'>
			<?= html::anchor(url::current().'/new_contract/'.$resource->id, icon::img('pencil', 'Přiřadit novou smlouvu')) ?>
		</td>
		<td class='center'>
			<?= html::anchor(url::current().'/reject/publisher/'.$resource->id, icon::img('cross', 'Zdroj byl odmítnut vydavatelem')) ?>
		</td>
		<td class='center'>
			<?= html::anchor(url::current().'/reject/no_response/'.$resource->id, icon::img('cross', 'Oslovení vydavatele je bez odezvy (x měsíců)')) ?>
		</td>
	</tr>

	<?
	}
	echo table::footer();
} else
{
	echo '<p>Nebyly nalezeny žádné zdroje v jednání.</p>';
} ?>