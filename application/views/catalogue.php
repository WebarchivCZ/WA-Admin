<?php
if (isset($resources)) {
?>


<div class="table">
<?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
<?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

    <table class="listing" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">Název</th>
		<th>URL</th>
		<th>Zkatalogizováno</th>
		<th class="last">Metadata</th>
	</tr>
        <?php
        foreach ($resources as $resource) {
        ?>
	<tr>
		<td class="first"><?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?></td>
		<td><a href="<?=$resource->url ?>"><?=$resource->url ?></a></td>
		<td class="center">
                    <?php
                        if($resource->catalogued == NULL) {
                            $url = url::site(url::current()).'/save/catalogued/'.$resource->id;
                            echo html::anchor($url, icon::img('pencil', 'Zaznamenat katalogizaci'));
                        } else {
                            echo icon::img('tick', $resource->catalogued);
                        }
                    ?>
		</td>
		<td class="center">
			<?php
                        if($resource->metadata == NULL) {
                            $url = url::site(url::current()).'/save/metadata/'.$resource->id;
                            echo html::anchor($url, icon::img('pencil', 'Zaznamenat tvorbu metadat'));
                        } else {
                            echo icon::img('tick', $resource->metadata);
                        }
                    ?>
		</td>
	</tr>
        <?php } ?>
</table>
<p class="center">
<button>Zobrazit všechny zdroje ke katalogizaci</button>
</p>
</div>
<?php } ?>