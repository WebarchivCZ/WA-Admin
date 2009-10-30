<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>WA Admin - <?= $title ?></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <?php
        echo html::stylesheet('media/css/formo');
        echo html::stylesheet('media/css/main');
        echo html::script('media/js/jquery.js');
        echo html::script('media/js/wadmin.js');
        ?>
    </head>
    <body>
        <div id="main" style="padding: 25px;">
            <?php if ($items->count() > 0)
{ ?>
            <div class="table">

                    <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
    <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>


                <table class="listing" cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="first">Název</th>
                        <th>URL</th>
                        <th>Vydavatel</th>
                        <th class="last">Výsledek hodnocení</th>
                    </tr>
                        <?php
                        foreach ($items as $resource) {
        ?>
                    <tr>
                        <td class="first"><?= html::anchor('tables/resources/view/'.$resource->id, $resource, array('target'=>'_parent')) ?></td>
                        <td class="center"><a href="<?=$resource->url ?>" target="_blank"><?= icon::img('link', $resource->url) ?></a></td>
                        <td><?= $resource->publisher ?></td>
                        <td class="last"><?= $resource->rating_result ?></td>
                    </tr>
    <?php } ?>
                </table>

    <?= $pages ?>

            </div>
            <?php
            }
            else
            {
    echo '<h2>Nebyly nalezeny žádné záznamy</h2>';
}
?>
            <h3 style="clear: both; text-align: center;">
                <a href="#" onclick="window.close()">Zavřít okno</a>
            </h3>
        </div>
    </body>
</html>