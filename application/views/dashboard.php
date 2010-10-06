<div class="dashboard">Ahoj, máš
<ul>
	<li><a href='<?=url::base()?>rate#tabs-1'>zdroje k hodnocení: <?=$dashboard->to_rate ?></a></li>
	<li><a href='<?=url::base()?>rate#tabs-2'>zdroje k přehodnocení: <?=$dashboard->re_rate ?></a></li>
	<li><a href='<?=url::base()?>rate#tabs-3'>ohodnocené zdroje: <?=$dashboard->new_rated ?></a></li>
	<li><a href='<?=url::base()?>rate#tabs-4'>přehodnocené zdroje: <?=$dashboard->new_rerated ?></a></li>
	<li><a href='<?=url::base()?>addressing'>zdroje k oslovení: <?=$dashboard->to_address ?></a></li>
	<li><a href='<?=url::base()?>progress'>zdroje v jednání: <?=$dashboard->in_progress ?></a></li>
	<li><a href='<?=url::base()?>catalogue'>zdroje ke katalogizaci: <?=$dashboard->to_catalogue ?></a></li>
	<li><a href='<?=url::base()?>quality_control'>zdroje k QA: <?=$dashboard->to_qa ?></a></li>
	<li><a href='<?=url::base()?>conspectus'>nominované zdroje: <?=$dashboard->nominated ?></a></li>
	
</ul>
</div>