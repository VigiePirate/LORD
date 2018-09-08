-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema lord
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lord
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lord` DEFAULT CHARACTER SET utf8mb4 ;
USE `lord` ;

-- -----------------------------------------------------
-- Table `lord`.`lord_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_users` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `user_email` VARCHAR(70) NOT NULL,
  `user_password` VARCHAR(32) NULL,
  `user_sex` CHAR NULL,
  `user_name_first` VARCHAR(45) NULL,
  `user_name_last` VARCHAR(45) NULL,
  `user_login` VARCHAR(45) NULL,
  `user_date_birth` DATE NULL,
  `user_newsletter` TINYINT(1) NULL,
  `user_date_creation` DATE NULL,
  `user_date_last_update` DATE NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_ratteries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_ratteries` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_ratteries` (
  `rattery_id` INT NOT NULL AUTO_INCREMENT,
  `rattery_name` VARCHAR(70) NULL,
  `raterie_prefix` VARCHAR(3) NULL,
  `user_owner_id` INT NOT NULL,
  `rattery_comments` TEXT NULL,
  `rattery_picture` VARCHAR(255) NULL,
  `rattery_status` TINYINT(1) NULL,
  `rattery_validated` TINYINT(1) NULL,
  `rattery_date_birth` YEAR NULL,
  `rattery_date_creation` DATE NULL,
  `rattery_date_last_update` DATE NULL,
  PRIMARY KEY (`rattery_id`),
  CONSTRAINT `fk_lord_ratteries_lord_users1`
    FOREIGN KEY (`user_owner_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_colors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_colors` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_colors` (
  `color_id` INT NOT NULL AUTO_INCREMENT,
  `color_name_fr` VARCHAR(70) NULL,
  `color_name_en` VARCHAR(70) NULL,
  `color_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`color_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_earsets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_earsets` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_earsets` (
  `earset_id` INT NOT NULL AUTO_INCREMENT,
  `earset_name_fr` VARCHAR(70) NULL,
  `earset_name_en` VARCHAR(70) NULL,
  `earset_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`earset_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_eyecolors`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_eyecolors` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_eyecolors` (
  `eyecolor_id` INT NOT NULL AUTO_INCREMENT,
  `eyecolor_name_fr` VARCHAR(70) NULL,
  `eyecolor_name_en` VARCHAR(70) NULL,
  `eyecolor_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`eyecolor_id`))
ENGINE = InnoDB
COMMENT = 'Table contenant la liste des yeux';


