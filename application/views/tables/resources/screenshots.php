<?php
$screenshot_array = Screenshot_Model::list_resource_screenshots($resource->id, true);
?>

<h3>Přidat screenshot</h3>
<form method="post" action="<?= url::site('/tables/resources/upload_screenshot/') ?>" enctype="multipart/form-data">
    <p>
        <input name="screenshot_file" type="file" class="button_file" accept="image/jpeg, image/png"/>
        <input name="resource_id" type="hidden" value="<?= $resource->id ?>"/>
    </p>

    <p>
        <label for="screenshot_date">Datum pořízení:</label>
        <input type="text" name="screenshot_date" class="date_today" id="screenshot_date" value="<?= date('d.m.Y') ?>"/>
        <button>Nahrát screenshot</button>
    </p>
</form>

<?php

if (count($screenshot_array) > 0) {
    echo '<h3>Již vložené screenshoty</h3>
            <ul>';
    foreach ($screenshot_array as $screenshot) {
        echo "<li>
                <a href='{$screenshot->get_screenshot()}'  class='thumbnail'>
                    <img src='{$screenshot->get_thumbnail()}' class='thumbnail' />
                </a>
              </li>";
    }
    echo "</ul>";
}
?>



