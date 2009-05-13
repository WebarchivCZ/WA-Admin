<?php
$rating_result_array = Kohana::config('wadmin.ratings_result');
$rating_values_array = Kohana::config('wadmin.rating_values');
?>
<div class="top-bar">
    <h1>Hodnocení zdrojů</h1>
</div>
<br />
<div class="select-bar">
    <form action="<?= url::base().url::current() ?>/search/">
        <label> <input type="text" name="search_string" /> </label>
        <label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
    </form>
</div>

<?php
if (isset($resources_new) AND $resources_new)
{
    echo form::open(url::base(FALSE).url::current().'/save');
    ?>

<h2>Zdroje k hodnocení</h2>

<div class="table">
        <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
        <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th>Kurátor</th>
            <th>Konspekt</th>
            <th>Hodnocení</th>
            <th>Podobné</th>
            <th class="last">Hod. ostatních</th>
        </tr>
            <?php foreach ($resources_new as $resource)
            { ?>
        <tr>
            <td class="first"><?=$resource->title ?></td>
            <td><a href="<?=$resource->url ?>"><?=$resource->url ?></a></td>
            <td><?=$resource->curator->username ?></td>
            <td><?=$resource->conspectus->category ?></td>
            <td>
                        <?= form::dropdown("rating[$resource->id]", $rating_values_array, $ratings[$resource->id]); ?>
            </td>
            <td class="center">
                        <?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
            </td>
            <td class="center">
                        <?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
            </td>
        </tr>
            <?php } ?>

    </table>
</div>
    <p class="center">
            <?=form::submit('submit', 'Uložit hodnocení') ?>
            <?=form::close() ?>
    </p>

    <?php
    }
    if (isset($resources_reevaluate) AND $resources_reevaluate)
    {
        echo form::open(url::base(FALSE).url::current().'/save');
        ?>

    <h2>Zdroje k přehodnocení</h2>

    <div class="table">
            <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
            <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>
        <table class="listing" cellpadding="0" cellspacing="0">
            <tr>
                <th class="first">Název</th>
                <th>URL</th>
                <th>Kurátor</th>
                <th>Konspekt</th>
                <th>Hodnocení</th>
                <th>Podobné</th>
                <th class="last">Hod. ostatních</th>
            </tr>
                <?php foreach ($resources_reevaluate as $resource)
                { ?>
            <tr>
                <td class="first"><?=$resource->title ?></td>
                <td><a href="<?=$resource->url ?>"><?=$resource->url ?></a></td>
                <td><?=$resource->curator->username ?></td>
                <td><?=$resource->conspectus->category ?></td>
                <td>
                            <?= form::dropdown("rating[$resource->id]", $rating_values_array, $ratings[$resource->id]); ?>
                </td>
                <td class="center">
                            <?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
                </td>
                <td class="center">
                            <?=html::image(array('src' => 'media/img/icons/find.png' , 'width' => '16' , 'height' => '16'))?>
                </td>
            </tr>
                <?php } ?>
        </table>
    </div>
    <p class="center">
            <?=form::submit('submit', 'Uložit hodnocení') ?>
            <?=form::close() ?>
    </p>

    <?php } ?>
