ALTER TABLE  `contracts` CHANGE  `comments`  `comments` TEXT CHARACTER SET utf8 COLLATE utf8_czech_ci NULL DEFAULT NULL;
UPDATE contracts SET comments = NULL WHERE comments = '';