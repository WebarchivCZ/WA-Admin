<?php if (isset($resources) AND $resources->count() != 0) {
    echo table::header();
    ?>
<tr>
    <th class="first">Zdroj</th>
    <th>Vydavatel</th>
    <th class="last">Vyměnit smlouvu</th>
</tr>
<?php foreach ($resources as $resource) {
        $resource_url = 'tables/resources/view/' . $resource->id;
        $publisher_url = 'tables/publishers/view/' . $resource->publisher->id;
        ?>
    <tr>
        <td><a href="<?= url::site($resource_url) ?>"><?= $resource->title ?></a></td>
        <td><a href="<?= url::site($publisher_url) ?>"><?= $resource->publisher ?></a></td>
        <td class="center">
            <?= html::anchor(url::site("/tables/contracts/replace_contract/{$resource->id}"),
                             icon::img('arrow_refresh', 'Přiřadit jinou smlouvu.'),
                             array('class' => 'confirm')) ?>
        </td>
    <?
    }
    echo table::footer();
} ?>