<div class="top-bar"><a href="#" class="button"><?= Kohana::lang('tables.add') ?></a>
	<h1><?= Kohana::lang('tables.'.$title) ?></h1>
	<div class="breadcrumbs"><a href="#">Homepage</a> / <a href="#">Contents</a></div>
</div>
<br />
<div class="select-bar">
	<form action="<?= url::base() ?>table/search">
		<label> <input type="text" name="textfield" /> </label>
		<label> <input type="submit" name="Submit" value="Search" /> </label>
	</form>
</div>
<div class="table">

<?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
<?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>


<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
	<?php
		array_push($headers, 'view', 'delete');
		echo display::display_headers($headers);
	?>
	</tr>
	<?php
	foreach ($items as $item)
	{
		echo '<tr>';
		foreach ($columns as $column)
		{
			if ($column->foreign_key) {
			$model = $column->name;
				$value = $item->$model->__toString();
				if ($column->isLink())
				{
					$id = $item->$model->id;
					$model = ucfirst($model);
					$value = "<a href='table/view/$model/$id'>".$value."</a>";
				}
			} else {
				$value = $item->__get($column->column);
			}
			echo "<td>$value</td>\n";
		}
		echo "<td>Zobrazit</td><td>Smazat</td>";
		echo '</tr>';
	}
	?>
</table>

<div class="select"><strong>Other Pages: </strong> <select>
	<option>1</option>
</select></div>
</div>
<div class="table"><img src="img/bg-th-left.gif" width="8" height="7"
	alt="" class="left" /> <img src="img/bg-th-right.gif" width="7"
	height="7" alt="" class="right" />
<table class="listing form" cellpadding="0" cellspacing="0">
	<tr>
		<th class="full" colspan="2">Header Here</th>
	</tr>
	<tr>
		<td class="first" width="172"><strong>Lorem Ipsum</strong></td>

		<td class="last"><input type="text" class="text" /></td>
	</tr>
	<tr class="bg">
		<td class="first"><strong>Lorem Ipsum</strong></td>
		<td class="last"><input type="text" class="text" /></td>
	</tr>
	<tr>
		<td class="first""><strong>Lorem Ipsum</strong></td>

		<td class="last"><input type="text" class="text" /></td>
	</tr>
	<tr class="bg">
		<td class="first"><strong>Lorem Ipsum</strong></td>
		<td class="last"><input type="text" class="text" /></td>
	</tr>
</table>
<p>&nbsp;</p>

</div>
