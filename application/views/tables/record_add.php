<div class="top-bar" id ="solo">
    <h1><?= $header ?> - vložit</h1>
</div>

<?php if (isset($form))
    echo $form;
?>

<button onclick="history.back();">Zpět</button>