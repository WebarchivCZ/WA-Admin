<?php
if (!isset($contract)) {
    throw new WaAdmin_Exception('Contract ID is not set', 'ID of viewied contract is not set.');
}
$addendums = $contract->get_addendums();
if ($addendums->count() > 0) {
    echo '<h3 class="record-information">K této smlouvě přísluší tyto dodatky:</h3>';
    foreach ($addendums as $addendum) {
        View::factory('tables/contracts/list_resources')->bind('resources', $addendum->get_resources())->render(TRUE);
    }
}

if (isset($resources) AND $resources->count() != 0) {
    echo '<h3 class="record-information">Zdroje</h3>';
    View::factory('tables/contracts/list_resources')->bind('resources', $resources)->render(TRUE);
}