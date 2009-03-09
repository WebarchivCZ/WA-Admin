<div class="top-bar"><a href="#" class="button"><?= Kohana::lang('tables.add') ?></a>
	<h1><?= Kohana::lang('tables.'.$title) ?></h1>
	<div class="breadcrumbs"><a href="<?= url::base() ?>">Home</a> / <a href="<?= url::base().url::current() ?>"><?= Kohana::lang('tables.'.$title) ?></a></div>
</div>
<br />
<div class="select-bar">
	<form action="<?= url::base().url::current() ?>/search/">
		<label> <input type="text" name="search_string" /> </label>
		<label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
	</form>
</div>

<?php
if (isset($form)) {
	echo $form;
}
?>