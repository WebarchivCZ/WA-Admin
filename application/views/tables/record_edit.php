<?= $top_content = View::factory('layout/top_content')->set('header', $header) ?>
<div class="top-bar">
    <h1><?= $header ?></h1>
</div>


<?php if (isset($form)): ?>
    <?= $form ?>
<?php endif; ?>

<button onclick="history.back();">Zpět</button>