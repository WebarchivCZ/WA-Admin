<?php
if (isset($resources_to_control)) {
    echo '<h2>Zdroje ke kontrole</h2>';
    echo table::header();
    echo '<tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th class="last">Kontrola</th>';
    foreach ($resources_to_control as $resource) {
       $qa_url = url::site('quality_control/add/'.$resource->id);
       echo '<tr>';
       echo '<td>'.html::anchor(url::site('tables/resources/view/'.$resource->id), $resource).'</td>';
       echo '<td class="center">'
                .html::anchor($resource->url, icon::img('link', $resource->url), array('target'=>'_blank')).
            '</td>';
       echo '<td class="center">'.html::anchor($qa_url, icon::img('note_add', 'Zaznamenat kontrolu kvality')).'</td>';
       echo '</tr>';
    }
    echo table::footer();
}
if (isset($qa_checks_unsatisfactory) AND $qa_checks_unsatisfactory->count() > 0) {
    echo '<h2>Nevyhovující zdroje</h2>';
    echo table::header();
    echo '<tr>
            <th class="first">Název</th>
            <th>URL</th>
            <th class="last">Poslední kontrola</th>';
    foreach ($qa_checks_unsatisfactory as $qa_check) {
       $resource = ORM::factory('resource', $qa_check->resource_id);
       $qa_url = url::site('quality_control/view/'.$qa_check->id);
       echo '<tr>';
       echo '<td>'.html::anchor(url::site('tables/resources/view/'.$resource->id), $resource).'</td>';
       echo '<td class="center">'
                .html::anchor($resource->url, icon::img('link', $resource->url), array('target'=>'_blank')).
            '</td>';
       echo '<td class="center">'.html::anchor($qa_url, icon::img('exclamation', 'Zobrazit kontrolu kvality')).'</td>';
       echo '</tr>';
    }
    echo table::footer();
}
?>
