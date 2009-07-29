<?php
if (isset($resources) AND $resources->count() != 0) {
    echo '<h3>Vydavatel vydává tyto zdroje:</h3>';
    echo '<ul>';
    foreach ($resources as $resource) {
        $url = url::site('tables/resources/view/'.$resource->id);
        echo "<li><a href='{$url}'>{$resource->title}</a></li>";
    }
    echo '</ul>';
}
if (isset($contacts) AND $contacts->count() != 0) {
    echo '<h3>Kontaktní osoby vydavatele:</h3>';
    echo '<ul>';
    foreach ($contacts as $contact) {
        $url = url::site('tables/contacts/view/'.$contact->id);
        echo "<li><a href='{$url}'>{$contact->name}</a></li>";
    }
    echo '</ul>';
}
?>