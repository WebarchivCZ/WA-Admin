<h2></h2>

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
		<th class="last">Komentář</th>
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
		<td>vydávání ukončeno</td>
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
		<td></td>
	</tr>
</table>
<p class="center">
<button>Uložit hodnocení</button> &nbsp; &nbsp; <button>Reset</button>
</p>
</div>