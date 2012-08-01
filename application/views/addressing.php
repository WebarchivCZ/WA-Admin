<?php
if (isset($resources) AND $resources->count() != 0)
{
	echo table::header(); ?>
<tr>
	<th class="first">Název</th>
	<th>URL</th>
	<th>1. oslovení</th>
	<th>2. oslovení</th>
	<th class="last">3. oslovení</th>
</tr>
<?php

	foreach ($resources as $resource)
	{
		$class = '';
		$icon = '';
		if ($resource->suggested_by_id == 2)
		{
			$icon = icon::img('exclamation', 'Zdroj navrhl vydavatel');
			$class = 'suggested_by_pub';
		} elseif ($resource->suggested_by_id == 4)
		{
			$icon = icon::img('exclamation', 'Zdroj byl navržen ISSN');
			$class = 'suggested_by_issn';
		}
		if ($resource->publisher->get_resources()->count() > 1)
		{
			$url = url::site('/tables/publishers/view/'.$resource->publisher->id);
			$icon .= html::anchor($url, icon::img('publisher', $resource->publisher));
		}
		if (Contract_Model::domain_has_blanco($resource->url))
		{
			$icon = icon::img('publisher_red', 'Pro tuto doménu je blanco smlouva');
		}
		?>

	<tr>
		<td class="first">
			<?= html::anchor('tables/resources/view/'.$resource->id, $resource, array('class'=> $class)) ?>
			<?= $icon; ?>
		</td>
		<td class="center"><a href="<?=$resource->url ?>" target="_blank"><?= icon::img('link', $resource->url) ?></a>
		</td>

		<?php
		$new_email = TRUE;
		for ($i = 1; $i <= 3; $i ++)
		{
			$correspondence = $resource->get_correspondence($i);
			echo '<td class="center">';
			if ($correspondence->id != 0)
			{
				echo icon::img('tick', 'Oslovení odesláno: '.$correspondence->date);
			} elseif ($new_email == TRUE)
			{
				$url = 'addressing/send/'.$resource->id.'/'.$i;
				echo html::anchor(url::site().$url, icon::img('email_open', 'Odeslat oslovení'));
				$new_email = FALSE;
			} else
			{
				echo icon::img('email', 'Toto oslovení nelze odeslat');
			}
			echo '</td>';
		}
		?>
	</tr>
	<? } ?>
</table>
</div>
<?php
} else
{
	echo '<p>Nebyly nalezeny žádné zdroje k oslovení.</p>';
}
?>
