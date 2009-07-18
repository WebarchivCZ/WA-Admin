<?php

$message = Session::instance()->get('message');
if ($message != '') {
    echo "<h4>{$message}</h4>";
}

if ($type == 'view') {
    echo "<h3>Zobrazení záznamu</h3>";
    echo "<a href='{$edit_url}'>Klikni pro editaci záznamu</a>";
} elseif ($type == 'edit') {
    echo "<h3>Editace záznamu</h3>";
} elseif($type == 'delete') {
    echo "<h3>Opravdu chcete smazat zaznam?</h3>";
} elseif ($type == 'add') {
    echo "<h3>Pridani zaznamu</h3>";
}
if (isset($form)) {
	echo $form;
}
?>