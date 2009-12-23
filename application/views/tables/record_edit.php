<div class="top-bar" id ="solo">
    <h1><?= $header ?></h1>
</div>


<?php if (isset($form)): ?>
    <?= $form ?>
<?php endif; ?>

<button onclick="history.back();">Zpět</button>