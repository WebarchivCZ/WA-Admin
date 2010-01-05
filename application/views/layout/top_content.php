<?php $title = isset($header) ? $header : $title; ?>
<div class="top-bar">
    <h1><?= $title ?></h1>
</div>
<br />
<div class="select-bar">
    <form action="<?= url::site('/home/search/'); ?>">
        <label> <input type="text" name="search_string" /> </label>
        <label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
    </form>
</div>