<?php
if (!isset($contract)) {
    throw new WaAdmin_Exception('Contract ID is not set', 'ID of viewied contract is not set.');
}
if (isset($resources) AND $resources->count() != 0) {
    echo '<h3 class="record-information">Zdroje</h3>';
    View::factory('tables/contracts/list_resources')->bind('resources', $resources)->render(TRUE);
}
$addendums = $contract->get_addendums();
if ($addendums->count() > 0) {
    if ($contract->is_blanco()) {
        $addendum_message = 'K blanco smlouvě přísluší tyto smlouvy:';
    } else {
        $addendum_message = 'K této smlouvě přísluší tyto dodatky:';
    }
    echo "<h3 class='record-information'>{$addendum_message}</h3>";
    foreach ($addendums as $addendum) {
        View::factory('tables/contracts/list_resources')->bind('resources', $addendum->get_resources())->render(TRUE);
    }
}