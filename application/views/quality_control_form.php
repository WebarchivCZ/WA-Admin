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
<form action="/wadmin/index.php/resource/insert" method="post" id="resource_form">
<input type="hidden" name="new_contract_no" value="1/2009"  />
<table class="form">
<tr>
<th><label for="title" >Název</label></th>

<td>
<input type="text" id="title" name="title" value="" class="textbox"  /></td>
</tr>
<tr>
<th><label for="url" >URL</label></th>
<td>
<input type="text" id="publisher" name="publisher" value="" class="textbox"  /></td>
</tr>
<tr>
<th><label for="url" >Sklizeno dne</label></th>
<td>
<input type="text" id="url" name="url" value="" class="textbox"  /></td>
</tr>
<tr>
<th><label for="url" >Kontrolováno dne</label></th>
<td>
<input type="text" id="url" name="url" value="" class="textbox"  /></td>
</tr>
<tr>
<th><label for="url" >Kontroloval</label></th>
<td>
<input type="text" id="url" name="url" value="" class="textbox"  /></td>
</tr>
<tr>
<th><label for="url" >Číslo ticketu</label></th>
<td>
<input type="text" id="url" name="url" value="" class="textbox"  /></td>
</tr>
<tr>
<th><label for="ISSN" >Byly stránky archivovány?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="archived" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="archived" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Byly staženy všechny části stránek?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="whole" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="whole" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Funguje správně navigace?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="navigation" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="navigation" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Byl správně stažen text?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="downloaded_text" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="downloaded_text" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Byly správně staženy obrázky?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="downloaded_images" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="downloaded_images" value="" class="textbox"  />
</td>
<td><a href="#" onClick='$("#comment3").toggle();'>komentář</a></td>
</tr>
<tr id="comment3" class="hidden">
	<td colspan="3"><textarea rows="2" cols="50" style="float: right;"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Byla správně stažena multimédia?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="downloaded_multimedia" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="downloaded_multimedia" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Stáhly se a zobrazují se CSS?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="downloaded_css" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="downloaded_css" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Lze downloadovat soubory?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="downloaded_files" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="downloaded_files" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>
<tr>
<th><label for="ISSN" >Jiné problémy?</label></th>
<td class="center">
<label>ANO</label><input type="radio" id="ISSN" name="other_problems" value="" class="textbox"  />
<label>NE</label><input type="radio" id="ISSN" name="other_problems" value="" class="textbox"  />
</td>
<td><a href="#" onClick="">komentář</a></td>
</tr>
<tr class="hidden" id="comment1">
	<td>&nbsp;</td>
	<td colspan="2"><textarea rows="2" cols="30"></textarea>
</tr>


<tr>
<th><label for="suggested_by" >Vysledek kontroly</label></th>
<td>
<select id="suggested_by" name="suggested_by" class="dropdown" >

<option value="1"></option>
<option value="2">v pořádku</option>
<option value="3">akceptovatelné</option>
<option value="4">nevyhovující</option>
</select></td>
</tr>
<tr>
	<td colspan="2" class="center"><br /><button type="submit">Uložit</button></td>
</tr>
</table>
</form>
