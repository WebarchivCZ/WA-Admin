<div class="top-bar" id ="solo">
    <h1><?= $header ?></h1>
</div>

<?php if (isset($values)): ?>

<div class="table">

        <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
        <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>

    <table class="listing" cellpadding="0" cellspacing="0">

        <tr>
            <th class="first" width="30%">Sloupec</th>
            <th class="last">Hodnota</th>
        </tr>
            <?php foreach ($values as $key => $value):
            switch ($key) {
                case 'date':
                    $key = 'inserted';
                    break;
            }
                if ($key == 'url')
                {
                    $value = "<a href='{$value}' target='_blank'>{$value}</a>";
                }
                if ($key == 'email') {
                    $value = "<a href='mailto:{$value}'>{$value}</a>";
                }
                if ($key == 'cc') {
                    $value = ($value == TRUE) ? 'ANO' : 'NE';
                }
                ?>

        <tr>
            <td><?= ucfirst(Kohana::lang('tables.'.$key)) ?></td>
            <td><?= $value ?></td>
        </tr>

            <?php endforeach; ?>
    </table>
</div>

<?php if (isset($append_view))
{
    $append_view->render(TRUE);
}
?>

<?php endif; ?>

<p>
    <a href="<?= $edit_url ?>"><button>Editace záznamu</button></a>
    <button onclick="history.back()" class="floatright">Zpět</button></p>