<div class="top-bar"><a href="#" class="button"><?= Kohana::lang('tables.add') ?></a>
<h1><?= Kohana::lang('tables.'.$model) ?></h1>
<div class="breadcrumbs"><a href="#">Homepage</a> / <a href="#">Contents</a></div>
</div>
<br />
<div class="select-bar"><label> <input type="text" name="textfield" /> </label>

<label> <input type="submit" name="Submit" value="Search" /> </label></div>
<div class="table">

<?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
<?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>


<table class="listing" cellpadding="0" cellspacing="0">
	<tr>
	<?php
	echo display::display_headers($headers);
	?>
	</tr>
	<?php
	foreach ($items as $item)
	{
		echo '<tr>';
		foreach ($headers as $column)
		{
			$value = $item->__get($column);
			echo "<td>$value</td>\n";
		}
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
