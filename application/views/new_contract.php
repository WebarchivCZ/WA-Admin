<?php
if (isset ($blanko_contract)) {
    View::factory('tables/contracts/list_blanco_contract')
        ->bind('contract', $blanko_contract)
        ->render(TRUE);
}
else if (isset ($contracts) AND $contracts->count() > 0) {
    View::factory('tables/contracts/list_existing_contracts')
        ->bind('contracts', $contracts)
        ->render(TRUE);
} ?>
<h3>Přiřazení nové smlouvy ke zdroji</h3>
<?= $form ?>

<button onclick="history.back()">Zpět</button>