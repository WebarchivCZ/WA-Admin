<?= $top_content = View::factory('layout/top_content')->set('header', $header) ?>

<h2 class="center">Opravdu chcete odstranit tento záznam?</h2>

<?= form::open(url::current(TRUE), array('class'=>'center delete')) ?>
<?= form::hidden('sent', TRUE) ?>
<h2><?= form::button('confirm', 'Ano') ?></h2>
<h2><?= form::button('cancel', 'Ne') ?></h2>
<?= form::close() ?>