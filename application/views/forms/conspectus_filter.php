<?php
if (isset($form))
{
	if (isset($conspectus_table) AND $conspectus_table == TRUE)
	{
		$action_url = '/tables/conspectus_table/filter/';
	} else
	{
		$action_url = '/conspectus/filter/';
	}
	?>
<form method="POST" action="<?=url::site($action_url)?>"><input
	type='hidden' name='filter' value='true'/>

	<p>
		<?=$form ['conspectus']?>
		<?=$form ['conspectus_subcategory']?>
		<button class='floatright'>Filtrovat</button>
	</p>
</form>
<? } ?>