<?php if (isset($resources) AND $resources->count() != 0) { ?>

<div class="table">

    <?= html::image(array('src'=>'media/img/bg-th-left.gif', 'width'=>'8', 'height'=>'7', 'class'=>'left')) ?>
    <?= html::image(array('src'=>'media/img/bg-th-right.gif', 'width'=>'7', 'height'=>'7', 'class'=>'right')) ?>

    <table class="listing" cellpadding="0" cellspacing="0">
        <tr>
            <th class="first" width="40%">Zdroj</th>
            <th>Kontakt</th>
            <th>1. oslovení</th>
            <th>2. oslovení</th>
            <th class="last">3. oslovení</th>
        </tr>
<?php foreach ($resources as $resource) {
        $resource_url = 'tables/resources/view/'.$resource->id;
        $contact_url = 'tables/contacts/view/'.$resource->contact->id;
?>
        <tr>
            <td class="first"><?= html::anchor(url::site($resource_url), $resource->title) ?></a></td>
            <td><a href="<?= url::site($contact_url) ?>"><?= $resource->contact ?></a></td>
            <td><?= $resource->get_correspondence(1)->date ;?></td>
            <td><?= $resource->get_correspondence(2)->date ;?></td>
            <td class="last"><?= $resource->get_correspondence(3)->date ;?></td>
<? } ?>
    </table>
</div>

<? } ?>