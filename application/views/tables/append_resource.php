<?php
// TODO refaktorovat!
if ($resource->publisher_id != '') {
    $publisher_url = url::site('tables/publishers/view/' . $resource->publisher_id);
    $publisher = "<a href='{$publisher_url}'>{$resource->publisher}</a>";
} else {
    $publisher_add = url::site("tables/resources/add_publisher/{$resource->id}");
    $publisher = "<a href='{$publisher_add}'>vytvořit</a>";
}
if ($resource->contact_id != '') {
    $contact_url = url::site('tables/contacts/view/' . $resource->contact_id);
    $contact = "<a href='{$contact_url}'>{$resource->contact}</a>";
} else {
    $contact_add = url::site("/tables/contacts/add/{$resource->publisher_id}/{$resource->id}");
    $contact = "<a href='{$contact_add}'>vytvořit</a>";
}
if ($resource->contract_id != '') {
    $contract_url = url::site('tables/contracts/view/' . $resource->contract_id);
    $replace_contract = html::anchor(url::site('/tables/contracts/replace_contract/' . $resource->id),
                                     icon::img('arrow_refresh', 'Vyměnit smlouvu'),
                                     array('class' => 'confirm'));
    $contract = "<a href='{$contract_url}'>{$resource->contract}</a> {$replace_contract}";
} else {
    $contract_add = url::site("progress/new_contract/{$resource->id}");
    $contract = "<a href='{$contract_add}'>vytvořit</a>";
}
echo "<h3 class='record-information'>Vydavatel: {$publisher}</h3>";
echo "<h3 class='record-information'>Kontakt: {$contact}</h3>";
echo "<h3 class='record-information'>Smlouva: {$contract}</h3>"; ?>
<hr/>


<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Hodnocení</a></li>
        <li><a href="#tabs-2">Semínka</a></li>
        <li><a href="#tabs-3">Významný vydavatel</a></li>
    </ul>
    <div id="tabs-1">
        <?php View::factory('tables/resources/ratings')->render(TRUE)?>
    </div>
    <div id="tabs-2">
        <?php View::factory('tables/resources/seeds')->render(TRUE)?>
    </div>
    <div id="tabs-3">
        <?php View::factory('tables/resources/nominations')->render(TRUE)?>
    </div>
</div>
