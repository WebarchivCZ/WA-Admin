-- Create new table for seed types (rich media, audio, etc.)
CREATE TABLE `seed_types` (
  `id`       INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type`     VARCHAR(100) NOT NULL,
  `comments` TEXT         NULL
)
  ENGINE = INNODB;

-- Update seeds table
ALTER TABLE `seeds` ADD `seed_type_id` INT UNSIGNED NULL
AFTER `seed_status_id`;
ALTER TABLE `seeds` ADD INDEX (`seed_type_id`);
ALTER TABLE `seeds` ADD FOREIGN KEY (`seed_type_id`)
REFERENCES `seed_types` (`id`);

-- Add standard types of seeds
INSERT INTO `wadmin-test`.`seed_types` (
  `id`,
  `type`,
  `comments`
)
  VALUES (
    NULL, 'normal', NULL
  ), (
    NULL, 'youtube', NULL
  );


-- Update database version info
UPDATE `application_info`
SET `value` = '12', `date_changed` = NOW()
WHERE `key` = 'database_version';