<?php


$curators_count = $active_curators->count();
$cell_width = (85 / $curators_count);

if ($resource->is_ratable())
{
	$rounds = $resource->rating_last_round + 1;
} else
{
	$rounds = $resource->get_round_count();
}
if ($rounds > 0 || $resource->is_ratable())
{
	echo table::header();
	?>

<tr>
	<th width="15%" class="first">Datum</th>
	<?php
	foreach ($active_curators as $i => $curator)
	{
		if ($i == $curators_count - 1)
		{
			$class = ' class="last"';
		} else
		{
			$class = '';
		}

		echo "<th{$class} width='{$cell_width}%'>$curator</th>";
	}
	?>
</tr>

<?php
	$url = "tables/resources/save_rating/{$resource->id}/{$this->user->id}/{$rounds}";
	echo form::open(url::site($url));
	for ($round = 1; $round <= $rounds; $round ++)
	{
		if ($resource->has_rating($round) or $resource->is_ratable())
		{
			?>
<tr>
	<td class="first"><?=$resource->get_ratings_date($round);?></td>
			<?php
			foreach ($active_curators as $curator)
			{
				$rating_output = display::rating($resource, $curator->id, $round);
				echo "<td class='center'>{$rating_output}</td>";
			}
			echo '</tr>';
		}
	}
	echo table::footer();
	$comment = $resource->get_curator_rating($this->user->id, $rounds)->comments;
	if ($resource->is_ratable())
	{
		echo '<p>'.form::label('comment', 'Komentář:').' ';
		echo form::input("comment", $comment, 'size=45 id=comment').' ';
		echo form::submit('save_rating', 'Uložit hodnocení').'</p>';
	}
	echo form::close();

	$ratings_w_comment = $resource->get_ratings_with_comment();

	if ($ratings_w_comment->count() > 0)
	{
		echo "<ul>";
		foreach ($ratings_w_comment as $rating)
		{
			echo "<li><strong>{$rating->curator}</strong>: {$rating->comments}</li>";
		}
		echo "</ul>";
	}
	if ($show_final_rating == TRUE)
	{
		$resource_rating = $resource->compute_rating($resource->rating_last_round + 1);
		$rating_options = Rating_Model::get_final_array();
		$subcategory = (empty($resource->conspectus_subcategory_id)) ? 'není vyplněno' : $resource->conspectus_subcategory;
		$crawl_freq_options[0] = 'Vyplnit!';
		$crawl_freq_options = array_merge($crawl_freq_options, ORM::factory('crawl_freq')->select_list('id', 'frequency'));
		?>

		<?= form::open(url::site('tables/resources/save_final_rating/'.$resource->id)) ?>
	<p><strong>Finalní hodnocení:</strong>
		<?=form::dropdown('final_rating', $rating_options, $resource_rating)?>
	<p id='p_reevaluate_date' class="hidden_toggle_elements">
		Prehodnotit k:
		<?=form::input('reevaluate_date')?>
	</p>
	<p id='p_crawl_freq' class="hidden_toggle_elements">
		Frekvence sklízení:
		<?=form::dropdown('crawl_freq_id', $crawl_freq_options)?>
	</p>
	<p><strong>Souhlasí podkategorie?</strong> - <?=$subcategory?></p>
	<p><?=form::submit('save_rating', 'Uložit finální hodnocení');?></p>
		<?=form::close();?>

	<?php
	}
} else
{
	echo "<p class='center'>".icon::img('information', 'Zdroj nemá žádná hodnocení.').
		" Zdroje nemá žádná hodnocení z minulosti a již není možné ho hodnotit.</p>";
}
?>