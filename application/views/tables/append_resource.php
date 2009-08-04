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
                <?php
                $curators_count = $active_curators->count();
                $cell_width = (100 / $curators_count);
                foreach ($active_curators as $i => $curator)
                {
                    switch ($i)
                    {
                        case 0:
                            $class = ' class="first"';
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
                <?php
                $is_comment = FALSE;
                foreach ($active_curators as $curator)
                {
                    $rating = ORM::factory('rating')->where(array(
                        'round' => 1,
                        'curator_id'=>$curator->id,
                        'resource_id'=>$resource->id))
                        ->find();
                    $is_comment = $is_comment + $rating->__isset('comments');
        ?>
            <td><?= $rating_values[$rating->rating] ?></td>

    <?php } ?>
        </tr>
    <?php if ($is_comment)
                { ?>
        <tr>
                    <?php foreach ($active_curators as $curator)
                    {
                        $rating = ORM::factory('rating')->where(array(
                            'round' => 1,
                'curator_id'=>$curator->id,
                'resource_id'=>$resource->id))
                            ->find(); ?>

            <td><?= $rating->comments ?></td>
        <?php } ?>
        </tr>
    <? } ?>
    </table>
</div>

<? } ?>