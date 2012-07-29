<h3>Přeješ si vytvořit novou smlouvu na základě blanco nebo přiřadit zdroj k existující blanco smlouvě?</h3>
<button id='assign_addendum_button'>Vytvořit novou smlouvu</button>
</a>
<a href="<?= url::site("progress/assign_existing_contract/{$resource->id}/{$contract->id}/true") ?>">
    <button>Přiřadit k blanco smlouvě</button>
</a>
<?=
View::factory('tables/contracts/form_assign_date_signed')
    ->set('resource_id', $resource->id)
    ->set('contract_id', $contract->id)
    ->set('is_blanco', TRUE)
    ->render(TRUE) ?>