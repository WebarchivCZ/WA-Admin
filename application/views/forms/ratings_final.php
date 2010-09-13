<?php $rating_result_array = Rating_Model::get_final_array(); ?>
<div id="tabs-<?= $tab_id ?>">
<?= table::header(); ?>
        <tr>
            <th class="first" width="75%">Název</th>
            <th class="last">Počet hodnocení</th>
        </tr>
        <?php foreach ($resources as $resource) {
            $round = ($status == RS_NEW) ? 1 : $resource->rating_last_round + 1;
            $rating_count = $resource->rating_count($round);

            $class = '';
            $icon = '';
            if ($resource->suggested_by_id == 2) {
                $icon = icon::img('exclamation', 'Zdroj navrhl vydavatel');
                $class = 'suggested_by_pub';
            }  elseif ($resource->suggested_by_id == 4) {
                $icon = icon::img('exclamation', 'Zdroj byl navržen ISSN');
                $class = 'suggested_by_issn';
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
                    <?php } 
echo table::footer();?>
</div>