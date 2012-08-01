<div class="top-bar">
	<h1><?= Kohana::lang('tables.'.$title) ?></h1>

	<div class="breadcrumbs"><a href="<?= url::base() ?>">Home</a> / <a
		href="<?= url::base().url::current() ?>"><?= Kohana::lang('tables.'.$title) ?></a></div>
</div>
<br/>
<div class="select-bar">
	<form action="<?= $search_url ?>" method="GET">
		<label> <input type="text" name="search_string"/> </label>
		<label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>"/> </label>
	</form>
</div>
<div class="table">

	<?= html::image(array('src'   => 'media/img/bg-th-left.gif',
						  'width' => '8',
						  'height'=> '7',
						  'class' => 'left')) ?>
	<?= html::image(array('src'   => 'media/img/bg-th-right.gif',
						  'width' => '7',
						  'height'=> '7',
						  'class' => 'right')) ?>


	<table class="listing" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first">Zdroj</th>
			<th>1. oslovení</th>
			<th>2. oslovení</th>
			<th>3. oslovení</th>
			<th class="last">Stav zdroje</th>
		</tr>
		<?php
		foreach ($items as $resource)
		{

			?>
			<tr>
				<td class="first">
					<?= html::anchor('tables/resources/view/'.$resource->id, $resource,
					array('target'=> '_parent')) ?>
				</td>
				<?php
				for ($i = 1; $i <= 3; $i ++)
				{
					$correspondence = $resource->get_correspondence($i);
					$href = url::site('/tables/correspondence/edit/'.$correspondence->id);
					$content = html::anchor($href, $correspondence->date);
					echo "<td>{$content}</td>";
				}
				?>
				<td class="last"><?= $resource->resource_status ?></td>
			</tr>
			<?php } ?>
	</table>

	<?= $pages ?>

</div>