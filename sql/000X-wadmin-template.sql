-- Update database version info
-- TODO replace INSERT_INCREASED_NUMBER with correct value
UPDATE `application_info` SET `value` = 'INSERT_INCREASED_NUMBER', `date_changed` = NOW( ) WHERE `key` = 'database_version';