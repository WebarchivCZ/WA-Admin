<?php
if (isset($seeds) and $seeds->count() > 0) {
    echo table::header();
    $output = '<tr>
    			<th class="first" width="6%">Edit</th>
    			<th>URL</th>
    			<th>Stav</th>
    			<th>Od</th>
    			<th>Do</th>
    			<th class="last">Komentář</th>
    		   </tr>';
    foreach($seeds as $seed) {
        $seed_url = url::site('tables/seeds/edit/' . $seed->id);
        $output .= "<tr>
                        <td class='first'>
                            <a href='{$seed_url}'>" . icon::img('pencil', 'Editovat semínko') . "</a>
                        </td>
                        <td><a href='$seed->url'>{$seed->url}</a></td>
                        <td>{$seed->seed_status}</td>
                        <td>{$seed->valid_from}</td>
                        <td>{$seed->valid_to}</td>
                        <td class='last'>{$seed->comments}</td>
                	</tr>\n";
    }
    echo $output;
    
    echo table::footer();
} else {
    echo "<h3>Daný zdroj nemá žádné semínko</h3>";
}
?>
<p><a href="<?=url::site('tables/seeds/add/' . $resource->id)?>">
<button>Přidat semínko</button>
</a></p>