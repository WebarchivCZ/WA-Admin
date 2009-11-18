<h2><?= $title ?></h2>

<div class="table">
    <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
    <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>
    <table class="listing" cellpadding="0" cellspacing="0">
       <tr>
            <th class="first" width="75%">Název</th>
            <th class="last">Počet hodnocení</th>
        </tr>
        <?php foreach ($resources as $resource)
        {
            $round = ($status == RS_NEW) ? 1 : 2;
            $rating_count = $resource->rating_count($round);
            
            $class = '';
            $icon = '';
            if ($resource->suggested_by_id == 2)
            {
                $icon = icon::img('exclamation', 'Zdroj navrhl vydavatel');
                $class = 'suggested_by_pub';
            }
        ?>
        <tr>
            <td class="first">
                    <?= html::anchor('tables/resources/view/'.$resource->id, $resource, array('class'=>$class)) ?>
                    <?= $icon; ?>
            </td>
            <td class="center">
                    <?= $rating_count ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>