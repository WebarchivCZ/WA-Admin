<?php if ($match_resources->count() != 0)
{
	// moznost nastavit jine url, nez defaultni (napr. vytvareni vydavatelu)
	if (! isset($redirect_urls))
	{
		$redirect_urls = array();
		$redirect_urls['insert'] = 'suggest/insert/';
		$redirect_urls['back'] = 'suggest';
		$redirect_urls['continue'] = 'suggest/insert/';
	}
	?>
<h3>Nalezené shody</h3>
<div class="table">
	<?=html::image(array('src'    => 'media/img/bg-th-left.gif',
						 'width'  => '8',
						 'height' => '7',
						 'class'  => 'left')) ?>
	<?=html::image(array('src'    => 'media/img/bg-th-right.gif',
						 'width'  => '7',
						 'height' => '7',
						 'class'  => 'right')) ?>
	<table class="listing" cellpadding="0" cellspacing="0">
		<tr>
			<th class="first">Název</th>
			<th>URL</th>
			<th class="last">Vydavatel</th>
		</tr>
		<?php foreach ($match_resources as $resource)
	{
		?>
		<tr>
			<td>
				<?= html::anchor('tables/resources/view/'.$resource->id, $resource->title) ?>
			</td>
			<td>
				<?= html::anchor($resource->url, $resource->url, array('target'=> '_blank')) ?>
			</td>
			<td class="hovering">
				<?= html::anchor(url::site($redirect_urls['insert'].$resource->publisher_id), $resource->publisher, array('class'=> 'publisherName')) ?>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>

<?php } ?>

<?= html::anchor($redirect_urls['back'], '<button>Zpět</button>') ?>
&nbsp;
<?= html::anchor($redirect_urls['continue'], '<button>Pokračovat</button>') ?>