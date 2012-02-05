ALTER TABLE  `contracts` ADD  `parent_id` INT UNSIGNED NULL AFTER  `id` ;
ALTER TABLE  `contracts` ADD INDEX (  `parent_id` );
ALTER TABLE  `contracts` ADD FOREIGN KEY (  `parent_id` ) REFERENCES  `wadmin`.`contracts` (
`id`
) ON DELETE RESTRICT ON UPDATE CASCADE ;
ALTER TABLE  `resources` ADD FOREIGN KEY (  `curator_id` ) REFERENCES  `wadmin`.`curators` (
`id`
) ON DELETE RESTRICT ON UPDATE CASCADE ;
