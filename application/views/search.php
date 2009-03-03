<div class="top-bar">
	<h1>Vyhledávání</h1>
</div>
<br />
<div class="select-bar">
	<form action="<?= url::base().url::current() ?>/search/">
		<label> <input type="text" name="search_string" /> </label>
		<label> <input type="submit" name="Submit" value="<?= Kohana::lang('tables.search');?>" /> </label>
	</form>
</div>
<h2>Výsledek vyhledávání dotazu: <em><?= $pattern ?></em></h2>
<h3>Zdroje</h3>
<?php
$output = '';

if (count($resources) != 0) {
	$output .= '<table class="listing" cellpadding="0" cellspacing="0">
					<th>Název</th><th>URL</th><th>Vydavatel</th>';
	foreach ($resources as $resource) {
		$output .=  '<tr>' .
					'<td>' .
					html::anchor('tables/resources/view/'.$resource->id, $resource->title).
					'</td>'.
					'<td>' .
					html::anchor($resource->url) .
					'</td>'.
					'<td>' . 
					html::anchor('tables/publishers/view/'.$resource->publisher->id, $resource->publisher).
					'</td>'.
					'</tr>';
	}
	$output .= '</table>';
} else {
	$output .= '<p>Nebyl nalezen žádný zdroj odpovídající hledanému řetězci</p>';
}

$output .= '<hr /><p>Poznámka: výraz je hledán v URL a názvu zdroje a jména vydavatele.</p>';

echo $output;
?>