<?php
$screenshot_array = Screenshot_Model::list_resource_screenshots($resource->id, TRUE);
?>
<div class="accordion">
	<h3><a href="#">Přidat screenshot</a></h3>

	<div class="tab-section">
		<form method="post" action="<?= url::site('/tables/resources/upload_screenshot/') ?>"
			  enctype="multipart/form-data" class="standardform">
			<p>
				<label for="screenshot_date">Datum pořízení:</label>
				<input type="text" name="screenshot_date" class="date_today" id="screenshot_date"
					   value="<?= date('d.m.Y') ?>"/>
			</p>

			<p>
				<label for="update_screenshot">Aktualizovat screenshot:</label>
				<input type="checkbox" id="update_screenshot" name="update_screenshot"/>
			</p>

			<p>
				<label>Vybrat soubor:</label>
				<input name="screenshot_file" type="file" class="button_file" accept="image/jpeg, image/png"/>
				<input name="resource_id" type="hidden" value="<?= $resource->id ?>"/>
			</p>

			<p class="center">
				<button>Nahrát screenshot</button>
			</p>
			<p><?= icon::img('information', 'Poznámka') ?> Screenshot bude zmenšen na velikost 800x600 pixelů (pro
				náhled
				120x80 pixelů). Je vhodné nahrávat
				obrázky s poměrem stran 4:3.</p>
		</form>
	</div>

	<?php

	if (count($screenshot_array) > 0)
	{
		$delete_icon = icon::img('delete', 'Smazat screenshot');
		$select_icon = icon::img('tick', 'Vybrat screenshot');
		echo '<h3><a href="#uploaded-screenshots">Již vložené screenshoty</a></h3><div class="tab-section gallery">';
		foreach ($screenshot_array as $screenshot)
		{
			$select_url = "/tables/resources/select_screenshot/{$resource->id}/{$screenshot->get_datetime()}";

			echo "<div class='img'>
                <a href='{$screenshot->get_screenshot()}'  class='thumbnail'>
                    <img src='{$screenshot->get_thumbnail()}' class='thumbnail' alt='{$screenshot->get_datetime()}'/>
                </a>
                <div class='desc'>".
				html::anchor(url::site($select_url), $select_icon)
				."</div>
              </div>";
		}
		echo '<div class=\'clear\'></div>
          </div>';
	}
	?>
</div>