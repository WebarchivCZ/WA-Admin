<div id="tabs">
    <ul>
        <li><a href="#tabs-1">K hodnocení
            (<?= is_null($resources_new) ? "0" : $resources_new->count() ?>)</a></li>
        <li><a href="#tabs-2">K přehodnocení
            (<?= is_null($resources_reevaluate) ? "0" : $resources_reevaluate->count() ?>)</a></li>
        <li><a href="#tabs-3">Ohodnocené
            (<?= is_null($rated_resources_new) ? "0" : $rated_resources_new->count() ?>)</a></li>
        <li><a href="#tabs-4">Přehodnocené
            (<?= is_null($rated_resources_reevaluate) ? "0" : $rated_resources_reevaluate->count() ?>)</a></li>
    </ul>
	<?php

	$resources = array(1=> $resources_new,
					   2=> $resources_reevaluate,
					   3=> $rated_resources_new,
					   4=> $rated_resources_reevaluate);

	foreach ($resources as $tab_id => $resource_set)
	{
		$status = ($tab_id % 2 == 0) ? RS_RE_EVALUATE : RS_NEW;

		$view = View::factory('forms/ratings_final');
		$view->status = RS_NEW;
		$view->resources = $resource_set;
		$view->tab_id = $tab_id;
		$view->render(TRUE);
	}
	?>
</div>

<?php
if (! $rated_resources_reevaluate and  ! $rated_resources_new and  ! $resources_reevaluate and  ! $resources_new)
{
	echo '<p>Nebyly nalezeny žádné zdroje k hodnocení</p>';
}