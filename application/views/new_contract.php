<?php if (isset ($contracts))
{ ?>
<h3>Přiřazení existující smlouvy ke zdroji</h3>
<div class="table">

        <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
        <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>


    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first">Zdroj</th>
            <th>Vydavatel</th>
            <th class="last">Smlouva</th>
        </tr>
            <?php foreach($contracts as $contract)
            {
            	$publisher = ORM::factory('resource', $resource_id)->publisher;
                $resources = $contract->get_resources($publisher);
                foreach ($resources as $resource)
                {
            ?>
        <tr>
            <td class="first">
                <?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
            </td>
            <td>
                <?= html::anchor('tables/publishers/view/'.$resource->publisher_id, $resource->publisher) ?>
            </td>
            <td class="last contract-name">
                    <?= html::anchor("progress/assign_existing_contract/{$resource_id}/{$contract->id}",
                        $resource->contract) ?>
            </td>
        </tr>
                <? } ?>
    <? } ?>
    </table>

</div>

<? } ?>
<h3>Přiřazení nové smlouvy ke zdroji</h3>
<?= $form ?>

<button onclick="history.back()">Zpět</button>