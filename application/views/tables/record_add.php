<?= $top_content = View::factory('layout/top_content')->set('header', $header) ?>
<div class="top-bar">
	<h1><?= $header ?> - vložit</h1>
</div>

<?php if (isset($form))
	echo $form;
?>

<button onclick="history.back();">Zpět</button>