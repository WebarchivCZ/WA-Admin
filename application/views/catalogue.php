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
            <th class="last">Zkatalogizováno</th>
        </tr>
            <?php
            foreach ($resources as $resource)
            {
        ?>
        <tr>
            <td class="first"><?= html::anchor('tables/resources/view/'.$resource->id, $resource) ?></td>
            <td class="center"><a href="<?=$resource->url ?>" target="_blank"><?= icon::img('link', $resource->url) ?></a></td>
            <td class="center last">
                        <?php
                        if($resource->catalogued == NULL)
                        {
                            $url = url::site(url::current()).'/save/catalogued/'.$resource->id;
                            echo html::anchor($url, icon::img('pencil', 'Zaznamenat katalogizaci'));
                        } else
                        {
            echo icon::img('tick', $resource->catalogued);
        }
                        ?>
            </td>
        </tr>
    <?php } ?>
    </table>
    <p class="center">
        <button>Zobrazit všechny zdroje ke katalogizaci</button>
    </p>
</div>
<?php } else
{
    echo '<p>Nebyly nalezeny žádné zdroje ke katalogizaci.</p>';
}
?>