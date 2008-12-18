<h2>Vložení nového zdroje</h2>

<?php
if (isset($values)) {
	$content = '<h2>Zdroj byl uspesne vlozen</h2>
					<table>';
	foreach ($values as $key => $value) {
		$content .= "<tr><td>" . Kohana::lang('resource.'.$key)."</td><td>$value</td></tr>";
	}
	$content .= '</table>';
}

echo $content;

?>