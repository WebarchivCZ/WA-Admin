<div class="top-bar">
    <h1><?= Kohana::lang('tables.'.$title) ?></h1>
    <div class="breadcrumbs"><a href="<?= url::base() ?>">Home</a> / <a href="<?= url::base().url::current() ?>"><?= Kohana::lang('tables.'.$title) ?></a></div>
</div>
<br />
<div class="select-bar">
    <form action="<?= $search_url ?>" method="GET">
        <label> <input type="text" name="search_string" /> </label>
        <label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
    </form>
</div>
<? View::factory('forms/conspectus_filter')->set(array('form' => $form, 'conspectus_table' => true))->render(TRUE); ?>
<?= table::header() ?>
<tr>
    <th class="first">Vydavatel</th>
    <th>Zdroj</th>
    <th>Kat</th>
    <th>Podkategorie</th>
    <th>Nominace</th>
    <th>Schválen</th>
    <th class="last">Stav</th>
</tr>
<?php
foreach ($items as $resource) {
	$publisher = $resource->publisher; ?>
<tr>
    <td class="first">
        <?= html::anchor('tables/resources/view/'.$resource->id, $resource) ?>
    </td>
    <td>
        <?= html::anchor('tables/publishers/view/'.$publisher->id, $publisher->short_name) ?>
    </td>
    <td><?= $resource->conspectus->id ?></td>
    <td><?= $resource->conspectus_subcategory ?></td>
    <td class="center"><?= $resource->get_nomination_icon() ?></td>
    <td class="center"><?= $resource->get_nomination_icon(true) ?></td>
    <td class="last center"><?= $resource->icon ?></td>
</tr>
        <?
}
?>
</table>

<?= $pages ?>

</div>