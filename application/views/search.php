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
<h3>Vydavatelé</h3>
<?php
$output = '';

if (count($publishers) != 0) {
	$output .= '<div class="table">
				<table class="listing" cellpadding="0" cellspacing="0">
					<th>ID</th><th>Jméno</th>';
	foreach ($publishers as $publisher) {
		$output .=  '<tr>'.
					'<td>' . $publisher->id . '</td>'.
					'<td>' . $publisher->name . '</td>'.
					'</tr>';
	}
	$output .= '</table>
				</div>';
} else {
	$output .= 'Nebyl nalezen žádný vydavatel odpovídající hledanému řetězci';
}

$output .= '<h3>Zdroje</h3>';

if (count($publishers) != 0) {
	$output .= '<table class="listing" cellpadding="0" cellspacing="0">
					<th>ID</th><th>Název</th><th>URL</th><th>Vydavatel</th>';
	foreach ($resources as $resource) {
		$output .=  '<tr>' .
					'<td>' . $resource->id . '</td>'.
					'<td>' . $resource->title . '</td>'.
					'<td>' . $resource->url . '</td>'.
					'<td>' . $resource->publisher . '</td>'.
					'</tr>';
	}
	$output .= '</table>';
} else {
	$output .= 'Nebyl nalezen žádný zdroj odpovídající hledanému řetězci';
}

$output .= '<hr /><p>Poznámka: výraz je hledán v URL a názvu zdroje a jména vydavatele.</p>';

echo $output;
?>