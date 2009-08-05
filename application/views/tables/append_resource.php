<?php
if ($resource->__isset('publisher_id'))
{
    if ($resource->publisher_id != '')
    {
        $publisher_url = url::site('tables/publishers/view/'.$resource->publisher_id);
        $publisher = "<a href='{$publisher_url}'>{$resource->publisher}</a>";
    } else
    {
        $publisher = 'neexistuje';
    }
    if ($resource->contact_id != '')
    {
        $contact_url = url::site('tables/contacts/view/'.$resource->contact_id);
        $contact = "<a href='{$contact_url}'>{$resource->contact}</a>";
    } else
    {
        $contact_add = url::site("/tables/contacts/add/{$resource->publisher_id}/{$resource->id}");
        $contact = "<a href='{$contact_add}'>vytvořit</a>";
    }
    if ($resource->contract_id != '')
    {
        $contract_url = url::site('tables/contracts/view/'.$resource->contract_id);
        $contract = "<a href='{$contract_url}'>{$resource->contract}</a>";
    } else
    {
        $contract_add = url::site("progress/new_contract/{$resource->id}");
        $contract = "<a href='{$contract_add}'>vytvořit</a>";
    }
    echo "<h3>Vydavatel: {$publisher}</h3>";
    echo "<h3>Kontakt: {$contact}</h3>";
    echo "<h3>Smlouva: {$contract}</h3>";
}

if ($ratings->count() > 0)
{
    $rating_values = Kohana::config('wadmin.rating_values') ?>
<hr />
<h2>Hodnocení</h2>
<div class="table">

        <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
        <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th width="15%" class="first">Datum</th>
                <?php
                // TODO zmenit round
                $sql = "SELECT MAX(date) as datum FROM ratings WHERE resource_id = $resource->id AND round = 1";
                $result = Database::instance()->query($sql);
                $datum_result = $result->current()->datum;
                $datum = date("d.m.Y", strtotime($datum_result));

                $curators_count = $active_curators->count();
                $cell_width = (85 / $curators_count);
                foreach ($active_curators as $i => $curator)
                {
                    switch ($i)
                    {
                        case 0:
                            //$class = ' class="first"';
                            $class = '';
                            break;
                        case $curators_count-1:
                            $class = ' class="last"';
                            break;
                        default:
                            $class = '';
                    }

                    echo "<th{$class} width='$cell_width'>$curator</th>";
                }?>
        </tr>
        <tr>
            <td><?= $datum ?></td>
                <?
                foreach ($active_curators as $curator)
                {
                    $rating = ORM::factory('rating')->where(array(
                        'round' => 1,
                        'curator_id'=>$curator->id,
                        'resource_id'=>$resource->id))
                        ->find();
                        
                        if ($rating->id != 0) {
                            $rating = $rating_values[$rating->rating];
                        } elseif ($resource->resource_status_id == RS_NEW) {
                            $rating = icon::img('cross', 'Kurátor ještě neohodnotil zdroj');
                        } else {
                            $rating = icon::img('bullet_black', 'Kurátor neohodnotil zdroj a hodnocení je již uzavřeno');
                        }
                        //echo Kohana::debug($rating);
                    ?>
            <td class="center"><?= $rating ?></td>
                <?php } ?>
        </tr>
    </table>
</div>
    <?php
    $ratings = ORM::factory('rating')->where(array(
                'resource_id'=>$resource->id, 'comments !=' => ''))->find_all();
    foreach($ratings as $rating) {
        echo "<p>{$rating->curator}: {$rating->comments}</p>";
    }

?>  


<? } ?>