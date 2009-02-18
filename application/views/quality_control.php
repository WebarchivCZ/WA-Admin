<div class="top-bar">
	<h1>Kontrola kvality</h1>
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
		<th>Výsledek</th>
		<th>Datum</th>
		<th class="last">Kdo</th>
	</tr>
	<tr>
		<td class="first">Ikaros</td>
		<td><a href="http://www.ikaros.cz">http://www.ikaros.cz</a></td>
		<td>
			<select name="">
				<option></option>
				<option>V pořádku</option>
				<option>Akceptovatelné</option>
				<option>Nevyhovující</option>
			</select>
		</td>
		<td>18.1.2009</td>
		<td><a href="">Coufal</a></td>
	</tr>
	<tr>
		<td class="first">Národní knihovna ČR</td>
		<td><a href="http://www.ikaros.cz">http://www.nkp.cz</a></td>
		<td>
			<select name="">
				<option></option>
				<option>V pořádku</option>
				<option>Akceptovatelné</option>
				<option>Nevyhovující</option>
			</select>
		</td>
		<td>19.1.2009</td>
		<td><a href="">Gruber</a></td>
	</tr>
	<tr>
		<td class="first">Otevřete.cz</td>
		<td><a href="http://www.ikaros.cz">http://www.otevrete.cz</a></td>
		<td>
			<select name="">
				<option></option>
				<option>V pořádku</option>
				<option>Akceptovatelné</option>
				<option>Nevyhovující</option>
			</select>
		</td>
		<td>19.1.2009</td>
		<td><a href="">Šíbek</a></td>
	</tr>
	<tr>
		<td class="first">eCesty.cz</td>
		<td><a href="http://www.ikaros.cz">http://www.ecesty.cz</a></td>
		<td>
			<select name="">
				<option></option>
				<option>V pořádku</option>
				<option>Akceptovatelné</option>
				<option>Nevyhovující</option>
			</select>
		</td>
		<td>21.1.2009</td>
		<td><a href="">Šíbek</a></td>
	</tr>
</table>
<p class="center">
<button>Zobrazit vše</button>
</p>
</div>