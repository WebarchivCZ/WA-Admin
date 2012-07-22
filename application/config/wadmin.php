<?php
$config = array(
    'top_menu' => array(
        'home',
        'suggest',
        'rate',
        'addressing',
        'progress',
        'catalogue',
        'quality_control',
        'conspectus'),

    'date_format' => 'Y-m-d H:i:s',

    'short_date_format' => 'd.m.Y',

    'title_length' => 35);

$config['wayback_url'] = 'http://har.webarchiv.cz:8080/AP1/query?type=urlquery&amp;Submit=Take+Me+Back&amp;url=';

/**
 * Enable debug mode. Display errors and profiler info.
 * Error messages can be set by variable $this->template->debug
 */
$config['debug_mode'] = TRUE;

$config['version'] = '2.34';

$config['build'] = 1;

$config['ticket_url'] = 'https://github.com/WebArchivCZ/WA-Admin/issues/new';

$config['url_path_screenshots'] = "/media/screenshots/";
$config['screenshots_dir'] = "D:\\xampplite\\htdocs\\wadmin\\media\\screenshots\\";

// Screenshot constants
$config['full_screenshot_prefix'] = 'big_';
$config['thumbnail_screenshot_prefix'] = 'small_';
?>