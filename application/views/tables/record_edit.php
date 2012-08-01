<?= $top_content = View::factory('layout/top_content')->set('header', $header) ?>

<?php if (isset($form)): ?>
	<?= $form ?>
<?php endif; ?>

<button onclick="history.back();">Zpět</button>