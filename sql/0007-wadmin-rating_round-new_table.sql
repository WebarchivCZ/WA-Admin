CREATE TABLE  `rating_rounds` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`resource_id` INT UNSIGNED NOT NULL, INDEX(`resource_id`),
`round` TINYINT UNSIGNED NOT NULL,
`rating_result` TINYINT NULL ,
`date_created` DATETIME NOT NULL ,
`date_closed` DATETIME NULL ,
`closing_curator` INT UNSIGNED NULL, INDEX(`resource_id`)
) ENGINE = INNODB;

ALTER TABLE  `rating_rounds` ADD FOREIGN KEY (  `closing_curator` ) REFERENCES `curators` (
`id`
) ON DELETE SET NULL ON UPDATE CASCADE ;
ALTER TABLE  `rating_rounds` ADD FOREIGN KEY (  `resource_id` ) REFERENCES `resources` (
`id`
) ON DELETE NO ACTION ON UPDATE CASCADE ;


ALTER TABLE  `rating_rounds` ADD UNIQUE  `resource_unique` (  `resource_id` ,  `round` );

INSERT INTO rating_rounds( resource_id, round, rating_result, date_created, date_closed, closing_curator )
SELECT r.id, round, r.rating_result, MIN( t.date ) , MAX( t.date ) , r.curator_id
FROM resources r
JOIN (
ratings t
) ON ( r.id = t.resource_id )
GROUP BY r.id, round
ORDER BY MIN( t.date );