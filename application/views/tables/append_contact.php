<?php
if (isset($resources) AND $resources->count() != 0) {
    echo '<h3>Kontakt je zodpovědný za tyto zdroje:</h3>';
    echo '<ul>';
    foreach ($resources as $resource) {
        $url = url::site('tables/resources/view/'.$resource->id);
        echo "<li><a href='{$url}'>{$resource->title}</a></li>";
    }
    echo '</ul>';
}
if (isset($publishers) AND $publishers->count() != 0) {
    echo '<h3>Kontakt zastupuje vydavatele:</h3>';
    echo '<ul>';
    foreach ($publishers as $publisher) {
        $url = url::site('tables/publishers/view/'.$publisher->id);
        echo "<li><a href='{$url}'>{$publisher->name}</a></li>";
    }
    echo '</ul>';
}
?>