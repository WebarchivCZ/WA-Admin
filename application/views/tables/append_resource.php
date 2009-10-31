<?php
if ($resource->__isset('publisher_id'))
{
// TODO refaktorovat!
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
    echo "<h3 class='record-information'>Vydavatel: {$publisher}</h3>";
    echo "<h3 class='record-information'>Kontakt: {$contact}</h3>";
    echo "<h3 class='record-information'>Smlouva: {$contract}</h3>";
}

if ($ratings->count() > 0)
{
    $rating_values = Kohana::config('wadmin.rating_values');
    $rating_class = '';
    if ($resource->__isset('rating_result')) {
        $rating_class = ' class="hidden"';
    }
    ?>

<hr />

<h2 id="section-rating">Hodnocení</h2>
<div id="table-ratings"<?= $rating_class; ?>>
    <div class="table">

            <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
            <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>

        <table class="listing" cellpadding="0" cellspacing="0">
            <tr>
                <th width="15%" class="first">Datum</th>
                    <?php

                    $curators_count = $active_curators->count();
                    $cell_width = (85 / $curators_count);
                    foreach ($active_curators as $i => $curator)
                    {
                        if($i == $curators_count-1)
                        {
                            $class = ' class="last"';
                        } else
                        {
                            $class = '';
                        }

                        echo "<th{$class} width='$cell_width'>$curator</th>";
                    }?>
            </tr>
            <tr>
                <td class="first"><?= $resource->get_ratings_date(1); ?></td>
                    <?
                    foreach ($active_curators as $curator)
                    {
                        $rating_output = display::display_rating($resource, $curator->id, 1);
                        ?>
                <td class="center"><?= $rating_output ?></td>
                    <?php } ?>
            </tr>
        </table>
    </div>
        <?php
        $ratings = ORM::factory('rating')->where(array(
            'resource_id'=>$resource->id, 'comments !=' => ''))->find_all();
    if ($ratings->count() > 0) {
        foreach($ratings as $rating)
        {
            echo "<p>{$rating->curator}: {$rating->comments}</p>";
        }
    }
    if ($show_final_rating == TRUE)
        {
            $round = ($resource->resource_status_id == RS_NEW) ? 1 : 2;
            $resource_rating = $resource->compute_rating(1, 'int');
            $rating_options = Rating_Model::get_final_array();
                ?>

            <?= form::open(url::site('tables/resources/save_final_rating/'.$resource->id)) ?>
    <p><b>Finalni hodnoceni:</b>
                <?= form::dropdown('final_rating', $rating_options, $resource_rating)?>
                <?= form::submit('save_rating', 'Uložit hodnocení'); ?>
    </p>
            <?= form::close() ?>
        <?}
    echo '</div>';
    }?>

    <h2 id="section-seeds" onclick="$('#table-seeds').toggle()">Semínka</h2>
    
    <div id="table-seeds" class="table" style="display:none;">
        <?php if (isset ($seeds) AND $seeds->count() > 0)
        {?>
        <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
        <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>
        <?
            $output = '<table class="listing" cellpadding="0" cellspacing="0">
        <tr><th class="first" width="6%">Edit</th><th>URL</th><th>Stav</th><th>Od</th><th>Do</th><th class="last">Komentář</th></tr>';
            foreach ($seeds as $seed)
            {
                $seed_url = url::site('tables/seeds/edit/'.$seed->id);
                $output .= "<tr>
                            <td class='first'>
                                <a href='{$seed_url}'>".icon::img('pencil', 'Editovat semínko')."</a>
                            </td>
                            <td><a href='$seed->url'>{$seed->url}</a></td>
                            <td>{$seed->seed_status}</td>
                            <td>{$seed->valid_from}</td>
                            <td>{$seed->valid_to}</td>
                            <td class='last'>{$seed->comments}</td>
                        </tr>";
            }
            $output .= '</table>';
        
        echo $output;
        }?>
        <p><a href="<?= url::site('tables/seeds/add/'.$resource->id) ?>"><button>Přidat semínko</button></a></p>
    </div>
    