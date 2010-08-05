<?php if (isset($resources) AND $resources->count() != 0) { ?>

<?= table::header(); ?>
        <tr>
            <th class="first" width="40%">Zdroj</th>
            <th width="4%">&nbsp;</th>
            <th>Kontakt</th>
            <th>1. oslovení</th>
            <th>2. oslovení</th>
            <th class="last">3. oslovení</th>
        </tr>
<?php foreach ($resources as $resource) {
        $resource_url = 'tables/resources/view/'.$resource->id;
        $contact_url = 'tables/contacts/view/'.$resource->contact->id;
        $resource_icon = '';
        if ($resource->has_contract()) {
        	$resource_icon = icon::img('page', 'Zdroj má smlouvu.');
        } else {
            $status = $resource->resource_status_id;
            switch ($status) {
            	case RS_NEW:
            	case RS_CONTACTED:
            	case RS_APPROVED_WA:
            		$resource_icon = icon::img('tick', 'Zdroj byl schválen, osloven nebo je nový.');
            		break;
            	case RS_REJECTED_PUB:
            	case RS_NO_RESPONSE:
            		$resource_icon = icon::img('status_busy', 'Zdroj byl odmítnut vydavatelem nebo je bez odezvy.');
            		break;
            	case RS_REJECTED_WA:
            		$resource_icon = icon::img('cross', 'Zdroj byl odmítnut WA.');
            }
        }
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
<?= table::footer(); ?>
<? } ?>