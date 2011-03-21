<h3>Přiřazení existující smlouvy ke zdroji</h3>
<?= table::header() ?>
        <tr>
            <th class="first">Zdroj</th>
            <th>Vydavatel</th>
            <th class="last">Smlouva</th>
        </tr>
        <?php foreach ($contracts as $contract)
    {
        foreach ($contract->get_resources() as $resource)
        {
            ?>
            <tr>
                <td class="first">
                    <?= html::anchor('tables/resources/view/' . $resource->id, $resource->title) ?>
                </td>
                <td>
                    <?= html::anchor('tables/publishers/view/' . $resource->publisher_id, $resource->publisher) ?>
                </td>
                <td class="last contract-name">
                    <?= html::anchor("progress/assign_existing_contract/{$resource_id}/{$contract->id}",
                    $resource->contract) ?>
                </td>
            </tr>
            <? } ?>
        <? } ?>
<?= table::footer() ?>