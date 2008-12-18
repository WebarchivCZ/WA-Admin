SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `waTest` DEFAULT CHARACTER SET utf8 COLLATE utf8_czech_ci ;
USE `waTest`;

-- -----------------------------------------------------
-- Table `waTest`.`conspectus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`conspectus` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`conspectus` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `category` VARCHAR(255) NOT NULL ,
  `comments` VARCHAR(255) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`publishers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`publishers` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`publishers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`contacts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`contacts` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`contacts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `publisher_id` INT UNSIGNED NOT NULL ,
  `name` VARCHAR(255) NULL DEFAULT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `phone` INT UNSIGNED NULL DEFAULT NULL ,
  `address` VARCHAR(255) NULL DEFAULT NULL ,
  `position` VARCHAR(45) NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_contacts_publishers`
    FOREIGN KEY (`publisher_id` )
    REFERENCES `waTest`.`publishers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
PACK_KEYS = DEFAULT;

CREATE INDEX `fk_contacts_publishers` ON `waTest`.`contacts` (`publisher_id` ASC) ;


-- -----------------------------------------------------
-- Table `waTest`.`contracts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`contracts` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`contracts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `contract_no` VARCHAR(255) UNIQUE NOT NULL ,
  `date_signed` DATE NULL DEFAULT NULL ,
  `addendum` BOOLEAN NULL ,
  `cc` BOOLEAN NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
COMMENT = 'Cislo smlouvy - \"YEAR(date_signed)-contract_no\"';


-- -----------------------------------------------------
-- Table `waTest`.`roles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`roles` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`roles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `role` VARCHAR(45) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`curators`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`curators` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`curators` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(50) NOT NULL ,
  `roles_id` INT NULL ,
  `firstname` VARCHAR(50) NOT NULL ,
  `lastname` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(255) NOT NULL ,
  `icq` INT UNSIGNED NULL DEFAULT NULL ,
  `skype` VARCHAR(200) NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_curators_roles`
    FOREIGN KEY (`roles_id` )
    REFERENCES `waTest`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_curators_roles` ON `waTest`.`curators` (`roles_id` ASC) ;


-- -----------------------------------------------------
-- Table `waTest`.`crawl_freq`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`crawl_freq` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`crawl_freq` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `frequency` VARCHAR(45) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`resource_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`resource_status` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`resource_status` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `status` VARCHAR(45) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`suggested_by`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`suggested_by` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`suggested_by` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `proposer` VARCHAR(45) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`resources`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`resources` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`resources` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `curator_id` INT UNSIGNED NOT NULL ,
  `contact_id` INT UNSIGNED NULL ,
  `publisher_id` INT UNSIGNED NOT NULL ,
  `contract_id` INT UNSIGNED NULL ,
  `conspectus_id` INT UNSIGNED NOT NULL ,
  `crawl_freq_id` INT NULL ,
  `resource_status_id` INT NULL ,
  `suggested_by_id` INT NOT NULL ,
  `title` VARCHAR(200) NOT NULL ,
  `url` VARCHAR(255) NOT NULL ,
  `rating_result` SMALLINT UNSIGNED NULL DEFAULT NULL ,
  `date` DATETIME NULL ,
  `aleph_id` VARCHAR(100) NULL DEFAULT NULL ,
  `ISSN` VARCHAR(20) NULL DEFAULT NULL ,
  `metadata` DATETIME NULL DEFAULT NULL ,
  `catalogued` DATETIME NULL DEFAULT NULL ,
  `creative_commons` BOOLEAN NULL DEFAULT NULL ,
  `tech_problems` TEXT NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_resources_conspectus`
    FOREIGN KEY (`conspectus_id` )
    REFERENCES `waTest`.`conspectus` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_contracts`
    FOREIGN KEY (`contract_id` )
    REFERENCES `waTest`.`contracts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_curators`
    FOREIGN KEY (`curator_id` )
    REFERENCES `waTest`.`curators` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_publishers`
    FOREIGN KEY (`publisher_id` )
    REFERENCES `waTest`.`publishers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_contacts`
    FOREIGN KEY (`contact_id` )
    REFERENCES `waTest`.`contacts` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_crawl_freq`
    FOREIGN KEY (`crawl_freq_id` )
    REFERENCES `waTest`.`crawl_freq` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_resource_status`
    FOREIGN KEY (`resource_status_id` )
    REFERENCES `waTest`.`resource_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resources_suggested_by`
    FOREIGN KEY (`suggested_by_id` )
    REFERENCES `waTest`.`suggested_by` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_resources_conspectus` ON `waTest`.`resources` (`conspectus_id` ASC) ;

CREATE INDEX `fk_resources_contracts` ON `waTest`.`resources` (`contract_id` ASC) ;

CREATE INDEX `fk_resources_curators` ON `waTest`.`resources` (`curator_id` ASC) ;

CREATE INDEX `fk_resources_publishers` ON `waTest`.`resources` (`publisher_id` ASC) ;

CREATE INDEX `fk_resources_contacts` ON `waTest`.`resources` (`contact_id` ASC) ;

CREATE INDEX `fk_resources_crawl_freq` ON `waTest`.`resources` (`crawl_freq_id` ASC) ;

