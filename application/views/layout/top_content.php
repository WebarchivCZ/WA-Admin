<div class="top-bar">
    <h1><?= $title ?></h1>
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
