<h2>Výsledek vyhledávání dotazu: <em><?= $pattern ?></em></h2>
<h3>Zdroje</h3>
<?php if (count($resources) != 0)
{
	echo table::header(); ?>
<tr>
	<th class="first">Název</th>
	<th>&nbsp;</th>
	<th>URL</th>
	<th class="last">Vydavatel</th>
</tr>
<?php foreach ($resources as $resource)
{
	?>
<tr>
	<td class="first">
		<?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
	</td>
	<td><?= $resource->get_icon(); ?></td>
	<td>
		<?= html::anchor($resource->url, $resource->url, array('target' => '_blank')) ?>
	</td>
	<td class="last">
		<?= html::anchor('tables/publishers/view/'.$resource->publisher->id, $resource->publisher) ?>
	</td>
</tr>
<? } ?>
</table>
</div>
<?
} else
{

	echo '<p>Nebyl nalezen žádný zdroj odpovídající hledanému řetězci</p>';
}
echo '<hr/><p>Poznámka: výraz je hledán v URL a názvu zdroje a jména vydavatele.</p>';
