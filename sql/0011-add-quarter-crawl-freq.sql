INSERT INTO crawl_freq (frequency) VALUES ('4x ročně');

-- Update database version info
UPDATE `application_info`
SET `value` = '11', `date_changed` = NOW()
WHERE `key` = 'database_version';