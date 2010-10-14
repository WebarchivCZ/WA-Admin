<div class="dashboard">Ahoj, máš
<ul>
	<li><a href='<?=url::base()?>rate#tabs-1'><?=$dashboard->to_rate ?> - zdroje k hodnocení</a></li>
	<li><a href='<?=url::base()?>rate#tabs-2'><?=$dashboard->re_rate ?> - zdroje k přehodnocení</a></li>
	<li><a href='<?=url::base()?>rate#tabs-3'><?=$dashboard->new_rated ?> - ohodnocené zdroje</a></li>
	<li><a href='<?=url::base()?>rate#tabs-4'><?=$dashboard->new_rerated ?> - přehodnocené zdroje</a></li>
	<li><a href='<?=url::base()?>addressing'><?=$dashboard->to_address ?> - zdroje k oslovení</a></li>
	<li><a href='<?=url::base()?>progress'><?=$dashboard->in_progress ?> - zdroje v jednání</a></li>
	<li><a href='<?=url::base()?>catalogue'><?=$dashboard->to_catalogue ?> - zdroje ke katalogizaci</a></li>
	<li><a href='<?=url::base()?>quality_control'><?=$dashboard->to_qa ?> - zdroje k QA</a></li>
	<li><a href='<?=url::base()?>conspectus'><?=$dashboard->nominated ?> - nominované zdroje</a></li>
	
</ul>
</div>