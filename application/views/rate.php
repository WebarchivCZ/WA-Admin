<div id="tabs">
<ul>
	<li><a href="#tabs-1">K hodnocení <?= "({$resources_new->count()})" ?></a></li>
	<li><a href="#tabs-2">K přehodnocení <?= "({$resources_reevaluate->count()})" ?></a></li>
	<li><a href="#tabs-3">Ohodnocené <?= "({$rated_resources_new->count()})" ?></a></li>
	<li><a href="#tabs-4">Přehodnocené <?= "({$rated_resources_reevaluate->count()})" ?></a></li>
</ul>
<?php
if (isset($resources_new) and $resources_new) {
    $view = View::factory('forms/ratings_final');
    $view->status = RS_NEW;
    $view->resources = $resources_new;
    $view->tab_id = 1;
    $view->render(TRUE);

}
if (isset($resources_reevaluate) and $resources_reevaluate) {
    $view = View::factory('forms/ratings_final');
    $view->status = RS_RE_EVALUATE;
    $view->resources = $resources_reevaluate;
    $view->tab_id = 2;
    $view->render(TRUE);

}
if (isset($rated_resources_new) and $rated_resources_new) {
    $view = View::factory('forms/ratings_final');
    $view->status = RS_NEW;
    $view->resources = $rated_resources_new;
    $view->tab_id = 3;
    $view->render(TRUE);
}

if (isset($rated_resources_reevaluate) and $rated_resources_reevaluate) {
    $view = View::factory('forms/ratings_final');
    $view->status = RS_RE_EVALUATE;
    $view->resources = $rated_resources_reevaluate;
    $view->tab_id = 4;
    $view->render(TRUE);
}
?>
</div>

<?php
if ( ! $rated_resources_reevaluate and  ! $rated_resources_new and  ! $resources_reevaluate and  ! $resources_new) {
    echo '<p>Nebyly nalezeny žádné zdroje k hodnocení</p>';
}