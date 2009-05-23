<?php
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
$session = Session::instance();
if($session->get('message') != "")
{
    echo "<h3>{$session->get_once('message')}</h3>";
}
?>

<?php
if (isset($resources_new) AND $resources_new)
{
    $view = View::factory('tables/ratings');
    $view->title = 'Zdroje k hodnocení';
    $view->status = RS_NEW;
    $view->form_name = 'form_rate_new';
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
    $view->form_name = 'form_rate_reevaluate';
    $view->resources = $resources_reevaluate;
    $view->rating_values_array = $rating_values_array;
    $view->ratings = $ratings;
    $view->render(TRUE);

} 
if (isset($rated_resources_new) AND $rated_resources_new)
{
    $view = View::factory('tables/ratings_final');
    $view->title = 'Ohodnocené zdroje';
    $view->status = RS_NEW;
    $view->form_name = 'form_final_new';
    $view->resources = $rated_resources_new;
    $view->rating_values_array = $rating_result_array;
    $view->render(TRUE);
}

if (isset($rated_resources_reevaluate) AND $rated_resources_reevaluate)
{
    $view = View::factory('tables/ratings_final');
    $view->title = 'Přehodnocené zdroje';
    $view->status = RS_RE_EVALUATE;
    $view->form_name = 'form_final_reevaluate';
    $view->resources = $rated_resources_reevaluate;
    $view->rating_values_array = $rating_result_array;
    $view->render(TRUE);
}
