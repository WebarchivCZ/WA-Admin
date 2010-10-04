<?php
if(isset($resources) AND $resources->count() != 0) {
    ?>

<div class="table">
    <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
        <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th>MARC</th>
            <th>Aleph ID</th>
            <th class="last">Podkategorie</th>
        </tr>
    <?php
            foreach ($resources as $resource) {
                ?>
        <tr>
            <td class="first"><?= html::anchor('tables/resources/view/'.$resource->id, $resource) ?></td>
            <td class="center"><a href="<?=$resource->url ?>" target="_blank"><?= icon::img('link', $resource->url) ?></a></td>
            <td class="center">
        <?php
        if($resource->catalogued == NULL) {
                            $url = url::site(url::current()).'/save/catalogued/'.$resource->id;
                            echo form::open($url);
                            echo form::button('catalogued', icon::img('pencil', 'Zaznamenat katalogizaci'), 'class=icon');
                        } else {
                            echo icon::img('tick', $resource->catalogued);
                        }
                        ?>
            </td>
            <td class="center">
                <?php
                echo form::input('aleph_id', '', 'size="10"');
                ?>
            </td>
            <td class="last">
                <?php
                $subcategories = ORM::factory('conspectus_subcategory')
                					->where('conspectus_id', $resource->conspectus_id)
                					->select_list('id', 'title');
                echo form::dropdown('conspectus_subcategory_id',
                                    $subcategories,
                                    $resource->conspectus_subcategory_id,
                                    'style="width: 160px;"');
                echo form::close();
                ?>
            </td>
        </tr>
                        <?php } ?>
    </table>

</div>
    <?php } else {
    echo '<p>Nebyly nalezeny žádné zdroje ke katalogizaci.</p>';
}
?>