<h2>Zobrazit záznam</h2>

<?php if (isset($append_view))
{
    $append_view->render(TRUE);
}

?>
<?php if (isset($values)): ?>

<div class="table">

        <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
        <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>

    <table class="listing" cellpadding="0" cellspacing="0">

        <tr>
            <th class="first">Sloupec</th>
            <th class="last">Hodnota</th>
        </tr>

            <?php foreach ($values as $key => $value):
                if ($key == 'url')
                {
                    $value = "<a href='{$value}' target='_blank'>{$value}</a>";
                }
                if ($key == 'email') {
                    $value = "<a href='mailto:{$value}'>{$value}</a>";
                }
                ?>

        <tr>
            <td><?= ucfirst(Kohana::lang('tables.'.$key)) ?></td>
            <td><?= $value ?></td>
        </tr>

            <?php endforeach; ?>
    </table>
</div>

<?php endif; ?>

<p>
    <a href="<?= $edit_url ?>"><button>Editace záznamu</button></a>
</p>