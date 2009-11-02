<div class="dashboard">Ahoj, máš
<ul>
	<li><a href='<?=url::base()?>rate'>zdrojů k hodnocení: <?=$dashboard->to_rate ?></a></li>
	<li><a href='<?=url::base()?>rate'>ohodnocené zdroje: <?=$dashboard->new_rated ?></a></li>
	<li><a href='<?=url::base()?>rate'>zdroje k přehodnocení: <?=$dashboard->re_rate ?></a></li>
	<li><a href='<?=url::base()?>catalogue'>zdroje ke katalogizaci: <?=$dashboard->to_catalogue ?></a></li>
	<li><a href='<?=url::base()?>addressing'>zdroje k oslovení: <?=$dashboard->to_address ?></a></li>
	<!--<li><a href='<?=url::base()?>addressing'>Zdroj bez odezvy: <?=$dashboard->no_response ?></a></li>-->
</ul>
</div>