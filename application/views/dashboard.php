<div class="dashboard">Ahoj, máš:
<table>
	<tr>
		<td><a href='<?=url::base()?>addressing'>zdroje k oslovení</a></td>
		<td><a href='<?=url::base()?>addressing'><?=$dashboard->to_address?></a></td>
	
	</tr>
	<tr>
		<td><a href='<?=url::base()?>catalogue'>zdroje ke katalogizaci</a></td>
		<td><a href='<?=url::base()?>catalogue'><?=$dashboard->to_catalogue?></a></td>
	
	</tr>
	<tr>
		<td><a href='<?=url::base()?>quality_control'>zdroje k QA</a></td>
		<td><a href='<?=url::base()?>quality_control'><?=$dashboard->to_qa?></a></td>
	
	</tr>
	<tr>
		<td colspan="2" class="show-all"><a href='#' id='show-all'>zobrazit vše</a></td>
	
	</tr>
	<tr class="hidden">
		<td><a href='<?=url::base()?>rate#tabs-1'>zdroje k hodnocení</a></td>
		<td><a href='<?=url::base()?>rate#tabs-1'><?=$dashboard->to_rate?></a></td>
	
	</tr>
	<tr class="hidden">
		<td><a href='<?=url::base()?>rate#tabs-2'>zdroje k přehodnocení</a></td>
		<td><a href='<?=url::base()?>rate#tabs-2'><?=$dashboard->re_rate?></a></td>
	
	</tr>
	<tr class="hidden">
		<td><a href='<?=url::base()?>rate#tabs-3'>ohodnocené zdroje</a></td>
		<td><a href='<?=url::base()?>rate#tabs-3'><?=$dashboard->new_rated?></a></td>
	
	</tr>
	<tr class="hidden">
		<td><a href='<?=url::base()?>rate#tabs-4'>přehodnocené zdroje</a></td>
		<td><a href='<?=url::base()?>rate#tabs-4'><?=$dashboard->new_rerated?></a></td>
	
	</tr>
	<tr class="hidden">
		<td><a href='<?=url::base()?>progress'>zdroje v jednání</a></td>
		<td><a href='<?=url::base()?>progress'><?=$dashboard->in_progress?></a></td>
	
	</tr>
	<tr class="hidden">
		<td><a href='<?=url::base()?>conspectus'>nominované zdroje</a></td>
		<td><a href='<?=url::base()?>conspectus'><?=$dashboard->nominated?></a></td>
	
	</tr>

</table>
</div>