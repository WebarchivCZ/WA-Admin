<?php

if (isset($contract)) {
    $addendums = $contract->get_addendums();
    if ($addendums->count() > 0) {
        echo "<h3>Smlouva má tyto dodatky:</h3>";
        foreach ($addendums as $addendum) {
            $date_signed = date_helper::short_date($addendum->date_signed);
            $link_text = "Dodatek podepsaný {$date_signed}";
            $link_url = url::site('tables/contracts/view/' . $addendum->id);
            echo html::anchor($link_url, $link_text);
        }
    }
}
if (isset($resources) AND $resources->count() != 0) {
    echo table::header();
    ?>
<tr>
    <th class="first">Zdroj</th>
    <th class="last">Vydavatel</th>
</tr>
<?php foreach ($resources as $resource) {
        $resource_url = 'tables/resources/view/' . $resource->id;
        $publisher_url = 'tables/publishers/view/' . $resource->publisher->id;
        ?>
    <tr>
        <td><a href="<?= url::site($resource_url) ?>"><?= $resource->title ?></a></td>
        <td><a href="<?= url::site($publisher_url) ?>"><?= $resource->publisher ?></a></td>
    <?
    }
    echo table::footer();
} ?>