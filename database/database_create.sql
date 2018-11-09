-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS
, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS
, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE
, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema lord
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lord
-- -----------------------------------------------------
CREATE SCHEMA
IF NOT EXISTS `lord` DEFAULT CHARACTER
SET utf8mb4 ;
USE `lord`
;

-- -----------------------------------------------------
-- Table `lord`.`lord_ratteries`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_ratteries`
(
  `rattery_id` INT NOT NULL,
  `rattery_name` VARCHAR
(70) NULL,
  `raterie_prefix` VARCHAR
(3) NULL,
  `rattery_comments` TEXT NULL,
  `rattery_picture` VARCHAR
(255) NULL,
  `rattery_status` TINYINT
(1) NULL,
  `rattery_validated` TINYINT
(1) NULL,
  `rattery_date_birth` YEAR NULL,
  `rattery_date_creation` DATE NULL,
  `rattery_date_last_update` DATE NULL,
  PRIMARY KEY
(`rattery_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_users`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_users`
(
  `user_id` INT NOT NULL,
  `user_email` VARCHAR
(70) NOT NULL,
  `user_password` VARCHAR
(32) NULL,
  `user_sex` CHAR NULL,
  `user_name_first` VARCHAR
(45) NULL,
  `user_name_last` VARCHAR
(45) NULL,
  `user_login` VARCHAR
(45) NULL,
  `user_date_birth` DATE NULL,
  `user_newsletter` TINYINT
(1) NULL,
  `user_date_creation` DATE NULL,
  `user_date_last_update` DATE NULL,
  PRIMARY KEY
(`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_colors`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_colors`
(
  `color_id` INT NOT NULL,
  `color_name_fr` VARCHAR
(70) NULL,
  `color_name_en` VARCHAR
(70) NULL,
  `color_picture` VARCHAR
(255) NULL,
  PRIMARY KEY
(`color_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_earsets`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_earsets`
(
  `earset_id` INT NOT NULL,
  `earset_name_fr` VARCHAR
(70) NULL,
  `earset_name_en` VARCHAR
(70) NULL,
  `earset_picture` VARCHAR
(255) NULL,
  PRIMARY KEY
(`earset_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_eyecolors`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_eyecolors`
(
  `eyecolor_id` INT NOT NULL,
  `eyecolor_name_fr` VARCHAR
(70) NULL,
  `eyecolor_name_en` VARCHAR
(70) NULL,
  `eyecolor_picture` VARCHAR
(255) NULL,
  PRIMARY KEY
(`eyecolor_id`))
ENGINE = InnoDB
COMMENT = 'Table contenant la liste des yeux';


-- -----------------------------------------------------
-- Table `lord`.`lord_dilutions`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_dilutions`
(
  `dilution_id` INT NOT NULL,
  `dilution_name_fr` VARCHAR
(70) NULL,
  `dilution_name_en` VARCHAR
(70) NULL,
  `dilution_picture` VARCHAR
(255) NULL,
  PRIMARY KEY
(`dilution_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des dilutions';


-- -----------------------------------------------------
-- Table `lord`.`lord_coats`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_coats`
(
  `coat_id` INT NOT NULL,
  `coat_name_fr` VARCHAR
(70) NULL,
  `coat_name_en` VARCHAR
(70) NULL,
  `coat_picture` VARCHAR
(255) NULL,
  PRIMARY KEY
(`coat_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des poils';


-- -----------------------------------------------------
-- Table `lord`.`lord_markings`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_markings`
(
  `marking_id` INT NOT NULL,
  `marking_name_fr` VARCHAR
(70) NULL,
  `marking_name_en` VARCHAR
(70) NULL,
  `marking_picture` VARCHAR
(255) NULL,
  PRIMARY KEY
(`marking_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des marquages';


-- -----------------------------------------------------
-- Table `lord`.`lord_death_causes_primary`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_death_causes_primary`
(
  `death_cause_primary_id` INT NOT NULL,
  `death_cause_primary_name_fr` VARCHAR
(100) NULL,
  `death_cause_primary_name_en` VARCHAR
(100) NULL,
  PRIMARY KEY
(`death_cause_primary_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des causes de décès';


-- -----------------------------------------------------
-- Table `lord`.`lord_death_causes_secondary`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_death_causes_secondary`
(
  `death_cause_secondary_id` INT NOT NULL,
  `death_cause_secondary_name_fr` VARCHAR
(100) NULL,
  `death_cause_secondary_name_en` VARCHAR
(100) NULL,
  `deces_principal_id` INT NOT NULL,
  PRIMARY KEY
(`death_cause_secondary_id`),
  CONSTRAINT `FK_lord_deces_secondaire_lord_deces_principal1`
    FOREIGN KEY
(`deces_principal_id`)
    REFERENCES `lord`.`lord_death_causes_primary`
(`death_cause_primary_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_lord_deces_secondaire_lord_deces_principal1_idx` ON `lord`.`lord_death_causes_secondary`
(`deces_principal_id` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_rats`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_rats`
(
  `rat_id` INT NOT NULL AUTO_INCREMENT,
  `rat_name_owner` VARCHAR
(70) NULL,
  `rat_name_pup` VARCHAR
(70) NULL,
  `rat_sex` CHAR NOT NULL,
  `rat_pedigree_identifier` VARCHAR
(10) NULL,
  `rat_date_birth` DATE NULL,
  `rat_date_death` DATE NULL,
  `death_cause_primary_id` INT NULL,
  `death_cause_secondary_id` INT NULL,
  `rat_death_euthanized` TINYINT
(1) NULL,
  `rat_death_diagnosed` TINYINT
(1) NULL,
  `rat_death_necropsied` TINYINT
(1) NULL,
  `rat_picture` VARCHAR
(255) NULL,
  `rat_picture_thumbnail` VARCHAR
(255) NULL,
  `rat_comments` TEXT NULL,
  `rat_validated` TINYINT
(1) NULL,
  `rattery_mother_id` INT NULL,
  `rattery_father_id` INT NULL,
  `rat_mother_id` INT NULL,
  `rat_father_id` INT NULL,
  `user_owner_id` INT NULL,
  `color_id` INT NULL,
  `earset_id` INT NULL,
  `eyecolor_id` INT NULL,
  `dilution_id` INT NULL,
  `coat_id` INT NULL,
  `marking_id` INT NULL,
  `singularity_id_list` INT NULL,
  `user_creator_id` INT NOT NULL,
  `rat_date_create` DATE NULL,
  `rat_date_last_update` DATE NULL,
  PRIMARY KEY
(`rat_id`),
  CONSTRAINT `FK_origine`
    FOREIGN KEY
(`rattery_mother_id`)
    REFERENCES `lord`.`lord_ratteries`
(`rattery_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_pere`
    FOREIGN KEY
(`rat_father_id`)
    REFERENCES `lord`.`lord_rats`
(`rat_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_mere`
    FOREIGN KEY
(`rat_mother_id`)
    REFERENCES `lord`.`lord_rats`
(`rat_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_proprietaire`
    FOREIGN KEY
(`user_owner_id`)
    REFERENCES `lord`.`lord_users`
(`user_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_couleur`
    FOREIGN KEY
(`color_id`)
    REFERENCES `lord`.`lord_colors`
(`color_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_oreilles`
    FOREIGN KEY
(`earset_id`)
    REFERENCES `lord`.`lord_earsets`
(`earset_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_yeux`
    FOREIGN KEY
(`eyecolor_id`)
    REFERENCES `lord`.`lord_eyecolors`
(`eyecolor_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_dilutions`
    FOREIGN KEY
(`dilution_id`)
    REFERENCES `lord`.`lord_dilutions`
(`dilution_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_poils`
    FOREIGN KEY
(`coat_id`)
    REFERENCES `lord`.`lord_coats`
(`coat_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_marquage`
    FOREIGN KEY
(`marking_id`)
    REFERENCES `lord`.`lord_markings`
(`marking_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_deces`
    FOREIGN KEY
(`death_cause_primary_id`)
    REFERENCES `lord`.`lord_death_causes_primary`
(`death_cause_primary_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_enregistreur`
    FOREIGN KEY
(`user_creator_id`)
    REFERENCES `lord`.`lord_users`
(`user_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_origine_raterie_2`
    FOREIGN KEY
(`rattery_father_id`)
    REFERENCES `lord`.`lord_ratteries`
(`rattery_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_deces_secondaire`
    FOREIGN KEY
(`death_cause_secondary_id`)
    REFERENCES `lord`.`lord_death_causes_secondary`
(`death_cause_secondary_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Table centrale, qui contient l\'ensemble des rats enregistrés';

CREATE UNIQUE INDEX `rat_id_UNIQUE` ON `lord`.`lord_rats` (`rat_id` ASC);

CREATE UNIQUE INDEX `rat_numero_UNIQUE` ON `lord`.`lord_rats` (`rat_pedigree_identifier` ASC);

CREATE INDEX `FK_origine_idx` ON `lord`.`lord_rats` (`rattery_mother_id` ASC);

CREATE INDEX `FK_pere_idx` ON `lord`.`lord_rats` (`rat_father_id` ASC);

CREATE INDEX `FK_mere_idx` ON `lord`.`lord_rats` (`rat_mother_id` ASC);

CREATE INDEX `FK_proprietaire_idx` ON `lord`.`lord_rats` (`user_owner_id` ASC);

CREATE INDEX `FK_couleur_idx` ON `lord`.`lord_rats` (`color_id` ASC);

CREATE INDEX `FK_oreilles_idx` ON `lord`.`lord_rats` (`earset_id` ASC);

CREATE INDEX `FK_yeux_idx` ON `lord`.`lord_rats` (`eyecolor_id` ASC);

CREATE INDEX `FK_dilutions_idx` ON `lord`.`lord_rats` (`dilution_id` ASC);

CREATE INDEX `FK_poils_idx` ON `lord`.`lord_rats` (`coat_id` ASC);

CREATE INDEX `FK_marquage_idx` ON `lord`.`lord_rats` (`marking_id` ASC);

CREATE INDEX `FK_deces_idx` ON `lord`.`lord_rats` (`death_cause_primary_id` ASC);

CREATE INDEX `FK_enregistreur_idx` ON `lord`.`lord_rats` (`user_creator_id` ASC);

CREATE INDEX `FK_lord_rats_lord_raterie1_idx` ON `lord`.`lord_rats` (`rattery_father_id` ASC);

CREATE INDEX `FK_lord_rats_lord_deces_secondaire1_idx` ON `lord`.`lord_rats` (`death_cause_secondary_id` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_singularities`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lord`.`lord_singularities` (
  `singularity_id` INT NOT NULL,
  `singularity_name_fr` VARCHAR(70) NULL,
  `singularity_name_en` VARCHAR(70) NULL,
  `singularity_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`singularity_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des particularités';


-- -----------------------------------------------------
-- Table `lord`.`lord_litters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lord`.`lord_litters` (
  `litter_id` INT NOT NULL,
  `litter_date_mating` DATE NULL,
  `litter_date_birth` DATE NULL,
  `litter_number_pups` TINYINT NULL,
  `litter_number_pups_stillborn` TINYINT NULL,
  `litter_comments` TEXT NULL,
  `rat_mother_id` INT NOT NULL,
  `rat_father_id` INT NULL,
  `user_owner_id` INT NOT NULL,
  PRIMARY KEY (`litter_id`),
  CONSTRAINT `FK_lord_portee_lord_rats1`
    FOREIGN KEY (`rat_mother_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_lord_portee_lord_rats2`
    FOREIGN KEY (`rat_father_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_lord_portee_lord_utilisateurs1`
    FOREIGN KEY (`user_owner_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_lord_portee_lord_rats1_idx` ON `lord`.`lord_litters` (`rat_mother_id` ASC);

CREATE INDEX `FK_lord_portee_lord_rats2_idx` ON `lord`.`lord_litters` (`rat_father_id` ASC);

CREATE INDEX `FK_lord_portee_lord_utilisateurs1_idx` ON `lord`.`lord_litters` (`user_owner_id` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_backoffice_rat_entries`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lord`.`lord_backoffice_rat_entries` (
  `lord_backoffice_rat_entry_id` INT NOT NULL AUTO_INCREMENT,
  `lord_backoffice_rat_entry_status` TINYINT NULL,
  `rat_id` INT NOT NULL,
  `rat_name_owner` VARCHAR(70) NULL,
  `rat_name_pup` VARCHAR(70) NULL,
  `rat_sex` CHAR NOT NULL,
  `rat_pedigree_identifier` VARCHAR(10) NULL,
  `rat_date_birth` DATE NULL,
  `rat_date_death` DATE NULL,
  `death_cause_primary_id` INT NULL,
  `death_cause_secondary_id` INT NULL,
  `rat_death_euthanized` TINYINT(1) NULL,
  `rat_death_diagnosed` TINYINT(1) NULL,
  `rat_death_necropsied` TINYINT(1) NULL,
  `rat_picture` VARCHAR(255) NULL,
  `rat_picture_thumbnail` VARCHAR(255) NULL,
  `rat_comments` TEXT NULL,
  `rat_validated` TINYINT NULL,
  `rattery_mother_id` INT NULL,
  `rattery_father_id` INT NULL,
  `rat_mother_id` INT NULL,
  `rat_father_id` INT NULL,
  `user_owner_id` INT NULL,
  `color_id` INT NULL,
  `earset_id` INT NULL,
  `eyecolor_id` INT NULL,
  `dilution_id` INT NULL,
  `coat_id` INT NULL,
  `marking_id` INT NULL,
  `singularity_id_list` INT NULL,
  `user_creator_id` INT NOT NULL,
  `rat_date_create` DATE NULL,
  `rat_date_last_update` DATE NULL,
  PRIMARY KEY (`lord_backoffice_rat_entry_id`),
  CONSTRAINT `FK_origine0`
    FOREIGN KEY (`rattery_mother_id`)
    REFERENCES `lord`.`lord_ratteries` (`rattery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_pere0`
    FOREIGN KEY (`rat_father_id`)
    REFERENCES `lord`.`lord_backoffice_rat_entries` (`lord_backoffice_rat_entry_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_mere0`
    FOREIGN KEY (`rat_mother_id`)
    REFERENCES `lord`.`lord_backoffice_rat_entries` (`lord_backoffice_rat_entry_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_proprietaire0`
    FOREIGN KEY (`user_owner_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_couleur0`
    FOREIGN KEY (`color_id`)
    REFERENCES `lord`.`lord_colors` (`color_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_oreilles0`
    FOREIGN KEY (`earset_id`)
    REFERENCES `lord`.`lord_earsets` (`earset_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_yeux0`
    FOREIGN KEY (`eyecolor_id`)
    REFERENCES `lord`.`lord_eyecolors` (`eyecolor_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_dilutions0`
    FOREIGN KEY (`dilution_id`)
    REFERENCES `lord`.`lord_dilutions` (`dilution_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_poils0`
    FOREIGN KEY (`coat_id`)
    REFERENCES `lord`.`lord_coats` (`coat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_marquage0`
    FOREIGN KEY (`marking_id`)
    REFERENCES `lord`.`lord_markings` (`marking_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_deces0`
    FOREIGN KEY (`death_cause_primary_id`)
    REFERENCES `lord`.`lord_death_causes_primary` (`death_cause_primary_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_enregistreur0`
    FOREIGN KEY (`user_creator_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_origine_raterie_20`
    FOREIGN KEY (`rattery_father_id`)
    REFERENCES `lord`.`lord_ratteries` (`rattery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_deces_secondaire0`
    FOREIGN KEY (`death_cause_secondary_id`)
    REFERENCES `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_lord_backoffice_rat_entries_lord_rats1`
    FOREIGN KEY (`rat_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Table centrale, qui contient l\'ensemble des rats enregistrés';

CREATE UNIQUE INDEX `rat_id_UNIQUE` ON `lord`.`lord_backoffice_rat_entries`
(`lord_backoffice_rat_entry_id` ASC);

CREATE UNIQUE INDEX `rat_numero_UNIQUE` ON `lord`.`lord_backoffice_rat_entries`
(`rat_pedigree_identifier` ASC);

CREATE INDEX `FK_origine_idx` ON `lord`.`lord_backoffice_rat_entries`
(`rattery_mother_id` ASC);

CREATE INDEX `FK_pere_idx` ON `lord`.`lord_backoffice_rat_entries`
(`rat_father_id` ASC);

CREATE INDEX `FK_mere_idx` ON `lord`.`lord_backoffice_rat_entries`
(`rat_mother_id` ASC);

CREATE INDEX `FK_proprietaire_idx` ON `lord`.`lord_backoffice_rat_entries`
(`user_owner_id` ASC);

CREATE INDEX `FK_couleur_idx` ON `lord`.`lord_backoffice_rat_entries`
(`color_id` ASC);

CREATE INDEX `FK_oreilles_idx` ON `lord`.`lord_backoffice_rat_entries`
(`earset_id` ASC);

CREATE INDEX `FK_yeux_idx` ON `lord`.`lord_backoffice_rat_entries`
(`eyecolor_id` ASC);

CREATE INDEX `FK_dilutions_idx` ON `lord`.`lord_backoffice_rat_entries`
(`dilution_id` ASC);

CREATE INDEX `FK_poils_idx` ON `lord`.`lord_backoffice_rat_entries`
(`coat_id` ASC);

CREATE INDEX `FK_marquage_idx` ON `lord`.`lord_backoffice_rat_entries`
(`marking_id` ASC);

CREATE INDEX `FK_deces_idx` ON `lord`.`lord_backoffice_rat_entries`
(`death_cause_primary_id` ASC);

CREATE INDEX `FK_enregistreur_idx` ON `lord`.`lord_backoffice_rat_entries`
(`user_creator_id` ASC);

CREATE INDEX `FK_lord_rats_lord_raterie1_idx` ON `lord`.`lord_backoffice_rat_entries`
(`rattery_father_id` ASC);

CREATE INDEX `FK_lord_rats_lord_deces_secondaire1_idx` ON `lord`.`lord_backoffice_rat_entries`
(`death_cause_secondary_id` ASC);

CREATE INDEX `FK_lord_backoffice_rat_entries_lord_rats1_idx` ON `lord`.`lord_backoffice_rat_entries`
(`rat_id` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_backoffice_rat_messages`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_backoffice_rat_messages`
(
  `backoffice_rat_message_id` INT NOT NULL,
  `backoffice_rat_entry_id` INT NOT NULL,
  `user_staff_id` INT NULL,
  `backoffice_rat_message_staff_comments` TEXT NULL,
  `backoffice_rat_message_owner_comments` TEXT NULL,
  `backoffice_rat_message_date_staff_comments` DATE NULL,
  `backoffice_rat_message_date_owner_comments` DATE NULL,
  PRIMARY KEY
(`backoffice_rat_message_id`),
  CONSTRAINT `FK_lord_sav_lord_utilisateurs1`
    FOREIGN KEY
(`user_staff_id`)
    REFERENCES `lord`.`lord_users`
(`user_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_lord_backoffice_rat_messages_lord_backoffice_rat_entries1`
    FOREIGN KEY
(`backoffice_rat_entry_id`)
    REFERENCES `lord`.`lord_backoffice_rat_entries`
(`lord_backoffice_rat_entry_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_lord_sav_lord_utilisateurs1_idx` ON `lord`.`lord_backoffice_rat_messages`
(`user_staff_id` ASC);

CREATE INDEX `FK_lord_backoffice_rat_messages_lord_backoffice_rat_entries_idx` ON `lord`.`lord_backoffice_rat_messages`
(`backoffice_rat_entry_id` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_backoffice_rattery_messages`
-- -----------------------------------------------------
CREATE TABLE
IF NOT EXISTS `lord`.`lord_backoffice_rattery_messages`
(
  `backoffice_rattery_message_id` INT NOT NULL,
  `rattery_id` INT NOT NULL,
  `user_staff_id` INT NULL,
  `backoffice_rattery_message_staff_comments` TEXT NULL,
  `backoffice_rattery_message_owner_comments` TEXT NULL,
  `backoffice_rattery_messages_date_staff_comments` DATE NULL,
  `backoffice_rattery_messages_date_owner_comments` DATE NULL,
  PRIMARY KEY
(`backoffice_rattery_message_id`),
  CONSTRAINT `FK_lord_backoffice_rattery_messages_lord_ratteries1`
    FOREIGN KEY
(`rattery_id`)
    REFERENCES `lord`.`lord_ratteries`
(`rattery_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT `FK_lord_backoffice_rattery_messages_lord_users1`
    FOREIGN KEY
(`user_staff_id`)
    REFERENCES `lord`.`lord_users`
(`user_id`)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `FK_lord_backoffice_rattery_messages_lord_ratteries1_idx` ON `lord`.`lord_backoffice_rattery_messages`
(`rattery_id` ASC);

CREATE INDEX `FK_lord_backoffice_rattery_messages_lord_users1_idx` ON `lord`.`lord_backoffice_rattery_messages`
(`user_staff_id` ASC);


SET SQL_MODE
=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS
=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS
=@OLD_UNIQUE_CHECKS;
