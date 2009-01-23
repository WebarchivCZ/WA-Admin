<div class="top-bar">
	<h1>Dashboard</h1>
</div>
<div class="select-bar">
	<form action="<?= url::base().url::current() ?>/search/">
		<label> <input type="text" name="search_string" /> </label>
		<label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
	</form>
</div>

<h2>Důležité informace</h2>

<?= $dashboard ?>

<h2>Statistiky</h2>

<?= $stats ?>
