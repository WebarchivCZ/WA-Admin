<h3>Přeješ si vytvořit dodatek smlouvy nebo přiřadit zdroj k existující smlouvě?</h3>
<button id='assign_addendum_button'>Vytvořit dodatek</button>
</a>
<a href="<?= url::site("progress/assign_existing_contract/{$resource->id}/{$contract->id}/true/") ?>">
    <button>Přiřadit ke smlouvě</button>
</a>
<?=
View::factory('tables/contracts/form_assign_date_signed')
    ->set('resource_id', $resource->id)
    ->set('contract_id', $contract->id)
    ->set('is_blanco', FALSE)
    ->render(TRUE) ?>