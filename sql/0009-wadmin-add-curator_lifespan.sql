-- Add curator active timeframe
ALTER TABLE  `curators` ADD  `active_from` DATE NULL AFTER  `active` ,
ADD  `active_to` DATE NULL AFTER  `active_from`;

-- Clear non used column
ALTER TABLE curators DROP COLUMN roles_id;

-- Add curator roles
INSERT INTO  `curators_roles` (`curator_id`, `role_id`)
  VALUES ('48', '2'), ('49', '2'), ('50', '2'), ('51', '2'), ('53', '2');

-- Set default time frame for active/past curators
UPDATE  `curators` SET `active_from` = '2008-01-01', `active_to` =  '2012-05-30' WHERE  `curators`.`username` = 'coufal' LIMIT 1 ;
UPDATE  `curators` SET `active_from` = '2008-01-01', `active_to` = '2010-08-31' WHERE  `curators`.`username` = 'sibek' LIMIT 1 ;
UPDATE  `curators` SET `active_from` = '2008-01-01', `active_to` = '2011-08-31' WHERE  `curators`.`username` = 'gruber' LIMIT 1 ;
UPDATE  `curators` SET  `active_from` = '2008-01-01', `active_to` = '2011-06-30' WHERE  `curators`.`username` = 'hrdlickova' LIMIT 1 ;
UPDATE  `curators` SET  `active_from` = '2010-09-01',  `active_to` =  '2012-10-30' WHERE  `curators`.`username` = 'kratochvilova' LIMIT 1 ;

-- Update database version info
UPDATE `application_info`
  SET `value` = '9', `date_changed` = NOW( )
  WHERE `key` = 'database_version';

