<?php
echo table::header();
if ($resource->has_nomination()) {
    $nomination = $resource->nomination;
    if ($resource->curator_id == $this->user->id) {
        $accept_icon = icon::img('tick', 'Potvrdit');
        $accept_link = html::anchor(url::site('/conspectus/accept/' . $resource->id), $accept_icon);
        $reject_icon = icon::img('cross', 'Zamítnout');
        $reject_link = html::anchor(url::site('/conspectus/reject/' . $resource->id), $reject_icon);
        ?>
<tr>
	<th class="first" width="45%">Název</th>
	<th>Stav nominace</th>
	<th>ANO</th>
	<th>NE</th>
	<th>Datum rozhodnutí</th>
	<th>Datum nominace</th>
	<th class="last">Nominoval</th>
</tr>
<tr>
	<td><?=$resource->title?></td>
	<td class="center"><?=$resource->get_nomination_icon(true)?></td>
	<td class="center"><?=$accept_link?></td>
	<td class="center"><?=$reject_link?></td>
	<td><?=$nomination->date_resolved?></td>
	<td><?=$nomination->date_nominated?></td>
	<td class="center"><?=$nomination->proposer?></td>
</tr>
<?php
    } else {
        ?>
<tr>
	<th class="first" width="45%">Název</th>
	<th>Stav nominace</th>
	<th>Datum rozhodnutí</th>
	<th>Datum nominace</th>
	<th class="last">Nominoval</th>
</tr>
<tr>
	<td><?=$resource->title?></td>
	<td class="center"><?=$resource->get_nomination_icon(true)?></td>
	<td><?=$nomination->date_resolved?></td>
	<td><?=$nomination->date_nominated?></td>
	<td class="center"><?=$nomination->proposer?></td>
</tr>
<?php
    }
} else {
    ?>
<tr>
	<th class="first">Název</th>
	<th class="last">Nominovat</th>
</tr>
<tr>
	<td><?=$resource->title?></td>
	<td class="center"><?=$resource->get_nomination_icon()?></td>
</tr>
<?php
}
echo table::footer();
?>

