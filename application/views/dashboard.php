<div class="dashboard">Ahoj, máš:
<ul>
	<li><a href='<?=url::base()?>rate'><?=$dashboard->to_rate ?> zdrojů k hodnocení</a></li>
	<li><a href='<?=url::base()?>rate'><?=$dashboard->new_rated ?> nově hodnocené</a></li>
	<li><a href='<?=url::base()?>rate'><?=$dashboard->re_rate ?> zdroje k přehodnocení</a></li>
	<li><a href='<?=url::base()?>catalogue'><?=$dashboard->to_catalogue ?> zdroje ke katalogizaci</a></li>
	<li><a href='<?=url::base()?>addressing'><?=$dashboard->to_address ?> zdroje k oslovení</a></li>
	<li><a href='<?=url::base()?>addressing'><?=$dashboard->no_response ?> zdroj bez odezvy</a></li>
</ul>
</div>