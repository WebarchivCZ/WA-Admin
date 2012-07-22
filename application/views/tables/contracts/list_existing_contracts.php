<h3>Přiřazení existující smlouvy ke zdroji</h3>
<?= table::header() ?>
<tr>
    <th class="first">Smlouva</th>
    <th class>Vydavatel</th>
    <th class="last">Komentář</th>
</tr>
<?php foreach ($contracts as $contract) {
    $contract = new Contract_Model($contract->id);
    ?>
<tr>
    <td class="first contract-name">
        <?= html::anchor("progress/assign_existing_contract/{$resource_id}/{$contract->id}", $contract->contract_title) ?>
    </td>
    <td>
        <?= $contract->publisher ?>
    </td>
    <td class="last">
        <?= $contract->comments ?>
    </td>
</tr>
<? } ?>
<?= table::footer() ?>