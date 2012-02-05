<h3>Přeješ si vytvořit dodatek smlouvy nebo přiřadit zdroj k existující smlouvě.</h3>
<button id='assign_addendum_button'>Vytvořit dodatek</button>
</a>
<a href="">
    <button>Přiřadit ke smlouvě</button>
</a>
<div id="assign_addendum_dialog" title="Přiřadit datum podpisu">

    <form id="addendum_form"
          action="<?= url::site("progress/assign_addendum/{$resource->id}/{$contract->id}") ?>"
          method="post">
        <label for="date_signed">Datum podpisu</label>
        <input type="text" name="date_signed" id="date_signed"/>
    </form>
</div>