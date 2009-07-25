<?php if ($match_resources->count() != 0) { ?>
<h3>Nalezené shody</h3>
<div class="table">
    <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left')) ?>
    <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right')) ?>
    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Název</th><th>URL</th><th class="last">Vydavatel</th>
        </tr>
            <?php foreach ($match_resources as $resource)
    { ?>
        <tr>
            <td>
        <?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
            </td>
            <td>
        <?= html::anchor($resource->url, $resource->url, array('target'=>'_blank')) ?>
            </td>
            <td class="hovering">
        <?= html::anchor(url::site('suggest/insert/'.$resource->publisher), $resource->publisher, array('class'=>'publisherName')) ?>
            </td>
        </tr>
    <?php } ?>
    </table>
</div>

<?php
} else {
    echo '<h3>Nebyly nalezeny shody.</h3>';
    } ?>
<a href="/wadmin/suggest"><button>Zpět</button></a>
<a href="/wadmin/suggest/insert"><button>Pokračovat</button></a>