CREATE INDEX `fk_resources_resource_status` ON `waTest`.`resources` (`resource_status_id` ASC) ;

CREATE INDEX `fk_resources_suggested_by` ON `waTest`.`resources` (`suggested_by_id` ASC) ;


-- -----------------------------------------------------
-- Table `waTest`.`correspondence_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`correspondence_type` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`correspondence_type` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `type` VARCHAR(45) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`correspondence`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`correspondence` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`correspondence` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `resource_id` INT UNSIGNED NOT NULL ,
  `correspondence_type_id` INT NULL ,
  `date` DATE NOT NULL ,
  `result` SMALLINT UNSIGNED NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_correspondence_resources`
    FOREIGN KEY (`resource_id` )
    REFERENCES `waTest`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_correspondence_correspondence_type`
    FOREIGN KEY (`correspondence_type_id` )
    REFERENCES `waTest`.`correspondence_type` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_correspondence_resources` ON `waTest`.`correspondence` (`resource_id` ASC) ;

CREATE INDEX `fk_correspondence_correspondence_type` ON `waTest`.`correspondence` (`correspondence_type_id` ASC) ;


-- -----------------------------------------------------
-- Table `waTest`.`ratings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`ratings` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`ratings` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `curator_id` INT UNSIGNED NOT NULL ,
  `resource_id` INT UNSIGNED NOT NULL ,
  `rating` SMALLINT UNSIGNED NOT NULL ,
  `date` DATE NOT NULL ,
  `round` INT UNSIGNED NULL DEFAULT NULL ,
  `comments` INT UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_ratings_curators`
    FOREIGN KEY (`curator_id` )
    REFERENCES `waTest`.`curators` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ratings_resources`
    FOREIGN KEY (`resource_id` )
    REFERENCES `waTest`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_ratings_curators` ON `waTest`.`ratings` (`curator_id` ASC) ;

CREATE INDEX `fk_ratings_resources` ON `waTest`.`ratings` (`resource_id` ASC) ;

-- -----------------------------------------------------
-- Table `waTest`.`seeds`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `waTest`.`seeds` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `resource_id` INT UNSIGNED NOT NULL ,
  `url` VARCHAR(255) NOT NULL ,
  `redirect` BOOLEAN NULL DEFAULT NULL ,
  `valid_from` DATE NULL DEFAULT NULL ,
  `valid_to` DATE NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_seeds_resources`
    FOREIGN KEY (`resource_id` )
    REFERENCES `waTest`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_seeds_resources` ON `waTest`.`seeds` (`resource_id` ASC) ;

-- -----------------------------------------------------
-- Table `waTest`.`quality_controls`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`quality_controls` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`quality_controls` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `resources_id` INT UNSIGNED NOT NULL ,
  `date` DATETIME NOT NULL ,
  `result` SMALLINT NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_quality_control_resources`
    FOREIGN KEY (`resources_id` )
    REFERENCES `waTest`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_quality_control_resources` ON `waTest`.`quality_controls` (`resources_id` ASC) ;

USE `waTest`;

-- -----------------------------------------------------
-- Data for table `waTest`.`conspectus`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `conspectus` (`category`, `comments`) VALUES ('matematika', NULL);
INSERT INTO `conspectus` (`category`, `comments`) VALUES ('psychologie', NULL);
INSERT INTO `conspectus` (`category`, `comments`) VALUES ('sociologie', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`curators`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `curators` (`username`, `password`, `roles_id`, `firstname`, `lastname`, `email`, `icq`, `skype`, `comments`) VALUES ('lico', 'brumla', 1, 'Libor', 'Coufal', 'libor.coufal@nkp.cz', NULL, NULL, NULL);
INSERT INTO `curators` (`username`, `password`, `roles_id`, `firstname`, `lastname`, `email`, `icq`, `skype`, `comments`) VALUES ('adam', 'brumla', 3, 'Adam', 'Brokeš', 'brokes@webarchiv.cz', 42799740, 'adam.brokes', NULL);
INSERT INTO `curators` (`username`, `password`, `roles_id`, `firstname`, `lastname`, `email`, `icq`, `skype`, `comments`) VALUES ('sibek', 'brumla', 2, 'Tomáš', 'Šíbek', 'tomas.sibek@nkp.cz', NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`roles`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `roles` (`role`, `comments`) VALUES ('admin', NULL);
INSERT INTO `roles` (`role`, `comments`) VALUES ('curator', NULL);
INSERT INTO `roles` (`role`, `comments`) VALUES ('crawler_manager', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`resource_status`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('nový', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('schválen', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('neschválen', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('ohodnocen', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('k přehodnocení', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('nepovolen vydavatelem', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('povolen vydavatelem', NULL);
INSERT INTO `resource_status` (`status`, `comments`) VALUES ('osloven', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`suggested_by`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `suggested_by` (`proposer`, `comments`) VALUES ('kurátor', NULL);
INSERT INTO `suggested_by` (`proposer`, `comments`) VALUES ('web/vydavatel', NULL);
INSERT INTO `suggested_by` (`proposer`, `comments`) VALUES ('web/návštěvník', NULL);
INSERT INTO `suggested_by` (`proposer`, `comments`) VALUES ('ISSN', NULL);

COMMIT;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
