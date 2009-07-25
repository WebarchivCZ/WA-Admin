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
            <th>1. oslovení</th>
            <th>2. oslovení</th>
            <th>3. oslovení</th>
            <th class="last">Stav</th>
        </tr>
            <?php

            foreach($resources as $resource)
            {
        ?>

        <tr>
            <td class="first"><?=html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?></td>
            <td><a href="<?=$resource->url ?>" target="_blank"><?=$resource->url ?></a></td>

                    <?php
                    $new_email = true;
                    for($i = 1; $i<=3; $i++)
                    {
                        $correspondence = $resource->get_correspondence($i);
                        echo '<td class="center">';
                        if ($correspondence->id != 0)
                        {
                            echo icon::img('tick', 'Oslovení odesláno: '.$correspondence->date);
                        } elseif ($new_email == true)
                        {
                            $url = 'addressing/send/'.$resource->id.'/'.$i;
                            echo html::anchor(url::site().$url, icon::img('email_open', 'Odeslat oslovení'));
                            $new_email = false;
                        } else
                        {
                            echo icon::img('email', 'Toto oslovení nelze odeslat');
                        }
                        echo '</td>';
                    }
        ?>
            <td class="center">
        <?= $resource->resource_status ?>
            </td>
        </tr>
    <? } ?>
    </table>
    <p class="center">
        <button>Zobrazit všechny neoslovené zdroje</button>
    </p>
</div>
<?php } else
{
    echo '<p>Nebyly nalezeny žádné zdroje k oslovení.</p>';
}
?>
