-- Create new table rating_rounds representing rating round for each resource.
-- One resource can have several rating rounds, each round containing ratings from active curators.
CREATE TABLE `rating_rounds` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  `resource_id` INT UNSIGNED NOT NULL,
  INDEX(`resource_id`),
  `round` TINYINT UNSIGNED NOT NULL,
  `rating_result` TINYINT NULL ,
  `date_created` DATETIME NOT NULL ,
  `date_closed` DATETIME NULL ,
  `curator_id` INT UNSIGNED NULL ,
  FOREIGN KEY ( `resource_id` ) REFERENCES `resources` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE ,
  FOREIGN KEY ( `curator_id` ) REFERENCES `curators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE ,
  UNIQUE  `resource_unique` ( `resource_id` , `round` )
) ENGINE = INNODB;

-- Fill table RATING_ROUNDS with data from RATINGS table
INSERT INTO
        rating_rounds( resource_id, round, rating_result, date_created, date_closed, curator_id )
          SELECT r.id, round, r.rating_result, MIN( t.date ) , MAX( t.date ) , r.curator_id
  FROM resources r
          JOIN
          (ratings t) ON ( r.id = t.resource_id )
  GROUP BY r.id, round
  ORDER BY MIN( t.date );

-- Add round_id reference to RATINGS table
ALTER TABLE `ratings`
ADD `round_id` INT UNSIGNED NULL AFTER `date`,
ADD FOREIGN KEY ( `round_id` ) REFERENCES `rating_rounds` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
ADD INDEX (`round_id`);

-- Insert round_id into RATINGS table
UPDATE ratings,
        rating_rounds
  SET ratings.round_id = rating_rounds.id
  WHERE rating_rounds.resource_id = ratings.resource_id AND
          rating_rounds.round = ratings.round;

-- Clean date_closed from rating_rounds table for not finalized ratings on resources
update rating_rounds, resources
  set rating_rounds.date_closed = null
  where rating_rounds.resource_id = resources.id and
          resources.resource_status_id = 1 and
          rating_rounds.rating_result IS null

-- Drop ROUND column
ALTER TABLE `ratings` DROP COLUMN `round`;

-- Update database version info
UPDATE `application_info`
  SET `value` = '8', `date_changed` = NOW( )
  WHERE `key` = 'database_version';