-- -----------------------------------------------------
-- Table `lord`.`lord_dilutions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_dilutions` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_dilutions` (
  `dilution_id` INT NOT NULL AUTO_INCREMENT,
  `dilution_name_fr` VARCHAR(70) NULL,
  `dilution_name_en` VARCHAR(70) NULL,
  `dilution_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`dilution_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des dilutions';


-- -----------------------------------------------------
-- Table `lord`.`lord_coats`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_coats` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_coats` (
  `coat_id` INT NOT NULL AUTO_INCREMENT,
  `coat_name_fr` VARCHAR(70) NULL,
  `coat_name_en` VARCHAR(70) NULL,
  `coat_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`coat_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des poils';


-- -----------------------------------------------------
-- Table `lord`.`lord_markings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_markings` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_markings` (
  `marking_id` INT NOT NULL AUTO_INCREMENT,
  `marking_name_fr` VARCHAR(70) NULL,
  `marking_name_en` VARCHAR(70) NULL,
  `marking_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`marking_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des marquages';


-- -----------------------------------------------------
-- Table `lord`.`lord_death_causes_primary`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_death_causes_primary` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_death_causes_primary` (
  `death_cause_primary_id` INT NOT NULL AUTO_INCREMENT,
  `death_cause_primary_name_fr` VARCHAR(100) NULL,
  `death_cause_primary_name_en` VARCHAR(100) NULL,
  PRIMARY KEY (`death_cause_primary_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des causes de décès';


-- -----------------------------------------------------
-- Table `lord`.`lord_death_causes_secondary`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_death_causes_secondary` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_death_causes_secondary` (
  `death_cause_secondary_id` INT NOT NULL AUTO_INCREMENT,
  `death_cause_secondary_name_fr` VARCHAR(100) NULL,
  `death_cause_secondary_name_en` VARCHAR(100) NULL,
  `deces_principal_id` INT NOT NULL,
  PRIMARY KEY (`death_cause_secondary_id`),
  CONSTRAINT `fk_lord_deces_secondaire_lord_deces_principal1`
    FOREIGN KEY (`deces_principal_id`)
    REFERENCES `lord`.`lord_death_causes_primary` (`death_cause_primary_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_litters`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_litters` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_litters` (
  `litter_id` INT NOT NULL AUTO_INCREMENT,
  `litter_date_mating` DATE NULL,
  `litter_date_birth` DATE NULL,
  `litter_number_pups` TINYINT NULL,
  `litter_number_pups_stillborn` TINYINT NULL,
  `litter_comments` TEXT NULL,
  `rat_mother_id` INT NOT NULL,
  `rat_father_id` INT NULL,
  `user_owner_id` INT NOT NULL,
  PRIMARY KEY (`litter_id`),
  CONSTRAINT `fk_lord_portee_lord_rats1`
    FOREIGN KEY (`rat_mother_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lord_portee_lord_rats2`
    FOREIGN KEY (`rat_father_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lord_portee_lord_utilisateurs1`
    FOREIGN KEY (`user_owner_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_rats`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_rats` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_rats` (
  `rat_id` INT NOT NULL AUTO_INCREMENT,
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
  `rat_validated` TINYINT(1) NULL,
  `rattery_mother_id` INT NULL,
  `rattery_father_id` INT NULL,
  `rat_mother_id` INT NULL,
  `rat_father_id` INT NULL,
  `litter_id` INT NULL,
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
  PRIMARY KEY (`rat_id`),
  CONSTRAINT `FK_origine`
    FOREIGN KEY (`rattery_mother_id`)
    REFERENCES `lord`.`lord_ratteries` (`rattery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_pere`
    FOREIGN KEY (`rat_father_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_mere`
    FOREIGN KEY (`rat_mother_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Fk_proprietaire`
    FOREIGN KEY (`user_owner_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_couleur`
    FOREIGN KEY (`color_id`)
    REFERENCES `lord`.`lord_colors` (`color_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_oreilles`
    FOREIGN KEY (`earset_id`)
    REFERENCES `lord`.`lord_earsets` (`earset_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_yeux`
    FOREIGN KEY (`eyecolor_id`)
    REFERENCES `lord`.`lord_eyecolors` (`eyecolor_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dilutions`
    FOREIGN KEY (`dilution_id`)
    REFERENCES `lord`.`lord_dilutions` (`dilution_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_poils`
    FOREIGN KEY (`coat_id`)
    REFERENCES `lord`.`lord_coats` (`coat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_marquage`
    FOREIGN KEY (`marking_id`)
    REFERENCES `lord`.`lord_markings` (`marking_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_deces`
    FOREIGN KEY (`death_cause_primary_id`)
    REFERENCES `lord`.`lord_death_causes_primary` (`death_cause_primary_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_enregistreur`
    FOREIGN KEY (`user_creator_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_origine_raterie_2`
    FOREIGN KEY (`rattery_father_id`)
    REFERENCES `lord`.`lord_ratteries` (`rattery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deces_secondaire`
    FOREIGN KEY (`death_cause_secondary_id`)
    REFERENCES `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lord_rats_lord_litters1`
    FOREIGN KEY (`litter_id`)
    REFERENCES `lord`.`lord_litters` (`litter_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Table centrale, qui contient l\'ensemble des rats enregistrés';

CREATE UNIQUE INDEX `rat_id_UNIQUE` ON `lord`.`lord_rats` (`rat_id` ASC);

CREATE UNIQUE INDEX `rat_numero_UNIQUE` ON `lord`.`lord_rats` (`rat_pedigree_identifier` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_singularities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_singularities` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_singularities` (
  `singularity_id` INT NOT NULL AUTO_INCREMENT,
  `singularity_name_fr` VARCHAR(70) NULL,
  `singularity_name_en` VARCHAR(70) NULL,
  `singularity_picture` VARCHAR(255) NULL,
  PRIMARY KEY (`singularity_id`))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des particularités';


-- -----------------------------------------------------
-- Table `lord`.`lord_backoffice_rat_entries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_backoffice_rat_entries` ;

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
  CONSTRAINT `Fk_proprietaire0`
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
  CONSTRAINT `fk_dilutions0`
    FOREIGN KEY (`dilution_id`)
    REFERENCES `lord`.`lord_dilutions` (`dilution_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_poils0`
    FOREIGN KEY (`coat_id`)
    REFERENCES `lord`.`lord_coats` (`coat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_marquage0`
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
  CONSTRAINT `fk_origine_raterie_20`
    FOREIGN KEY (`rattery_father_id`)
    REFERENCES `lord`.`lord_ratteries` (`rattery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_deces_secondaire0`
    FOREIGN KEY (`death_cause_secondary_id`)
    REFERENCES `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lord_backoffice_rat_entries_lord_rats1`
    FOREIGN KEY (`rat_id`)
    REFERENCES `lord`.`lord_rats` (`rat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Table centrale, qui contient l\'ensemble des rats enregistrés';

CREATE UNIQUE INDEX `rat_id_UNIQUE` ON `lord`.`lord_backoffice_rat_entries` (`lord_backoffice_rat_entry_id` ASC);

CREATE UNIQUE INDEX `rat_numero_UNIQUE` ON `lord`.`lord_backoffice_rat_entries` (`rat_pedigree_identifier` ASC);


-- -----------------------------------------------------
-- Table `lord`.`lord_backoffice_rat_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_backoffice_rat_messages` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_backoffice_rat_messages` (
  `backoffice_rat_message_id` INT NOT NULL AUTO_INCREMENT,
  `backoffice_rat_entry_id` INT NOT NULL,
  `user_staff_id` INT NULL,
  `backoffice_rat_message_staff_comments` TEXT NULL,
  `backoffice_rat_message_owner_comments` TEXT NULL,
  `backoffice_rat_message_date_staff_comments` DATE NULL,
  `backoffice_rat_message_date_owner_comments` DATE NULL,
  PRIMARY KEY (`backoffice_rat_message_id`),
  CONSTRAINT `fk_lord_sav_lord_utilisateurs1`
    FOREIGN KEY (`user_staff_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lord_backoffice_rat_messages_lord_backoffice_rat_entries1`
    FOREIGN KEY (`backoffice_rat_entry_id`)
    REFERENCES `lord`.`lord_backoffice_rat_entries` (`lord_backoffice_rat_entry_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lord`.`lord_backoffice_rattery_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lord`.`lord_backoffice_rattery_messages` ;

CREATE TABLE IF NOT EXISTS `lord`.`lord_backoffice_rattery_messages` (
  `backoffice_rattery_message_id` INT NOT NULL AUTO_INCREMENT,
  `rattery_id` INT NOT NULL,
  `user_staff_id` INT NULL,
  `backoffice_rattery_message_staff_comments` TEXT NULL,
  `backoffice_rattery_message_owner_comments` TEXT NULL,
  `backoffice_rattery_messages_date_staff_comments` DATE NULL,
  `backoffice_rattery_messages_date_owner_comments` DATE NULL,
  PRIMARY KEY (`backoffice_rattery_message_id`),
  CONSTRAINT `fk_lord_backoffice_rattery_messages_lord_ratteries1`
    FOREIGN KEY (`rattery_id`)
    REFERENCES `lord`.`lord_ratteries` (`rattery_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_lord_backoffice_rattery_messages_lord_users1`
    FOREIGN KEY (`user_staff_id`)
    REFERENCES `lord`.`lord_users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_users`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (1, 'raterie@raterie-stella.com', '6cfab3c59675dc5c99353c5e6f5be008', 'F', 'VALIA', 'VERRIERE', 'stella', '1976-07-09', NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (2, 'administrateur@lord-rat.org', NULL, NULL, 'Admin', NULL, 'admin', NULL, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (3, 'sine.alexia@free.fr', '5d81d465cfc6f03bff54c5709a4737ba', 'F', 'Alexia', 'Siné', 'Limë', '1984-02-05', NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (5, 'artefact@entierement.nu', 'e8a8f22e0ebfcfd17f6f6170208621d9', 'F', 'Nancy', 'Bertin', 'Artefact', '1981-08-01', NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (6, 'pa@paratsite.fr', '992e29d3b368923a6383f05cdd4b4aa2', 'F', 'Marie', 'PA', 'Petit_ange', NULL, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (DEFAULT, 'vautier.joanna@hotmail.fr', '8dd377e29ca5356032dc15fcb4cd877a', 'F', 'Joanna', 'Vautier', 'm0ua-haha', '2013-04-14', NULL, '2013-04-14', '2013-04-14');
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (DEFAULT, 'lorelei91310@hotmail.fr', '30f4ebe2cb080527ad19d808d00b8d6f', 'F', 'Loreleï', 'AMAURY', 'Miss-lolo-91', '1998-05-26', NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (DEFAULT, 'pouikpouiky@gmail.com', NULL, 'F', NULL, NULL, 'Pinky', NULL, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (DEFAULT, 'marinar@lenautilus.fr', NULL, 'F', NULL, NULL, 'kerma', NULL, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_users` (`user_id`, `user_email`, `user_password`, `user_sex`, `user_name_first`, `user_name_last`, `user_login`, `user_date_birth`, `user_newsletter`, `user_date_creation`, `user_date_last_update`) VALUES (DEFAULT, 'nezumi30@sfr.fr', NULL, 'F', NULL, NULL, 'ramses30', NULL, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_ratteries`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'Les Vigies Pirates', 'VGP', 5, 'Propriétaire de mâles exclusivement. ', NULL, 1, 1, 2009, '2012-05-19', NULL);
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, '* Animalerie *', 'INC', 2, NULL, NULL, 1, 1, NULL, '2009-12-24', '2009-12-24');
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, '* Sauvetage *', 'INC', 2, NULL, NULL, 1, 1, NULL, '2009-12-24', '2009-12-24');
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, '* Eleveur indépendant *', 'IND', 2, NULL, NULL, 1, 1, NULL, '2009-05-14', '2009-05-14');
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'La Tarte au Citron', 'DTC', 3, 'La tarte au Citron est  membre de la National Fancy Rat Society et partenaire SRFA', NULL, 1, 1, NULL, NULL, '2018-01-20');
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'Soleil du grand sud', 'SGS', 1, NULL, NULL, 0, 0, 2003, '2009-07-01', '2009-07-01');
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'PARatSite', 'PAZ', 6, 'Je ne souhaite faire que des portées externes, c\'est à dire avec des mâles', NULL, 0, 1, 2010, '2010-10-08', NULL);
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'RatLoween', 'WEE', 7, NULL, NULL, 0, 1, 2013, '2013-11-22', NULL);
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'Le Souvenir de Moumix', 'MMX', 8, NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'Le Manoir des TouPoutouX', 'TPX', 9, 'Au Manoir des Toupoutoux, je travaille actuellement uniquement par les mâles. Nous avons collaboré à deux portées : RMM Xolotl et RLF-PAZ Zorya, et NIN-WYS Zizi et KTY Flash. ', NULL, 0, 1, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'KerMa Rats', 'KMR', 10, NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO `lord`.`lord_ratteries` (`rattery_id`, `rattery_name`, `raterie_prefix`, `user_owner_id`, `rattery_comments`, `rattery_picture`, `rattery_status`, `rattery_validated`, `rattery_date_birth`, `rattery_date_creation`, `rattery_date_last_update`) VALUES (DEFAULT, 'KTY-minis', 'KTY', 11, NULL, NULL, 1, 1, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_colors`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_colors` (`color_id`, `color_name_fr`, `color_name_en`, `color_picture`) VALUES (1, 'Noir', NULL, NULL);
INSERT INTO `lord`.`lord_colors` (`color_id`, `color_name_fr`, `color_name_en`, `color_picture`) VALUES (2, 'Agouti', NULL, NULL);
INSERT INTO `lord`.`lord_colors` (`color_id`, `color_name_fr`, `color_name_en`, `color_picture`) VALUES (3, 'Bleu us', NULL, NULL);
INSERT INTO `lord`.`lord_colors` (`color_id`, `color_name_fr`, `color_name_en`, `color_picture`) VALUES (4, 'Bleu russe', NULL, NULL);
INSERT INTO `lord`.`lord_colors` (`color_id`, `color_name_fr`, `color_name_en`, `color_picture`) VALUES (5, 'Cannelle', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_earsets`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_earsets` (`earset_id`, `earset_name_fr`, `earset_name_en`, `earset_picture`) VALUES (DEFAULT, 'Standard', NULL, NULL);
INSERT INTO `lord`.`lord_earsets` (`earset_id`, `earset_name_fr`, `earset_name_en`, `earset_picture`) VALUES (DEFAULT, 'Dumbo', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_eyecolors`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_eyecolors` (`eyecolor_id`, `eyecolor_name_fr`, `eyecolor_name_en`, `eyecolor_picture`) VALUES (DEFAULT, 'Noir', NULL, NULL);
INSERT INTO `lord`.`lord_eyecolors` (`eyecolor_id`, `eyecolor_name_fr`, `eyecolor_name_en`, `eyecolor_picture`) VALUES (DEFAULT, 'Rouge', NULL, NULL);
INSERT INTO `lord`.`lord_eyecolors` (`eyecolor_id`, `eyecolor_name_fr`, `eyecolor_name_en`, `eyecolor_picture`) VALUES (DEFAULT, 'Dark rubis', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_dilutions`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Albinos', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'BED - Black Eyed Devil', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'BEH - Black Eyed Himalayan', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'BES - Black Eyed Siamese', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Burmese himalayen', '', NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Burmese sable himalayen', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Burmese sable siamois', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Burmese siamois', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Biscuit (burmese albinos)', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Himalayen', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Ivory (albinos yeux noirs)', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'RED - Red Eyed Devil', NULL, NULL);
INSERT INTO `lord`.`lord_dilutions` (`dilution_id`, `dilution_name_fr`, `dilution_name_en`, `dilution_picture`) VALUES (DEFAULT, 'Siamois', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_coats`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_coats` (`coat_id`, `coat_name_fr`, `coat_name_en`, `coat_picture`) VALUES (DEFAULT, 'Lisse', NULL, NULL);
INSERT INTO `lord`.`lord_coats` (`coat_id`, `coat_name_fr`, `coat_name_en`, `coat_picture`) VALUES (DEFAULT, 'Rex', NULL, NULL);
INSERT INTO `lord`.`lord_coats` (`coat_id`, `coat_name_fr`, `coat_name_en`, `coat_picture`) VALUES (DEFAULT, 'Double rex', NULL, NULL);
INSERT INTO `lord`.`lord_coats` (`coat_id`, `coat_name_fr`, `coat_name_en`, `coat_picture`) VALUES (DEFAULT, 'Nu', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_markings`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_markings` (`marking_id`, `marking_name_fr`, `marking_name_en`, `marking_picture`) VALUES (DEFAULT, 'Uni', NULL, NULL);
INSERT INTO `lord`.`lord_markings` (`marking_id`, `marking_name_fr`, `marking_name_en`, `marking_picture`) VALUES (DEFAULT, 'Irish', NULL, NULL);
INSERT INTO `lord`.`lord_markings` (`marking_id`, `marking_name_fr`, `marking_name_en`, `marking_picture`) VALUES (DEFAULT, 'Hooded', NULL, NULL);
INSERT INTO `lord`.`lord_markings` (`marking_id`, `marking_name_fr`, `marking_name_en`, `marking_picture`) VALUES (DEFAULT, 'Varieberk', NULL, NULL);
INSERT INTO `lord`.`lord_markings` (`marking_id`, `marking_name_fr`, `marking_name_en`, `marking_picture`) VALUES (DEFAULT, 'Capé', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_death_causes_primary`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Cause inconnue', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Accidents, traumatismes, intoxications', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Cardio-vasculaire', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Digestif', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Mortalité infantile (moins de 6 semaines)', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Muscles et squelette', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Neurologique (cerveau, moelle épinière, nerfs)', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Œil, oreille, bouche, face', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Peau', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Respiratoire', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Système reproducteur', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Système urinaire (reins, vessie)', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Vieillesse, mort naturelle (24 mois minimum)', NULL);
INSERT INTO `lord`.`lord_death_causes_primary` (`death_cause_primary_id`, `death_cause_primary_name_fr`, `death_cause_primary_name_en`) VALUES (DEFAULT, 'Autres', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_death_causes_secondary`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (1, 'Aucune information (présumé mort)', NULL, 1);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Cause indéterminée (date connue)', NULL, 1);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Accident domestique (écrasement, accident de porte... )', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Accident vétérinaire (anesthésie lors d’une opération mineure, erreur médicale...)', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Bagarres, blessures, morsures graves, hémorragie consécutive (hors hémorragie anormale)', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Brûlures thermiques ou chimiques', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Chutes, fractures, traumatisme crânien ou de la moelle épinière (hors bagarres)', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Coup de chaleur', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Étouffement, fausse route', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Empoisonnement (produits ménagers, poisons, médicaments volés...)', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Intoxication alimentaire', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Surdosage médicamenteux (médicaments vétérinaires prescrits)', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Autre accident ou traumatisme', NULL, 2);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Crise cardiaque, infarctus, embolie pulmonaire', NULL, 3);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Insuffisance cardiaque, valvulopathie', NULL, 3);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Hémorragie (exagérée par rapport au contexte, anomalie de la coagulation, hémophilie)', NULL, 3);
INSERT INTO `lord`.`lord_death_causes_secondary` (`death_cause_secondary_id`, `death_cause_secondary_name_fr`, `death_cause_secondary_name_en`, `deces_principal_id`) VALUES (DEFAULT, 'Autre problème cardiaque ou vasculaire', NULL, 3);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_litters`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_litters` (`litter_id`, `litter_date_mating`, `litter_date_birth`, `litter_number_pups`, `litter_number_pups_stillborn`, `litter_comments`, `rat_mother_id`, `rat_father_id`, `user_owner_id`) VALUES (1, '2013-10-31', '2013-11-22', 13, 1, NULL, 34308, 31523, 7);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_rats`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (29036, 'Pillywiggin', 'Barbabulle', 'F', 'KTY29036F', '2012-01-07', '2014-04-24', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 12, 4, NULL, NULL, NULL, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (34232, 'Nemo', '', 'M', 'INC34232M', '2012-11-15', '2014-10-30', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (34231, 'Liloux', 'Liloute', 'F', 'IND34231F', '2012-05-15', '2014-11-02', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (34308, 'Fizz', 'Scratch', 'F', 'MMX34308F', '2013-02-10', '2015-01-07', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 9, 9, 34231, 34232, NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (31523, 'Oshu\'Gun', NULL, 'M', 'TPX31523M', '2012-07-28', '2014-07-14', 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 10, 10, 29036, 23407, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (37802, 'Tanannan', NULL, 'M', 'WEE37802M', '2013-11-22', '2016-01-23', 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8, 7, 34308, 31523, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (37801, 'Manannan Mac Jean-Rat', 'Toutatis', 'M', 'WEE37801M', '2013-11-22', '2015-08-09', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8, 7, 34308, 31523, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO `lord`.`lord_rats` (`rat_id`, `rat_name_owner`, `rat_name_pup`, `rat_sex`, `rat_pedigree_identifier`, `rat_date_birth`, `rat_date_death`, `death_cause_primary_id`, `death_cause_secondary_id`, `rat_death_euthanized`, `rat_death_diagnosed`, `rat_death_necropsied`, `rat_picture`, `rat_picture_thumbnail`, `rat_comments`, `rat_validated`, `rattery_mother_id`, `rattery_father_id`, `rat_mother_id`, `rat_father_id`, `litter_id`, `user_owner_id`, `color_id`, `earset_id`, `eyecolor_id`, `dilution_id`, `coat_id`, `marking_id`, `singularity_id_list`, `user_creator_id`, `rat_date_create`, `rat_date_last_update`) VALUES (37806, 'Tuulikki', 'Aífé', 'F', 'WEE37806F', '2013-11-22', '2015-07-22', 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8, 7, 34308, 31523, 1, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lord`.`lord_singularities`
-- -----------------------------------------------------
START TRANSACTION;
USE `lord`;
INSERT INTO `lord`.`lord_singularities` (`singularity_id`, `singularity_name_fr`, `singularity_name_en`, `singularity_picture`) VALUES (DEFAULT, 'Etoilé', NULL, NULL);
INSERT INTO `lord`.`lord_singularities` (`singularity_id`, `singularity_name_fr`, `singularity_name_en`, `singularity_picture`) VALUES (DEFAULT, 'Fléché', NULL, NULL);
INSERT INTO `lord`.`lord_singularities` (`singularity_id`, `singularity_name_fr`, `singularity_name_en`, `singularity_picture`) VALUES (DEFAULT, 'Down under', NULL, NULL);
INSERT INTO `lord`.`lord_singularities` (`singularity_id`, `singularity_name_fr`, `singularity_name_en`, `singularity_picture`) VALUES (DEFAULT, 'Gants', NULL, NULL);
INSERT INTO `lord`.`lord_singularities` (`singularity_id`, `singularity_name_fr`, `singularity_name_en`, `singularity_picture`) VALUES (DEFAULT, 'Dwarf', NULL, NULL);

COMMIT;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
