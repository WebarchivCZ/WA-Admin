<h3>Přiřazení <em>blanko</em> smlouvy ke zdroji</h3>
<?= table::header() ?>
        <tr>
            <th class="first">Smlouva</th>
            <th class="last">Blanko domény</th>
        </tr>

            <tr>
                <td class="first contract-name">
                     <?= html::anchor("progress/assign_existing_contract/{$resource_id}/{$contract->id}",
                    $contract) ?>
                </td>
                <td class="last">
                    <?= $contract->domain; ?>
                </td>
            </tr>
<?= table::footer() ?>