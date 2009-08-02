<?php
if (isset($resource->publisher_id)) {
    if ($resource->publisher_id != '') {
        $publisher_url = url::site('tables/publishers/view/'.$resource->publisher_id);
        $publisher = "<a href='{$publisher_url}'>{$resource->publisher}</a>";
    } else {
        $publisher = 'neexistuje';
    }
    if ($resource->contact_id != '') {
        $contact_url = url::site('tables/contacts/view/'.$resource->contact_id);
        $contact = "<a href='{$contact_url}'>{$resource->contact}</a>";
    } else {
        $contact_add = url::site("/tables/contacts/add/{$resource->publisher_id}/{$resource->id}");
        $contact = "<a href='{$contact_add}'>vytvořit</a>";
    }
    echo "<h3>Vydavatel: {$publisher}</h3>";
    echo "<h3>Kontakt: {$contact}</h3>";
}
?>