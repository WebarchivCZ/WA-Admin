UPDATE `ratings`
SET curator_id = 57
WHERE curator_id = 48 AND date >= '2012-09-01';

UPDATE `ratings`
SET curator_id = 58
WHERE curator_id = 53 AND date >= '2012-09-01';

-- Update database version info
UPDATE `application_info`
SET `value` = '10', `date_changed` = NOW()
WHERE `key` = 'database_version';

