<h2>Výsledek vyhledávání dotazu: <em><?= $pattern ?></em></h2>
<h3>Zdroje</h3>
<?php if (count($resources) != 0)
{ ?>
<div class="table">
    <?=html::image(array('src' => 'media/img/bg-th-left.gif' , 'width' => '8' , 'height' => '7' , 'class' => 'left'))?>
    <?=html::image(array('src' => 'media/img/bg-th-right.gif' , 'width' => '7' , 'height' => '7' , 'class' => 'right'))?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th class="last">Vydavatel</th>
        </tr>
    <?php	foreach ($resources as $resource)
    { ?>
        <tr>
            <td>
		<?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
            </td>
            <td>
		<?= html::anchor($resource->url, $resource->url, array('target'=>'_blank')) ?>
            </td>
            <td>
		<?= html::anchor('tables/publishers/view/'.$resource->publisher->id, $resource->publisher) ?>
            </td>
        </tr>
        <? } ?>
    </table>
</div>
    <? } else
    { ?>
    <p>Nebyl nalezen žádný zdroj odpovídající hledanému řetězci</p>
<?
}?>

    <hr /><p>Poznámka: výraz je hledán v URL a názvu zdroje a jména vydavatele.</p>
