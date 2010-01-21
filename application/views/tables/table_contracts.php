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

<?= table::header() ?>
<tr>
    <th class="first">Smlouva</th>
    <th>Zdroj</th>
    <th class="last">Vydavatel</th>
</tr>
<?php
foreach ($items as $contract)
{
    $resources = $contract->get_resources();
    foreach ($resources as $resource)
    { ?>
<tr>
    <td class="first">
        <?= html::anchor('tables/contracts/view/'.$contract->id, $contract) ?>
    </td>
    <td><?= html::anchor('tables/resources/view/'.$resource->id, $resource) ?></td>
    <td class="last"><?= html::anchor('tables/publishers/view/'.$resource->publisher_id, $resource->publisher) ?></td>
</tr>
        <?}
}
?>
</table>

<?= $pages ?>

</div>