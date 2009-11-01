<div class="dashboard">Ahoj, máš:
<ul>
	<li><a href='<?=url::base()?>rate'>Zdrojů k hodnocení: <?=$dashboard->to_rate ?></a></li>
	<li><a href='<?=url::base()?>rate'>Ohodnocené zdroje: <?=$dashboard->new_rated ?></a></li>
	<li><a href='<?=url::base()?>rate'>Zdroje k přehodnocení: <?=$dashboard->re_rate ?></a></li>
	<li><a href='<?=url::base()?>catalogue'>Zdroje ke katalogizaci: <?=$dashboard->to_catalogue ?></a></li>
	<li><a href='<?=url::base()?>addressing'>Zdroje k oslovení: <?=$dashboard->to_address ?></a></li>
	<!--<li><a href='<?=url::base()?>addressing'>Zdroj bez odezvy: <?=$dashboard->no_response ?></a></li>-->
</ul>
</div>