<?php

$message = Session::instance()->get('message');
if ($message != '') {
    echo "<h4>{$message}</h4>";
}

if ($type == 'view') {
    echo "<h3>Zobrazení záznamu</h3>";
    echo "<a href='{$edit_url}'><button>Klikni pro editaci záznamu</button></a>";
} elseif ($type == 'edit') {
    echo "<h2>Editace záznamu</h2>";
} elseif($type == 'delete') {
    echo "<h3>Opravdu chcete smazat zaznam?</h3>";
} elseif ($type == 'add') {
    echo "<h3>Pridani zaznamu</h3>";
}
if (isset($form)) {
	echo $form;
}
?>