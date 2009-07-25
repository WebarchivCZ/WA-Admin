<?php
if(isset($resources) AND $resources->count() != 0)
{
?>
<div class="table">
    <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
    <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th>Přiřadit smlouvu</th>
            <th>Odmítnuto vydavatelem</th>
            <th class="last">Bez odezvy</th>
        </tr>
            <?php
            foreach ($resources as $resource)
            {
        ?>
        <tr>
            <td class="first">
        <?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
            </td>
            <td>
                <a href='<?= $resource->url ?>' target="_blank"><?= $resource->url ?></a>
            </td>
            <td class='center'>
        <?= html::anchor(url::current().'/new_contract/'.$resource->id, icon::img('pencil', 'Přiřadit novou smlouvu')) ?>
            </td>
            <td class='center'>
        <?= html::anchor(url::current().'/reject/publisher/'.$resource->id, icon::img('cross', 'Zdroj byl odmítnut vydavatelem')) ?>
            </td>
            <td class='center'>
        <?= html::anchor(url::current().'/reject/no_response/'.$resource->id, icon::img('cross', 'Oslovení vydavatele je bez odezvy (x měsíců)')) ?>
            </td>
        </tr>

    <? } ?>
    </table>
    <p class="center">
        <button>Zobrazit všechny zdroje v jednání</button>
    </p>
</div>
<?php } else
{
    echo '<p>Nebyly nalezeny žádné zdroje v jednání.</p>';
}
?>