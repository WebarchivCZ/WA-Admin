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
	<tr>
		<td class="first">Ikaros</td>
		<td><a href="http://www.ikaros.cz">http://www.ikaros.cz</a></td>
		<td>Coufal</td>
		<td>Knihovnictví</td>
		<td><select>
			<option></option>
			<option>Ne</option>
			<option>Spíše ne</option>
			<option>Možná</option>
			<option>Spíše ano</option>
			<option>Ano</option>
			<option>Technické ne</option>
		</select></td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td><a href=""><strong>ANO</strong></a></td>
	</tr>
	<tr>
		<td class="first">Národní knihovna ČR</td>
		<td><a href="http://www.ikaros.cz">http://www.nkp.cz</a></td>
		<td>Šíbek</td>
		<td>Knihovnictví</td>
		<td><select>
			<option></option>
			<option>Ne</option>
			<option>Spíše ne</option>
			<option>Možná</option>
			<option>Spíše ano</option>
			<option>Ano</option>
			<option>Technické ne</option>
		</select></td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="first">Otevřete.cz</td>
		<td><a href="http://www.ikaros.cz">http://www.otevrete.cz</a></td>
		<td>Gruber</td>
		<td>Filozofie</td>
		<td><select>
			<option></option>
			<option>Ne</option>
			<option>Spíše ne</option>
			<option>Možná</option>
			<option>Spíše ano</option>
			<option>Ano</option>
			<option>Technické ne</option>
		</select></td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td class="first">eCesty.cz</td>
		<td><a href="http://www.ikaros.cz">http://www.ecesty.cz</a></td>
		<td>Coufal</td>
		<td>Rekreace</td>
		<td><select>
			<option></option>
			<option>Ne</option>
			<option>Spíše ne</option>
			<option>Možná</option>
			<option>Spíše ano</option>
			<option>Ano</option>
			<option>Technické ne</option>
		</select></td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td class="center">
			<?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
		</td>
		<td><a href=""><strong>TECH. NE</strong></a></td>
	</tr>
</table>
<p class="center">
<button>Uložit hodnocení</button>
</p>
</div>