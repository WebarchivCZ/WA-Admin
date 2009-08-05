<?= form::open(url::base(FALSE).url::current().'/save/'.$status, array('id'=> $form_name, 'name'=> $form_name)); ?>

<h2><?= $title ?></h2>

<div class="table">
    <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
    <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>
    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th>Pod.</th>
            <th>Hodnocení</th>
            <th class="last">Komentář</th>
        </tr>
        <?php foreach ($resources as $resource)
        { ?>
        <tr>
            <td class="first">
                    <?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
            </td>
            <td class="center"><a href="<?=$resource->url ?>" target="_blank"><?= icon::img('link', $resource->url) ?></a></td>
            <td class="center"><?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?></td>
            <td class="center">
                    <?= form::dropdown("rating[$resource->id]", $rating_values_array, $ratings[$resource->id]); ?>
            </td>
            <td class="center last">
                    <?= form::input("comments[$resource->id]", '', 'size=30') ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
<p class="center">
    <?=form::submit('submit', 'Uložit hodnocení') ?>
</p>

<?=form::close() ?>