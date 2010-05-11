<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-03-31 09:21:10 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:21:10 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:21:10 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:21:10 +02:00 --- debug: Session Library initialized
2010-03-31 09:21:10 +02:00 --- debug: Auth Library loaded
2010-03-31 09:21:10 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:21:10 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:21:10 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:21:10 +02:00 --- debug: Session Library initialized
2010-03-31 09:21:10 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:21:10 +02:00 --- debug: Auth Library loaded
2010-03-31 09:27:13 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:27:13 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:27:13 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:27:13 +02:00 --- debug: Session Library initialized
2010-03-31 09:27:13 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:27:13 +02:00 --- debug: Auth Library loaded
2010-03-31 09:27:14 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:27:14 +02:00 --- debug: Database Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:27:33 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:27:33 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:27:33 +02:00 --- debug: Session Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Auth Library loaded
2010-03-31 09:27:33 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:27:33 +02:00 --- debug: Database Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:27:33 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:27:33 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:27:33 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:27:33 +02:00 --- debug: Database Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Session Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Auth Library loaded
2010-03-31 09:27:33 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:27:33 +02:00 --- debug: Auth Library loaded
2010-03-31 09:28:00 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:28:00 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:28:00 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:28:00 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:28:00 +02:00 --- debug: Database Library initialized
2010-03-31 09:28:00 +02:00 --- debug: Session Library initialized
2010-03-31 09:28:00 +02:00 --- debug: Auth Library loaded
2010-03-31 09:28:00 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:28:03 +02:00 --- debug: Auth Library loaded
2010-03-31 09:32:59 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:32:59 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:32:59 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:32:59 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:32:59 +02:00 --- debug: Database Library initialized
2010-03-31 09:32:59 +02:00 --- debug: Session Library initialized
2010-03-31 09:32:59 +02:00 --- debug: Auth Library loaded
2010-03-31 09:32:59 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:32:59 +02:00 --- debug: Auth Library loaded
2010-03-31 09:36:03 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:36:03 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:36:03 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:36:04 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:36:04 +02:00 --- debug: Database Library initialized
2010-03-31 09:36:04 +02:00 --- debug: Session Library initialized
2010-03-31 09:36:04 +02:00 --- debug: Auth Library loaded
2010-03-31 09:36:04 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:36:04 +02:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Table 'wadmin.qa_checks_qa_problems q' doesn't exist - SELECT `resources`.*
FROM `resources`
JOIN `qa_checks_qa_problems q` ON (`q`.`qa_check_id` = `qa_check`.`id`)
WHERE `resources`.`id` = 477
ORDER BY `resources`.`title` ASC
LIMIT 0, 1 in file D:/xampplite/htdocs/wadmin/system/libraries/drivers/Database/Mysql.php on line 367
2010-03-31 09:36:15 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:36:15 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:36:15 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:36:15 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:36:15 +02:00 --- debug: Database Library initialized
2010-03-31 09:36:15 +02:00 --- debug: Session Library initialized
2010-03-31 09:36:15 +02:00 --- debug: Auth Library loaded
2010-03-31 09:36:15 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:36:15 +02:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column 'qa_check.id' in 'on clause' - SELECT `resources`.*
FROM `resources`
JOIN `qa_checks_qa_problems` AS `q` ON (`q`.`qa_check_id` = `qa_check`.`id`)
WHERE `resources`.`id` = 477
ORDER BY `resources`.`title` ASC
LIMIT 0, 1 in file D:/xampplite/htdocs/wadmin/system/libraries/drivers/Database/Mysql.php on line 367
2010-03-31 09:36:35 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:36:35 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:36:35 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:36:35 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:36:35 +02:00 --- debug: Database Library initialized
2010-03-31 09:36:35 +02:00 --- debug: Session Library initialized
2010-03-31 09:36:35 +02:00 --- debug: Auth Library loaded
2010-03-31 09:36:35 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:36:35 +02:00 --- error: Uncaught Kohana_Database_Exception: There was an SQL error: Unknown column 'qa_checks.id' in 'on clause' - SELECT `resources`.*
FROM `resources`
JOIN `qa_checks_qa_problems` AS `q` ON (`q`.`qa_check_id` = `qa_checks`.`id`)
WHERE `resources`.`id` = 477
ORDER BY `resources`.`title` ASC
LIMIT 0, 1 in file D:/xampplite/htdocs/wadmin/system/libraries/drivers/Database/Mysql.php on line 367
2010-03-31 09:37:28 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:37:28 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:37:28 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:37:28 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:37:28 +02:00 --- debug: Database Library initialized
2010-03-31 09:37:28 +02:00 --- debug: Session Library initialized
2010-03-31 09:37:28 +02:00 --- debug: Auth Library loaded
2010-03-31 09:37:29 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:37:29 +02:00 --- debug: Auth Library loaded
2010-03-31 09:38:55 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:38:55 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:38:55 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:38:55 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:38:55 +02:00 --- debug: Database Library initialized
2010-03-31 09:38:55 +02:00 --- debug: Session Library initialized
2010-03-31 09:38:55 +02:00 --- debug: Auth Library loaded
2010-03-31 09:38:55 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:38:58 +02:00 --- debug: Auth Library loaded
2010-03-31 09:52:34 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 09:52:34 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 09:52:34 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 09:52:34 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 09:52:34 +02:00 --- debug: Database Library initialized
2010-03-31 09:52:34 +02:00 --- debug: Session Library initialized
2010-03-31 09:52:34 +02:00 --- debug: Auth Library loaded
2010-03-31 09:52:34 +02:00 --- debug: Profiler Library initialized
2010-03-31 09:52:34 +02:00 --- debug: Auth Library loaded
2010-03-31 15:12:27 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:12:27 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:12:27 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:12:27 +02:00 --- debug: Session Library initialized
2010-03-31 15:12:27 +02:00 --- debug: Auth Library loaded
2010-03-31 15:12:28 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:12:28 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:12:28 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:12:28 +02:00 --- debug: Session Library initialized
2010-03-31 15:12:28 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:12:28 +02:00 --- debug: Auth Library loaded
2010-03-31 15:12:36 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:12:36 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:12:36 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:12:36 +02:00 --- debug: Session Library initialized
2010-03-31 15:12:36 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:12:36 +02:00 --- debug: Auth Library loaded
2010-03-31 15:12:36 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:12:36 +02:00 --- debug: Database Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:12:48 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:12:48 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:12:48 +02:00 --- debug: Session Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Auth Library loaded
2010-03-31 15:12:48 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:12:48 +02:00 --- debug: Database Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:12:48 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:12:48 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:12:48 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:12:48 +02:00 --- debug: Database Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Session Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Auth Library loaded
2010-03-31 15:12:48 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:12:48 +02:00 --- debug: Auth Library loaded
2010-03-31 15:13:10 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:13:10 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:13:10 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:13:10 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:13:10 +02:00 --- debug: Database Library initialized
2010-03-31 15:13:10 +02:00 --- debug: Session Library initialized
2010-03-31 15:13:10 +02:00 --- debug: Auth Library loaded
2010-03-31 15:13:10 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:13:11 +02:00 --- debug: Auth Library loaded
2010-03-31 15:14:41 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:14:41 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:14:41 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:14:41 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:14:41 +02:00 --- debug: Database Library initialized
2010-03-31 15:14:41 +02:00 --- debug: Session Library initialized
2010-03-31 15:14:41 +02:00 --- debug: Auth Library loaded
2010-03-31 15:14:41 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:14:41 +02:00 --- debug: Auth Library loaded
2010-03-31 15:15:00 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:15:00 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:15:00 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:15:00 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:15:00 +02:00 --- debug: Database Library initialized
2010-03-31 15:15:00 +02:00 --- debug: Session Library initialized
2010-03-31 15:15:00 +02:00 --- debug: Auth Library loaded
2010-03-31 15:15:00 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:15:01 +02:00 --- debug: Auth Library loaded
2010-03-31 15:15:37 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:15:37 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:15:37 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:15:37 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:15:37 +02:00 --- debug: Database Library initialized
2010-03-31 15:15:37 +02:00 --- debug: Session Library initialized
2010-03-31 15:15:37 +02:00 --- debug: Auth Library loaded
2010-03-31 15:15:37 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:15:37 +02:00 --- debug: Auth Library loaded
2010-03-31 15:27:59 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:27:59 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:27:59 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:27:59 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:27:59 +02:00 --- debug: Database Library initialized
2010-03-31 15:27:59 +02:00 --- debug: Session Library initialized
2010-03-31 15:27:59 +02:00 --- debug: Auth Library loaded
2010-03-31 15:27:59 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:27:59 +02:00 --- debug: Auth Library loaded
2010-03-31 15:28:50 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:28:50 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:28:50 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:28:50 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:28:50 +02:00 --- debug: Database Library initialized
2010-03-31 15:28:50 +02:00 --- debug: Session Library initialized
2010-03-31 15:28:50 +02:00 --- debug: Auth Library loaded
2010-03-31 15:28:50 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:28:50 +02:00 --- debug: Auth Library loaded
2010-03-31 15:29:26 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:29:26 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:29:26 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:29:26 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:29:26 +02:00 --- debug: Database Library initialized
2010-03-31 15:29:26 +02:00 --- debug: Session Library initialized
2010-03-31 15:29:26 +02:00 --- debug: Auth Library loaded
2010-03-31 15:29:26 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:29:26 +02:00 --- debug: Auth Library loaded
2010-03-31 15:30:00 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:30:00 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:30:00 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:30:00 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:30:00 +02:00 --- debug: Database Library initialized
2010-03-31 15:30:00 +02:00 --- debug: Session Library initialized
2010-03-31 15:30:00 +02:00 --- debug: Auth Library loaded
2010-03-31 15:30:00 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:30:00 +02:00 --- error: Uncaught PHP Error: Undefined variable: qa_check in file D:/xampplite/htdocs/wadmin/application/views/tables/record_qa_view.php on line 42
2010-03-31 15:30:43 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:30:43 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:30:43 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:30:43 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:30:43 +02:00 --- debug: Database Library initialized
2010-03-31 15:30:43 +02:00 --- debug: Session Library initialized
2010-03-31 15:30:43 +02:00 --- debug: Auth Library loaded
2010-03-31 15:30:44 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:30:44 +02:00 --- debug: Auth Library loaded
2010-03-31 15:41:30 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:41:30 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:41:30 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:41:30 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:41:30 +02:00 --- debug: Database Library initialized
2010-03-31 15:41:30 +02:00 --- debug: Session Library initialized
2010-03-31 15:41:30 +02:00 --- debug: Auth Library loaded
2010-03-31 15:41:30 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:41:30 +02:00 --- debug: Auth Library loaded
2010-03-31 15:41:57 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:41:57 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:41:57 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:41:57 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:41:57 +02:00 --- debug: Database Library initialized
2010-03-31 15:41:57 +02:00 --- debug: Session Library initialized
2010-03-31 15:41:57 +02:00 --- debug: Auth Library loaded
2010-03-31 15:41:57 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:41:57 +02:00 --- debug: Auth Library loaded
2010-03-31 15:47:36 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:47:36 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:47:36 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:47:36 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:47:36 +02:00 --- debug: Database Library initialized
2010-03-31 15:47:36 +02:00 --- debug: Session Library initialized
2010-03-31 15:47:36 +02:00 --- debug: Auth Library loaded
2010-03-31 15:47:36 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:47:36 +02:00 --- debug: Auth Library loaded
2010-03-31 15:47:55 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:47:55 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:47:55 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:47:55 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:47:55 +02:00 --- debug: Database Library initialized
2010-03-31 15:47:55 +02:00 --- debug: Session Library initialized
2010-03-31 15:47:55 +02:00 --- debug: Auth Library loaded
2010-03-31 15:47:55 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:47:55 +02:00 --- error: Uncaught PHP Error: Undefined property: ORM_Iterator::$problem in file D:/xampplite/htdocs/wadmin/application/views/tables/record_qa_view.php on line 28
2010-03-31 15:48:36 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:48:36 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:48:36 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:48:36 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:48:36 +02:00 --- debug: Database Library initialized
2010-03-31 15:48:36 +02:00 --- debug: Session Library initialized
2010-03-31 15:48:36 +02:00 --- debug: Auth Library loaded
2010-03-31 15:48:36 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:48:36 +02:00 --- debug: Auth Library loaded
2010-03-31 15:48:48 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:48:48 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:48:48 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:48:48 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:48:48 +02:00 --- debug: Database Library initialized
2010-03-31 15:48:48 +02:00 --- debug: Session Library initialized
2010-03-31 15:48:48 +02:00 --- debug: Auth Library loaded
2010-03-31 15:48:48 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:48:48 +02:00 --- debug: Auth Library loaded
2010-03-31 15:49:10 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:49:10 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:49:10 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:49:10 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:49:10 +02:00 --- debug: Database Library initialized
2010-03-31 15:49:10 +02:00 --- debug: Session Library initialized
2010-03-31 15:49:10 +02:00 --- debug: Auth Library loaded
2010-03-31 15:49:10 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:49:10 +02:00 --- debug: Auth Library loaded
2010-03-31 15:50:40 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:50:40 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:50:40 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:50:40 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:50:40 +02:00 --- debug: Database Library initialized
2010-03-31 15:50:40 +02:00 --- debug: Session Library initialized
2010-03-31 15:50:40 +02:00 --- debug: Auth Library loaded
2010-03-31 15:50:40 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:50:40 +02:00 --- debug: Auth Library loaded
2010-03-31 15:50:54 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:50:54 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:50:54 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:50:54 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:50:54 +02:00 --- debug: Database Library initialized
2010-03-31 15:50:54 +02:00 --- debug: Session Library initialized
2010-03-31 15:50:54 +02:00 --- debug: Auth Library loaded
2010-03-31 15:50:54 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:50:54 +02:00 --- debug: Auth Library loaded
2010-03-31 15:52:16 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:52:16 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:52:16 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:52:16 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:52:16 +02:00 --- debug: Database Library initialized
2010-03-31 15:52:16 +02:00 --- debug: Session Library initialized
2010-03-31 15:52:16 +02:00 --- debug: Auth Library loaded
2010-03-31 15:52:16 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:52:16 +02:00 --- debug: Auth Library loaded
2010-03-31 15:53:43 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:53:43 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:53:43 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:53:43 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:53:43 +02:00 --- debug: Database Library initialized
2010-03-31 15:53:43 +02:00 --- debug: Session Library initialized
2010-03-31 15:53:43 +02:00 --- debug: Auth Library loaded
2010-03-31 15:53:43 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:53:43 +02:00 --- debug: Auth Library loaded
2010-03-31 15:56:55 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:56:55 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:56:55 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:56:55 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:56:55 +02:00 --- debug: Database Library initialized
2010-03-31 15:56:55 +02:00 --- debug: Session Library initialized
2010-03-31 15:56:55 +02:00 --- debug: Auth Library loaded
2010-03-31 15:56:55 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:56:55 +02:00 --- debug: Auth Library loaded
2010-03-31 15:57:42 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:57:42 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:57:42 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:57:42 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:57:42 +02:00 --- debug: Database Library initialized
2010-03-31 15:57:42 +02:00 --- debug: Session Library initialized
2010-03-31 15:57:42 +02:00 --- debug: Auth Library loaded
2010-03-31 15:57:42 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:57:43 +02:00 --- debug: Auth Library loaded
2010-03-31 15:58:00 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:58:00 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:58:00 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:58:00 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:58:00 +02:00 --- debug: Database Library initialized
2010-03-31 15:58:00 +02:00 --- debug: Session Library initialized
2010-03-31 15:58:00 +02:00 --- debug: Auth Library loaded
2010-03-31 15:58:00 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:58:00 +02:00 --- debug: Auth Library loaded
2010-03-31 15:58:47 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 15:58:47 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 15:58:47 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 15:58:48 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 15:58:48 +02:00 --- debug: Database Library initialized
2010-03-31 15:58:48 +02:00 --- debug: Session Library initialized
2010-03-31 15:58:48 +02:00 --- debug: Auth Library loaded
2010-03-31 15:58:48 +02:00 --- debug: Profiler Library initialized
2010-03-31 15:58:48 +02:00 --- debug: Auth Library loaded
2010-03-31 16:07:35 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:07:35 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:07:35 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:07:35 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:07:35 +02:00 --- debug: Database Library initialized
2010-03-31 16:07:35 +02:00 --- debug: Session Library initialized
2010-03-31 16:07:35 +02:00 --- debug: Auth Library loaded
2010-03-31 16:07:35 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:07:36 +02:00 --- error: Uncaught PHP Error: Undefined variable: qa_problem in file D:/xampplite/htdocs/wadmin/application/views/tables/record_qa_view.php on line 39
2010-03-31 16:07:45 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:07:45 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:07:45 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:07:45 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:07:45 +02:00 --- debug: Database Library initialized
2010-03-31 16:07:45 +02:00 --- debug: Session Library initialized
2010-03-31 16:07:45 +02:00 --- debug: Auth Library loaded
2010-03-31 16:07:45 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:07:46 +02:00 --- debug: Auth Library loaded
2010-03-31 16:08:15 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:08:15 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:08:15 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:08:16 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:08:16 +02:00 --- debug: Database Library initialized
2010-03-31 16:08:16 +02:00 --- debug: Session Library initialized
2010-03-31 16:08:16 +02:00 --- debug: Auth Library loaded
2010-03-31 16:08:16 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:08:16 +02:00 --- debug: Auth Library loaded
2010-03-31 16:08:32 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:08:32 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:08:32 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:08:32 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:08:32 +02:00 --- debug: Database Library initialized
2010-03-31 16:08:32 +02:00 --- debug: Session Library initialized
2010-03-31 16:08:32 +02:00 --- debug: Auth Library loaded
2010-03-31 16:08:32 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:08:33 +02:00 --- debug: Auth Library loaded
2010-03-31 16:09:23 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:09:23 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:09:23 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:09:23 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:09:23 +02:00 --- debug: Database Library initialized
2010-03-31 16:09:23 +02:00 --- debug: Session Library initialized
2010-03-31 16:09:23 +02:00 --- debug: Auth Library loaded
2010-03-31 16:09:23 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:09:23 +02:00 --- debug: Auth Library loaded
2010-03-31 16:09:33 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:09:33 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:09:33 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:09:33 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:09:33 +02:00 --- debug: Database Library initialized
2010-03-31 16:09:33 +02:00 --- debug: Session Library initialized
2010-03-31 16:09:33 +02:00 --- debug: Auth Library loaded
2010-03-31 16:09:33 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:09:33 +02:00 --- debug: Auth Library loaded
2010-03-31 16:09:59 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:09:59 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:09:59 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:09:59 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:09:59 +02:00 --- debug: Database Library initialized
2010-03-31 16:09:59 +02:00 --- debug: Session Library initialized
2010-03-31 16:09:59 +02:00 --- debug: Auth Library loaded
2010-03-31 16:09:59 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:09:59 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:10:19 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:10:19 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:10:19 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:10:19 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:10:19 +02:00 --- debug: Database Library initialized
2010-03-31 16:10:19 +02:00 --- debug: Session Library initialized
2010-03-31 16:10:19 +02:00 --- debug: Auth Library loaded
2010-03-31 16:10:19 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:10:19 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:11:35 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:11:35 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:11:35 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:11:35 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:11:35 +02:00 --- debug: Database Library initialized
2010-03-31 16:11:35 +02:00 --- debug: Session Library initialized
2010-03-31 16:11:35 +02:00 --- debug: Auth Library loaded
2010-03-31 16:11:35 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:11:35 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:11:54 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:11:54 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:11:54 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:11:54 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:11:54 +02:00 --- debug: Database Library initialized
2010-03-31 16:11:54 +02:00 --- debug: Session Library initialized
2010-03-31 16:11:54 +02:00 --- debug: Auth Library loaded
2010-03-31 16:11:54 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:11:54 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:12:56 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:12:56 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:12:56 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:12:56 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:12:56 +02:00 --- debug: Database Library initialized
2010-03-31 16:12:56 +02:00 --- debug: Session Library initialized
2010-03-31 16:12:56 +02:00 --- debug: Auth Library loaded
2010-03-31 16:12:56 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:12:56 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:16:30 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:16:30 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:16:30 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:16:30 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:16:30 +02:00 --- debug: Database Library initialized
2010-03-31 16:16:30 +02:00 --- debug: Session Library initialized
2010-03-31 16:16:30 +02:00 --- debug: Auth Library loaded
2010-03-31 16:16:30 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:16:30 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:16:40 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:16:40 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:16:40 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:16:40 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:16:40 +02:00 --- debug: Database Library initialized
2010-03-31 16:16:40 +02:00 --- debug: Session Library initialized
2010-03-31 16:16:41 +02:00 --- debug: Auth Library loaded
2010-03-31 16:16:41 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:16:41 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:16:46 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:16:46 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:16:46 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:16:46 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:16:46 +02:00 --- debug: Database Library initialized
2010-03-31 16:16:46 +02:00 --- debug: Session Library initialized
2010-03-31 16:16:46 +02:00 --- debug: Auth Library loaded
2010-03-31 16:16:46 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:16:46 +02:00 --- error: Uncaught PHP Error: Undefined variable: qa_cp in file D:/xampplite/htdocs/wadmin/application/views/tables/record_qa_view.php on line 42
2010-03-31 16:16:54 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:16:54 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:16:54 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:16:54 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:16:54 +02:00 --- debug: Database Library initialized
2010-03-31 16:16:54 +02:00 --- debug: Session Library initialized
2010-03-31 16:16:54 +02:00 --- debug: Auth Library loaded
2010-03-31 16:16:54 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:16:54 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:19:42 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:19:42 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:19:42 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:19:42 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:19:42 +02:00 --- debug: Database Library initialized
2010-03-31 16:19:42 +02:00 --- debug: Session Library initialized
2010-03-31 16:19:42 +02:00 --- debug: Auth Library loaded
2010-03-31 16:19:42 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:19:42 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:20:22 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:20:22 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:20:22 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:20:22 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:20:22 +02:00 --- debug: Database Library initialized
2010-03-31 16:20:22 +02:00 --- debug: Session Library initialized
2010-03-31 16:20:22 +02:00 --- debug: Auth Library loaded
2010-03-31 16:20:22 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:20:41 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:20:41 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:20:41 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:20:41 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:20:41 +02:00 --- debug: Database Library initialized
2010-03-31 16:20:41 +02:00 --- debug: Session Library initialized
2010-03-31 16:20:41 +02:00 --- debug: Auth Library loaded
2010-03-31 16:20:41 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:20:41 +02:00 --- error: Uncaught PHP Error: Invalid argument supplied for foreach() in file D:/xampplite/htdocs/wadmin/system/libraries/ORM.php on line 1371
2010-03-31 16:21:30 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 16:21:30 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 16:21:30 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 16:21:30 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 16:21:30 +02:00 --- debug: Database Library initialized
2010-03-31 16:21:30 +02:00 --- debug: Session Library initialized
2010-03-31 16:21:30 +02:00 --- debug: Auth Library loaded
2010-03-31 16:21:30 +02:00 --- debug: Profiler Library initialized
2010-03-31 16:21:30 +02:00 --- error: Uncaught PHP Error: Undefined variable: qa_cp in file D:/xampplite/htdocs/wadmin/application/views/tables/record_qa_view.php on line 42
2010-03-31 18:25:19 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 18:25:19 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 18:25:19 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 18:25:19 +02:00 --- debug: Session Library initialized
2010-03-31 18:25:19 +02:00 --- debug: Auth Library loaded
2010-03-31 18:25:19 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 18:25:19 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 18:25:19 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 18:25:19 +02:00 --- debug: Session Library initialized
2010-03-31 18:25:19 +02:00 --- debug: Profiler Library initialized
2010-03-31 18:25:19 +02:00 --- debug: Auth Library loaded
2010-03-31 18:25:30 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 18:25:30 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 18:25:30 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 18:25:30 +02:00 --- debug: Session Library initialized
2010-03-31 18:25:30 +02:00 --- debug: Profiler Library initialized
2010-03-31 18:25:30 +02:00 --- debug: Auth Library loaded
2010-03-31 18:25:30 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 18:25:30 +02:00 --- debug: Database Library initialized
2010-03-31 18:25:30 +02:00 --- debug: Disable magic_quotes_gpc! It is evil and deprecated: http://php.net/magic_quotes
2010-03-31 18:25:30 +02:00 --- debug: Global GET, POST and COOKIE data sanitized
2010-03-31 18:25:30 +02:00 --- debug: Session Cookie Driver Initialized
2010-03-31 18:25:30 +02:00 --- debug: MySQL Database Driver Initialized
2010-03-31 18:25:30 +02:00 --- debug: Database Library initialized
2010-03-31 18:25:30 +02:00 --- debug: Session Library initialized
2010-03-31 18:25:30 +02:00 --- debug: Auth Library loaded
2010-03-31 18:25:30 +02:00 --- debug: Profiler Library initialized
2010-03-31 18:25:30 +02:00 --- error: Uncaught PHP Error: Undefined variable: qa_cp in file D:/xampplite/htdocs/wadmin/application/views/tables/record_qa_view.php on line 42
