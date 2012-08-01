<div class="floatright">
	<?php
	$tc_file = "{$resource->id}_tc.jpg";
	$tc_dir = 'media/img/liwa/';
	$tc_image_path = $tc_dir.$tc_file;

	if (file_exists($tc_image_path))
	{
		$tc_urls = Kohana::config('liwa.temporal_coherence_url');
		$image = html::image(array('src'  => $tc_image_path,
								   'style'=> 'border: 1px solid #888'));

		if (key_exists($resource->id, $tc_urls))
		{
			$tc_url = $tc_urls[$resource->id];
		} else
		{
			$tc_url = '';
		}

		echo '<h4>Temporal coherence</h4>';
		echo html::anchor($tc_url, $image, array('target'=> '_blank'));
	}
	?>
</div>
<?php
if (isset($form))
{
	echo $form;
}
?>