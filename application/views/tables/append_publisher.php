<?php if (isset($resources) AND $resources->count() != 0)
{
	?>

	<?=
	table::header()
	; ?>
<tr>
	<th class="first" width="40%">Zdroj</th>
	<th width="4%">&nbsp;</th>
	<th>Kontakt</th>
	<th>1. oslovení</th>
	<th>2. oslovení</th>
	<th class="last">3. oslovení</th>
</tr>
<?php foreach ($resources as $resource)
{
	$resource_url = 'tables/resources/view/'.$resource->id;
	$contact_url = 'tables/contacts/view/'.$resource->contact->id;
	$resource_icon = $resource->get_icon();
	?>
        <tr>
            <td class="first">
					<?= html::anchor(url::site($resource_url), $resource->title) ?></a></td>
	<td><?= $resource_icon ?></td>
	<td><a href="<?= url::site($contact_url) ?>"><?= $resource->contact ?></a></td>
	<td><?= $resource->get_correspondence(1)->date ;?></td>
	<td><?= $resource->get_correspondence(2)->date ;?></td>
	<td class="last"><?= $resource->get_correspondence(3)->date ;?></td>
	<? } ?>
	<?=
	table::footer()
	; ?>
<? } ?>