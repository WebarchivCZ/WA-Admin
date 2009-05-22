<?php
//DONE refaktorovat duplicitni kod (zobrazovani tabulky pro zdroje nove/k prehodnoceni)
$rating_result_array = Kohana::config('wadmin.ratings_result');
$rating_values_array = Kohana::config('wadmin.rating_values');

?>
<div class="top-bar">
    <h1>Hodnocení zdrojů</h1>
</div>
<br />
<div class="select-bar">
    <form action="<?= url::base().url::current() ?>/search/">
        <label> <input type="text" name="search_string" /> </label>
        <label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
    </form>
</div>

<?php
if(isset($message))
{
    echo "<h2>{$message}</h2>";
}
?>

<?php
if (isset($resources_new) AND $resources_new)
{

    $view = View::factory('tables/ratings');
    $view->title = 'Zdroje k hodnocení';
    $view->status = RS_NEW;
    $view->form_name = 'form_resources_new';
    $view->resources = $resources_new;
    $view->rating_values_array = $rating_values_array;
    $view->ratings = $ratings;
    $view->render(TRUE);

}
if (isset($resources_reevaluate) AND $resources_reevaluate)
{
    $view = View::factory('tables/ratings');
    $view->title = 'Zdroje k přehodnocení';
    $view->status = RS_RE_EVALUATE;
    $view->form_name = 'form_resources_reevaluate';
    $view->resources = $resources_reevaluate;
    $view->rating_values_array = $rating_values_array;
    $view->ratings = $ratings;
    $view->render(TRUE);

} 
if (isset($rated_resources_new) AND $rated_resources_new)
{
    foreach($rated_resources_new as $resource) {
        echo $resource->compute_rating(1) . ' -- ' . $resource->title . '<br/>';
    }
}
