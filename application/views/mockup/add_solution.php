<form action="" method="post" class="standardform" name="qa_form">
	<div><input name="__formo" value="qa_form" id="__formo" type="hidden"></div>
	<p><label>Název:</label><a
		href="http://localhost/wadmin/index.php/tables/resources/view/4383">@muni.cz
		: on-line verze měsíčníku Masarykovy univerzity</a></p>

	<p><label>URL:</label><a href="http://info.muni.cz" target="_blank">http://info.muni.cz</a></p>

	<p><label>Wayback:</label><a
		href="http://raptor.webarchiv.cz:8080/wayback_old/wexp/query?type=urlquery&amp;Submit=Take+Me+Back&amp;url=http://info.muni.cz"
		target="_blank">otevřít wayback</a></p>

	<p><label for="ticket_no">Trac ticket:</label><a
		href="http://localhost/wadmin/index.php/tables/resources/view/4383">#223</a></p>

	<h3>Problemy</h3>

	<div class="problem" id='multimedia'>
		<p><strong>Byla správně stažena multimédia?</strong></p>

		<p>You tube videa</p>
		<ul>
			<li><a
				href="http://har.webarchiv.cz:8080/AP1/20100224154229/http://www.nazabradli.cz/repertoar/repertoar/per-olov-enquist-blanche-a-marie/"
				target="_blank">http://har.webarchiv.cz:8080/AP1/20100224154229/http://www.nazabradli.cz/repertoar/repertoar/per-olov-enquist-blanche-a-marie/</a>
			</li>
		</ul>
		<div class="solution">
			<p><label>Řešení</label><input size="30"></input></p>

			<p><label>Komentář</label><textarea></textarea></p>
		</div>
	</div>
	<div class="problem">
		<p><strong>Bez jiných problémů?</strong></p>

		<p>Lišta s časovou osou zakrývá polovinu navigace; je možné řešení
			formou možnosti skrytí časové osy?</p>
		<ul></ul>
	</div>
	<p><label for="result">Výsledek kontroly:</label><select name="result"
															 id="result" class="input">
		<option value="1">v pořádku</option>
		<option value="0">akceptovatelné</option>
		<option value="-1" selected="selected">nevyhovující</option>
	</select></p>
	<p><label for="comments">Komentář:</label><textarea name="comments"
														id="comments" class="input" rows="4" style="width: 200px;">nezobrazují
		krátké zprávy, chybí starší odkazy ve stránkování dole na stránkách</textarea></p>

	<p><input name="save" value="Uložit" id="save" class="submit"
			  type="submit"></p>
</form>