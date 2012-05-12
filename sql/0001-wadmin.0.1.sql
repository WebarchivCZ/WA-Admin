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
  `category` VARCHAR(150) NOT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`publishers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`publishers` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`publishers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(150) NOT NULL ,
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
  `name` VARCHAR(150) NULL DEFAULT NULL ,
  `email` VARCHAR(150) NOT NULL ,
  `phone` INT UNSIGNED NULL DEFAULT NULL ,
  `address` VARCHAR(255) NULL DEFAULT NULL ,
  `position` VARCHAR(45) NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_contacts_publishers` (`publisher_id` ASC) ,
  CONSTRAINT `fk_contacts_publishers`
    FOREIGN KEY (`publisher_id` )
    REFERENCES `waTest`.`publishers` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `waTest`.`contracts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`contracts` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`contracts` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `contract_no` VARCHAR(15) NOT NULL ,
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
  `email` VARCHAR(100) NOT NULL ,
  `icq` INT UNSIGNED NULL DEFAULT NULL ,
  `skype` VARCHAR(100) NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_curators_roles` (`roles_id` ASC) ,
  CONSTRAINT `fk_curators_roles`
    FOREIGN KEY (`roles_id` )
    REFERENCES `waTest`.`roles` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


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
  INDEX `fk_resources_conspectus` (`conspectus_id` ASC) ,
  INDEX `fk_resources_contracts` (`contract_id` ASC) ,
  INDEX `fk_resources_curators` (`curator_id` ASC) ,
  INDEX `fk_resources_publishers` (`publisher_id` ASC) ,
  INDEX `fk_resources_contacts` (`contact_id` ASC) ,
  INDEX `fk_resources_crawl_freq` (`crawl_freq_id` ASC) ,
  INDEX `fk_resources_resource_status` (`resource_status_id` ASC) ,
  INDEX `fk_resources_suggested_by` (`suggested_by_id` ASC) ,
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
  INDEX `fk_correspondence_resources` (`resource_id` ASC) ,
  INDEX `fk_correspondence_correspondence_type` (`correspondence_type_id` ASC) ,
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
  INDEX `fk_ratings_curators` (`curator_id` ASC) ,
  INDEX `fk_ratings_resources` (`resource_id` ASC) ,
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


-- -----------------------------------------------------
-- Table `waTest`.`seed_status`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`seed_status` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`seed_status` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `status` VARCHAR(45) NOT NULL ,
  `comments` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `waTest`.`seeds`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `waTest`.`seeds` ;

CREATE  TABLE IF NOT EXISTS `waTest`.`seeds` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `resource_id` INT UNSIGNED NOT NULL ,
  `url` VARCHAR(255) NOT NULL ,
  `seed_status_id` INT NOT NULL ,
  `redirect` BOOLEAN NULL DEFAULT NULL ,
  `valid_from` DATE NULL DEFAULT NULL ,
  `valid_to` DATE NULL DEFAULT NULL ,
  `comments` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_seeds_resources` (`resource_id` ASC) ,
  INDEX `fk_seeds_seed_status` (`seed_status_id` ASC) ,
  CONSTRAINT `fk_seeds_resources`
    FOREIGN KEY (`resource_id` )
    REFERENCES `waTest`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_seeds_seed_status`
    FOREIGN KEY (`seed_status_id` )
    REFERENCES `waTest`.`seed_status` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


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
  INDEX `fk_quality_control_resources` (`resources_id` ASC) ,
  CONSTRAINT `fk_quality_control_resources`
    FOREIGN KEY (`resources_id` )
    REFERENCES `waTest`.`resources` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

USE `waTest`;

-- -----------------------------------------------------
-- Data for table `waTest`.`roles`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `roles` (`id`, `role`, `comments`) VALUES (0, 'admin', NULL);
INSERT INTO `roles` (`id`, `role`, `comments`) VALUES (0, 'curator', NULL);
INSERT INTO `roles` (`id`, `role`, `comments`) VALUES (0, 'crawler_manager', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`resource_status`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `resource_status` (`id`, `status`, `comments`) VALUES (0, 'schválen', NULL);
INSERT INTO `resource_status` (`id`, `status`, `comments`) VALUES (0, 'neschválen', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`suggested_by`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `suggested_by` (`id`, `proposer`, `comments`) VALUES (1, 'kurátor', NULL);
INSERT INTO `suggested_by` (`id`, `proposer`, `comments`) VALUES (2, 'web/vydavatel', NULL);
INSERT INTO `suggested_by` (`id`, `proposer`, `comments`) VALUES (3, 'web/návštěvník', NULL);
INSERT INTO `suggested_by` (`id`, `proposer`, `comments`) VALUES (4, 'ISSN', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `waTest`.`seed_status`
-- -----------------------------------------------------
SET AUTOCOMMIT=0;
INSERT INTO `seed_status` (`id`, `status`, `comments`) VALUES (0, 'valid', NULL);

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
