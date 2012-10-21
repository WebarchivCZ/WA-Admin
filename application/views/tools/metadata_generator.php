<?php
$view_name = "tools/record_{$format}_format";
foreach ($resources as $resource)
{
	$view = new View($view_name);
	$view->set('resource', $resource);
	$view->render(TRUE);
}