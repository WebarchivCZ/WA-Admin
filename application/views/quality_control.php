<div id="tabs">
<ul>
	<li><a href="#tabs-1">Zdroje ke kontrole <?="({$resources_to_control->count()})"?></a></li>
	<li><a href="#tabs-2">Nevyhovující zdroje <?="({$qa_checks_unsatisfactory->count()})"?></a></li>
	<?php
if (isset($qa_checks_acceptable)) {
    echo "<li><a href='#tabs-3'>Akceptovatelné zdroje ({$qa_checks_acceptable->count()})</a></li>";
}
?>
</ul>
<div id="tabs-1">
<?php
if (isset($resources_to_control) and $resources_to_control->count() > 0) {
    echo table::header();
    echo '<tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th class="last">Kontrola</th>';
    foreach($resources_to_control as $resource) {
        $qa_url = url::site('quality_control/add/' . $resource->id);
        echo '<tr>';
        echo '<td>' . html::anchor(url::site('tables/resources/view/' . $resource->id), $resource) . '</td>';
        echo '<td class="center">' . html::anchor($resource->url, icon::img('link', $resource->url), array ('target' => '_blank')) . '</td>';
        echo '<td class="center">' . html::anchor($qa_url, icon::img('note_add', 'Zaznamenat kontrolu kvality')) . '</td>';
        echo '</tr>';
    }
    echo table::footer();
} else {
    echo "<h3>Nenalezany žádné zdroje</h3>";
}
?>
</div>

<div id="tabs-2">
<?php
if (isset($qa_checks_unsatisfactory) and $qa_checks_unsatisfactory->count() > 0) {
    echo table::header();
    echo '<tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th class="last">Poslední kontrola</th>';
    foreach($qa_checks_unsatisfactory as $qa_check) {
        $resource = ORM::factory('resource', $qa_check->resource_id);
        $qa_url = url::site('quality_control/view/' . $qa_check->id);
        echo '<tr>';
        echo '<td>' . html::anchor(url::site('tables/resources/view/' . $resource->id), $resource) . '</td>';
        echo '<td class="center">' . html::anchor($resource->url, icon::img('link', $resource->url), array ('target' => '_blank')) . '</td>';
        echo '<td class="center">' . html::anchor($qa_url, icon::img('exclamation', 'Zobrazit kontrolu kvality')) . '</td>';
        echo '</tr>';
    }
    echo table::footer();
} else {
    echo "<h3>Nenalezany žádné zdroje</h3>";
}
?>
</div>

<div id="tabs-3">
<?php
if (isset($qa_checks_acceptable) and $qa_checks_acceptable->count() > 0) {
    echo table::header();
    echo '<tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th class="last">Poslední kontrola</th>';
    foreach($qa_checks_acceptable as $qa_check) {
        $resource = ORM::factory('resource', $qa_check->resource_id);
        $qa_url = url::site('quality_control/view/' . $qa_check->id);
        echo '<tr>';
        echo '<td>' . html::anchor(url::site('tables/resources/view/' . $resource->id), $resource) . '</td>';
        echo '<td class="center">' . html::anchor($resource->url, icon::img('link', $resource->url), array ('target' => '_blank')) . '</td>';
        echo '<td class="center">' . html::anchor($qa_url, icon::img('exclamation', 'Zobrazit kontrolu kvality')) . '</td>';
        echo '</tr>';
    }
    echo table::footer();
} 
?>
</div>
</div>
