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
			<th>Datum</th>
			<th>Markéta Hrdličková</th>
			<th>Libor Coufal</th>
			<th>Lukáš Gruber</th>
			<th>Pavla Kupcová</th>
			<th class="last">Tomáš Šíbek</th>
		</tr>
		<?php
		foreach ($items as $resource)
		{
			for ($round = 1; $round <= 2; $round ++)
			{
				if ($resource->has_rating($round))
				{
					?>
					<tr>
						<td class="first">
							<?= html::anchor('tables/resources/view/'.$resource->id, $resource) ?>
						</td>
						<td class="center"><?= $resource->get_ratings_date($round) ?></td>
						<td class="center"><?= display::rating($resource, 'hrdlickova', $round, true) ?></td>
						<td class="center"><?= display::rating($resource, 'coufal', $round, true) ?></td>
						<td class="center"><?= display::rating($resource, 'gruber', $round, true) ?></td>
						<td class="center"><?= display::rating($resource, 'kupcova', $round, true) ?></td>
						<td class="last center"><?= display::rating($resource, 'sibek', $round, true) ?></td>
					</tr>
					<?
				}
			}
		} ?>
	</table>

	<?= $pages ?>

</div>