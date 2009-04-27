<?php
$rating_result_array = Kohana::config('wadmin.ratings_result');
$rating_values_array = Kohana::config('wadmin.rating_values');
?>
<div class="top-bar">
	<h1>Hodnocení zdrojů</h1>
</div>
<br />
<div class="select-bar">
	<form action="<?= url::base().url::current() ?>/search/">
		<label> <input type="text" name="search_string" /> </label>
		<label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
	</form>
</div>
<div class="table">
<?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
<?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

<?php
if (isset($resources)) {
echo form::open(url::base(FALSE).url::current().'/save');
?>
<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
		<th class="first">Název</th>
		<th>URL</th>
		<th>Kurátor</th>
		<th>Konspekt</th>
		<th>Hodnocení</th>
		<th>Podobné</th>
		<th>Hod. ostatních</th>
		<th class="last">Výsledek</th>
	</tr>
<?php foreach ($resources as $resource) { ?>
<tr>
		<td class="first"><?=$resource->title ?></td>
		<td><a href="<?=$resource->url ?>"><?=$resource->url ?></a></td>
		<td><?=$resource->curator->username ?></td>
		<td><?=$resource->conspectus->category ?></td>
		<td>
			<?= form::dropdown("rating[$resource->id]", $rating_values_array, $ratings[$resource->id]); ?>
		</td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td>
			<?php if($resource->resource_status->status == 'ohodnocen') 
			{ 
				echo "<a href=''><strong>".$rating_result_array[$resource->rating_result].'</strong></a>'; 
			} ?>
		</td>
	</tr>
<?php }
}
?>
</table>
<p class="center">
<?=form::submit('submit', 'Uložit hodnocení') ?>
<?=form::close() ?>
</p>
</div>