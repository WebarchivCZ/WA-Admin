-- Create new table for storing application info
CREATE TABLE `application_info` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
`key` VARCHAR( 255 ) NOT NULL UNIQUE,
`value` VARCHAR( 255 ) NULL ,
`group` VARCHAR( 4 ) NOT NULL,
`description` VARCHAR( 255 ) NULL ,
`date_created` DATETIME NOT NULL ,
`date_changed` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NULL DEFAULT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = InnoDB;

-- Fill basic application info values
INSERT INTO `application_info` (
`key` ,
`value` ,
`group` ,
`description` ,
`date_created` ,
`date_changed`
)
VALUES
('application_name', 'WA Admin', 'APP', 'Name of application.', NOW( ) , NOW( )),
('application_version', '2', 'APP', 'Major version of application.', NOW( ) , NOW( )),
('application_build', '36', 'APP', 'Minor version of application. This is increased with new deployed changes.', NOW( ) , NOW( )),
('database_version', '1', 'DB', 'Version of database.', NOW( ) , NOW( )),
('database_production_db_name', 'wadmin', 'DB', 'Name of production DB.', NOW( ) , NOW( )),
('database_test_db_name', 'wadmin-test', 'DB', 'Name of production DB.', NOW( ) , NOW( )),
('application_debug_mode', 'TRUE', 'APP', 'TRUE if deployed instance is running in debug mode.', NOW( ) , NOW( ));

-- Update database version info
UPDATE `application_info` SET `value` = '7', `date_changed` = NOW( ) WHERE `key` = 'database_version';
