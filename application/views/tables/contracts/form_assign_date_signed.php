<?php
if ($is_blanco === TRUE) {
    $dialog_id = 'assign_blanco_dialog';
} else {
    $dialog_id = 'assign_addendum_dialog';
}
?>
<div class="assign_contract_dialog" id="<?= $dialog_id ?>" title="Přiřadit datum podpisu" style="display: none;">
    <form id="addendum_form"
          action="<?= url::site("progress/assign_addendum/{$resource_id}/{$contract_id}/") ?>"
          method="post">
        <label for="date_signed">Datum podpisu:</label>
        <input type="text" name="date_signed" id="date_signed"/>
    </form>
</div>