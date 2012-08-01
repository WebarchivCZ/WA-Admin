<?php
// TODO refaktorovat!
if ($resource->publisher_id != '')
{
	$publisher_url = url::site('tables/publishers/view/'.$resource->publisher_id);
	$publisher = "<a href='{$publisher_url}'>{$resource->publisher}</a>";
} else
{
	$publisher_add = url::site("tables/resources/add_publisher/{$resource->id}");
	$publisher = "<a href='{$publisher_add}'>vytvořit</a>";
}
if ($resource->contact_id != '')
{
	$contact_url = url::site('tables/contacts/view/'.$resource->contact_id);
	$contact = "<a href='{$contact_url}'>{$resource->contact}</a>";
} else
{
	$contact_add = url::site("/tables/contacts/add/{$resource->publisher_id}/{$resource->id}");
	$contact = "<a href='{$contact_add}'>vytvořit</a>";
}
if ($resource->contract_id != '')
{
	$contract_url = url::site('tables/contracts/view/'.$resource->contract_id);
	$contract = "<a href='{$contract_url}'>{$resource->contract}</a> ";
	if (Auth::instance()->logged_in('admin'))
	{
		$contract .= html::anchor(url::site('/progress/new_contract/'.$resource->id),
			icon::img('arrow_refresh', 'Vyměnit smlouvu'),
			array('class' => 'confirm'));
	}
} else
{
	$contract_add = url::site("progress/new_contract/{$resource->id}");
	$contract = "<a href='{$contract_add}'>vytvořit</a>";
}

$screenshot = $resource->get_screenshot();
if ($screenshot->exists())
{
	echo "<a href='{$screenshot->get_screenshot()}'  class='thumbnail'>
            <img src='{$screenshot->get_thumbnail()}' class='thumbnail' style='float:right;'/>
      </a>";
}

echo "<h3 class='record-information' style='clear:left;'>Vydavatel: {$publisher}</h3>";
echo "<h3 class='record-information' style='clear:left;'>Kontakt: {$contact}</h3>";
echo "<h3 class='record-information' style='clear:left;'>Smlouva: {$contract}";
if ($resource->has_more_contracts())
{
	foreach ($resource->get_inactive_contracts() as $contract)
	{
		if ($contract->is_blanco())
		{
			$contract_message = "blanco smlouva ";
		} else
		{
			$contract_message = "původní smlouva ";
		}
		echo " || <i>{$contract_message} ";
		$c_url = url::site("tables/contracts/view/".$contract->id);
		echo " : <a href='{$c_url}'>{$contract}</a></i>";
	}
}
echo "</h3>";
?>
<hr class="clear"/>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Hodnocení</a></li>
		<li><a href="#tabs-2">Semínka</a></li>
		<li><a href="#tabs-3">Významný vydavatel</a></li>
		<li><a href="#tabs-4">Screenshoty</a></li>
	</ul>
	<div id="tabs-1">
		<?php View::factory('tables/resources/ratings')->render(TRUE)?>
	</div>
	<div id="tabs-2">
		<?php View::factory('tables/resources/seeds')->render(TRUE)?>
	</div>
	<div id="tabs-3">
		<?php View::factory('tables/resources/nominations')->render(TRUE)?>
	</div>
	<div id="tabs-4">
		<?php View::factory('tables/resources/screenshots')->render(TRUE)?>
	</div>
</div>