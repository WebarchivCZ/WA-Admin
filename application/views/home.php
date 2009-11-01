<h2>Důležité informace</h2>

<?= $dashboard ?>

<h2>Statistiky</h2>

<table>
    <?php foreach($stats as $statistic) { ?>
    <tr>
        <td><?=$statistic->name ?></td>
        <td><?=$statistic->value ?></td>
    </tr>
    <? } ?>
</table>