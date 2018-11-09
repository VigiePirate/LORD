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
IF NOT EXISTS lord DEFAULT CHARACTER
SET utf8mb4 ;
USE lord
;

-- -----------------------------------------------------
-- Table lord.lord_roles
-- -----------------------------------------------------
-- DROP TABLE IF EXISTS lord.lord_roles ;

-- CREATE TABLE
-- IF NOT EXISTS lord.lord_roles
-- (
--   roles INT NOT NULL AUTO_INCREMENT,
--   role_name VARCHAR
-- (45) NULL,
--   PRIMARY KEY
-- (roles))
-- ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_users
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_users
;

CREATE TABLE
IF NOT EXISTS lord.lord_users
(
  user_id INT NOT NULL AUTO_INCREMENT,
  user_email VARCHAR
(70) NOT NULL,
  user_password VARCHAR
(32) NULL,
  user_sex CHAR NULL,
  user_name_first VARCHAR
(45) NULL,
  user_name_last VARCHAR
(45) NULL,
  user_login VARCHAR
(45) NULL,
  user_date_birth DATE NULL,
  user_newsletter TINYINT
(1) NULL,
  user_date_creation DATE NULL,
  user_date_last_update DATE NULL,
  roles LONGTEXT NOT NULL DEFAULT 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}',
  user_is_locked TINYINT
(1) NULL,
  user_failed_login_attempts TINYINT NULL,
  PRIMARY KEY
(user_id)
--   CONSTRAINT fk_lord_users_lord_roles1
--     FOREIGN KEY
-- (roles)
--     REFERENCES lord.lord_roles
-- (roles)
--     ON
-- DELETE NO ACTION
--     ON
-- UPDATE NO ACTION
)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_ratteries
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_ratteries
;

CREATE TABLE
IF NOT EXISTS lord.lord_ratteries
(
  rattery_id INT NOT NULL AUTO_INCREMENT,
  rattery_name VARCHAR
(70) NULL,
  raterie_prefix VARCHAR
(3) NULL,
  user_owner_id INT NOT NULL,
  rattery_comments TEXT NULL,
  rattery_picture VARCHAR
(255) NULL,
  rattery_status TINYINT
(1) NULL,
  rattery_validated TINYINT
(1) NULL,
  rattery_date_birth YEAR NULL,
  rattery_date_creation DATE NULL,
  rattery_date_last_update DATE NULL,
  PRIMARY KEY
(rattery_id),
  CONSTRAINT fk_lord_ratteries_lord_users1
    FOREIGN KEY
(user_owner_id)
    REFERENCES lord.lord_users
(user_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_eyecolors
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_eyecolors
;

CREATE TABLE
IF NOT EXISTS lord.lord_eyecolors
(
  eyecolor_id INT NOT NULL AUTO_INCREMENT,
  eyecolor_name_fr VARCHAR
(70) NULL,
  eyecolor_name_en VARCHAR
(70) NULL,
  eyecolor_picture VARCHAR
(255) NULL,
  PRIMARY KEY
(eyecolor_id))
ENGINE = InnoDB
COMMENT = 'Table contenant la liste des yeux';


-- -----------------------------------------------------
-- Table lord.lord_colors
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_colors
;

CREATE TABLE
IF NOT EXISTS lord.lord_colors
(
  color_id INT NOT NULL AUTO_INCREMENT,
  color_name_fr VARCHAR
(70) NULL,
  color_genotype VARCHAR
(70) NULL,
  color_name_en VARCHAR
(70) NULL,
  color_picture VARCHAR
(255) NULL,
  eyecolor_id INT NULL,
  PRIMARY KEY
(color_id),
  CONSTRAINT fk_lord_colors_lord_eyecolors1
    FOREIGN KEY
(eyecolor_id)
    REFERENCES lord.lord_eyecolors
(eyecolor_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_earsets
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_earsets
;

CREATE TABLE
IF NOT EXISTS lord.lord_earsets
(
  earset_id INT NOT NULL AUTO_INCREMENT,
  earset_name_fr VARCHAR
(70) NULL,
  earset_name_en VARCHAR
(70) NULL,
  earset_picture VARCHAR
(255) NULL,
  PRIMARY KEY
(earset_id))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_dilutions
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_dilutions
;

CREATE TABLE
IF NOT EXISTS lord.lord_dilutions
(
  dilution_id INT NOT NULL AUTO_INCREMENT,
  dilution_name_fr VARCHAR
(70) NULL,
  dilution_name_en VARCHAR
(70) NULL,
  dilution_picture VARCHAR
(255) NULL,
  PRIMARY KEY
(dilution_id))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des dilutions';


-- -----------------------------------------------------
-- Table lord.lord_coats
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_coats
;

CREATE TABLE
IF NOT EXISTS lord.lord_coats
(
  coat_id INT NOT NULL AUTO_INCREMENT,
  coat_name_fr VARCHAR
(70) NULL,
  coat_name_en VARCHAR
(70) NULL,
  coat_picture VARCHAR
(255) NULL,
  PRIMARY KEY
(coat_id))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des poils';


-- -----------------------------------------------------
-- Table lord.lord_markings
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_markings
;

CREATE TABLE
IF NOT EXISTS lord.lord_markings
(
  marking_id INT NOT NULL AUTO_INCREMENT,
  marking_name_fr VARCHAR
(70) NULL,
  marking_name_en VARCHAR
(70) NULL,
  marking_picture VARCHAR
(255) NULL,
  PRIMARY KEY
(marking_id))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des marquages';


-- -----------------------------------------------------
-- Table lord.lord_death_causes_primary
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_death_causes_primary
;

CREATE TABLE
IF NOT EXISTS lord.lord_death_causes_primary
(
  death_cause_primary_id INT NOT NULL AUTO_INCREMENT,
  death_cause_primary_name_fr VARCHAR
(100) NULL,
  death_cause_primary_name_en VARCHAR
(100) NULL,
  PRIMARY KEY
(death_cause_primary_id))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des causes de décès';


-- -----------------------------------------------------
-- Table lord.lord_death_causes_secondary
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_death_causes_secondary
;

CREATE TABLE
IF NOT EXISTS lord.lord_death_causes_secondary
(
  death_cause_secondary_id INT NOT NULL AUTO_INCREMENT,
  death_cause_secondary_name_fr VARCHAR
(100) NULL,
  death_cause_secondary_name_en VARCHAR
(100) NULL,
  deces_principal_id INT NOT NULL,
  PRIMARY KEY
(death_cause_secondary_id),
  CONSTRAINT fk_lord_deces_secondaire_lord_deces_principal1
    FOREIGN KEY
(deces_principal_id)
    REFERENCES lord.lord_death_causes_primary
(death_cause_primary_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_litters
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_litters
;

CREATE TABLE
IF NOT EXISTS lord.lord_litters
(
  litter_id INT NOT NULL AUTO_INCREMENT,
  litter_date_mating DATE NULL,
  litter_date_birth DATE NULL,
  litter_number_pups TINYINT NULL,
  litter_number_pups_stillborn TINYINT NULL,
  litter_comments TEXT NULL,
  rat_mother_id INT NOT NULL,
  rat_father_id INT NULL,
  user_owner_id INT NOT NULL,
  PRIMARY KEY
(litter_id),
  CONSTRAINT fk_lord_portee_lord_rats1
    FOREIGN KEY
(rat_mother_id)
    REFERENCES lord.lord_rats
(rat_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_lord_portee_lord_rats2
FOREIGN KEY
(rat_father_id)
    REFERENCES lord.lord_rats
(rat_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_lord_portee_lord_utilisateurs1
FOREIGN KEY
(user_owner_id)
    REFERENCES lord.lord_users
(user_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_rats
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_rats
;

CREATE TABLE
IF NOT EXISTS lord.lord_rats
(
  rat_id INT NOT NULL AUTO_INCREMENT,
  rat_name_owner VARCHAR
(70) NULL,
  rat_name_pup VARCHAR
(70) NULL,
  rat_sex CHAR NOT NULL,
  rat_pedigree_identifier VARCHAR
(10) NULL,
  rat_date_birth DATE NULL,
  rat_date_death DATE NULL,
  death_cause_primary_id INT NULL,
  death_cause_secondary_id INT NULL,
  rat_death_euthanized TINYINT
(1) NULL,
  rat_death_diagnosed TINYINT
(1) NULL,
  rat_death_necropsied TINYINT
(1) NULL,
  rat_picture VARCHAR
(255) NULL,
  rat_picture_thumbnail VARCHAR
(255) NULL,
  rat_comments TEXT NULL,
  rat_validated TINYINT
(1) NULL,
  rattery_mother_id INT NULL,
  rattery_father_id INT NULL,
  rat_mother_id INT NULL,
  rat_father_id INT NULL,
  litter_id INT NULL,
  user_owner_id INT NULL,
  color_id INT NULL,
  earset_id INT NULL,
  eyecolor_id INT NULL,
  dilution_id INT NULL,
  coat_id INT NULL,
  marking_id INT NULL,
  singularity_id_list VARCHAR
(15) NULL,
  user_creator_id INT NOT NULL,
  rat_date_create DATE NULL,
  rat_date_last_update DATE NULL,
  PRIMARY KEY
(rat_id),
  CONSTRAINT FK_origine
    FOREIGN KEY
(rattery_mother_id)
    REFERENCES lord.lord_ratteries
(rattery_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_pere
FOREIGN KEY
(rat_father_id)
    REFERENCES lord.lord_rats
(rat_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_mere
FOREIGN KEY
(rat_mother_id)
    REFERENCES lord.lord_rats
(rat_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT Fk_proprietaire
FOREIGN KEY
(user_owner_id)
    REFERENCES lord.lord_users
(user_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_couleur
FOREIGN KEY
(color_id)
    REFERENCES lord.lord_colors
(color_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_oreilles
FOREIGN KEY
(earset_id)
    REFERENCES lord.lord_earsets
(earset_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_yeux
FOREIGN KEY
(eyecolor_id)
    REFERENCES lord.lord_eyecolors
(eyecolor_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_dilutions
FOREIGN KEY
(dilution_id)
    REFERENCES lord.lord_dilutions
(dilution_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_poils
FOREIGN KEY
(coat_id)
    REFERENCES lord.lord_coats
(coat_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_marquage
FOREIGN KEY
(marking_id)
    REFERENCES lord.lord_markings
(marking_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_deces
FOREIGN KEY
(death_cause_primary_id)
    REFERENCES lord.lord_death_causes_primary
(death_cause_primary_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT FK_enregistreur
FOREIGN KEY
(user_creator_id)
    REFERENCES lord.lord_users
(user_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_origine_raterie_2
FOREIGN KEY
(rattery_father_id)
    REFERENCES lord.lord_ratteries
(rattery_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_deces_secondaire
FOREIGN KEY
(death_cause_secondary_id)
    REFERENCES lord.lord_death_causes_secondary
(death_cause_secondary_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_lord_rats_lord_litters1
FOREIGN KEY
(litter_id)
    REFERENCES lord.lord_litters
(litter_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Table centrale, qui contient l\'ensemble des rats enregistrés';

CREATE UNIQUE INDEX rat_id_UNIQUE ON lord.lord_rats (rat_id ASC);

CREATE UNIQUE INDEX rat_numero_UNIQUE ON lord.lord_rats (rat_pedigree_identifier ASC);


-- -----------------------------------------------------
-- Table lord.lord_singularities
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_singularities ;

CREATE TABLE IF NOT EXISTS lord.lord_singularities (
  singularity_id INT NOT NULL AUTO_INCREMENT,
  singularity_name_fr VARCHAR(70) NULL,
  singularity_name_en VARCHAR(70) NULL,
  singularity_picture VARCHAR(255) NULL,
  PRIMARY KEY (singularity_id))
ENGINE = InnoDB
COMMENT = 'Table référençant la liste des particularités';


-- -----------------------------------------------------
-- Table lord.lord_backoffice_rat_entries
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_backoffice_rat_entries ;

CREATE TABLE IF NOT EXISTS lord.lord_backoffice_rat_entries (
  lord_backoffice_rat_entry_id INT NOT NULL AUTO_INCREMENT,
  lord_backoffice_rat_entry_status TINYINT NULL,
  rat_id INT NULL,
  rat_name_owner VARCHAR(70) NULL,
  rat_name_pup VARCHAR(70) NULL,
  rat_sex CHAR NULL,
  rat_pedigree_identifier VARCHAR(10) NULL,
  rat_date_birth DATE NULL,
  rat_date_death DATE NULL,
  death_cause_primary_id INT NULL,
  death_cause_secondary_id INT NULL,
  rat_death_euthanized TINYINT(1) NULL,
  rat_death_diagnosed TINYINT(1) NULL,
  rat_death_necropsied TINYINT(1) NULL,
  rat_picture VARCHAR(255) NULL,
  rat_picture_thumbnail VARCHAR(255) NULL,
  rat_comments TEXT NULL,
  rat_validated TINYINT NULL,
  rattery_mother_id INT NULL,
  rattery_father_id INT NULL,
  rat_mother_id INT NULL,
  rat_father_id INT NULL,
  user_owner_id INT NULL,
  color_id INT NULL,
  earset_id INT NULL,
  eyecolor_id INT NULL,
  dilution_id INT NULL,
  coat_id INT NULL,
  marking_id INT NULL,
  singularity_id_list VARCHAR(15) NULL,
  user_creator_id INT NULL,
  rat_date_create DATE NULL,
  rat_date_last_update DATE NULL,
  PRIMARY KEY (lord_backoffice_rat_entry_id),
  CONSTRAINT FK_origine0
    FOREIGN KEY (rattery_mother_id)
    REFERENCES lord.lord_ratteries (rattery_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_pere0
    FOREIGN KEY (rat_father_id)
    REFERENCES lord.lord_backoffice_rat_entries (lord_backoffice_rat_entry_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_mere0
    FOREIGN KEY (rat_mother_id)
    REFERENCES lord.lord_backoffice_rat_entries (lord_backoffice_rat_entry_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT Fk_proprietaire0
    FOREIGN KEY (user_owner_id)
    REFERENCES lord.lord_users (user_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_couleur0
    FOREIGN KEY (color_id)
    REFERENCES lord.lord_colors (color_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_oreilles0
    FOREIGN KEY (earset_id)
    REFERENCES lord.lord_earsets (earset_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_yeux0
    FOREIGN KEY (eyecolor_id)
    REFERENCES lord.lord_eyecolors (eyecolor_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_dilutions0
    FOREIGN KEY (dilution_id)
    REFERENCES lord.lord_dilutions (dilution_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_poils0
    FOREIGN KEY (coat_id)
    REFERENCES lord.lord_coats (coat_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_marquage0
    FOREIGN KEY (marking_id)
    REFERENCES lord.lord_markings (marking_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_deces0
    FOREIGN KEY (death_cause_primary_id)
    REFERENCES lord.lord_death_causes_primary (death_cause_primary_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_enregistreur0
    FOREIGN KEY (user_creator_id)
    REFERENCES lord.lord_users (user_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_origine_raterie_20
    FOREIGN KEY (rattery_father_id)
    REFERENCES lord.lord_ratteries (rattery_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_deces_secondaire0
    FOREIGN KEY (death_cause_secondary_id)
    REFERENCES lord.lord_death_causes_secondary (death_cause_secondary_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_lord_backoffice_rat_entries_lord_rats1
    FOREIGN KEY (rat_id)
    REFERENCES lord.lord_rats (rat_id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Table centrale, qui contient l\'ensemble des rats enregistrés';

CREATE UNIQUE INDEX rat_id_UNIQUE ON lord.lord_backoffice_rat_entries
(lord_backoffice_rat_entry_id ASC);


-- -----------------------------------------------------
-- Table lord.lord_backoffice_rat_messages
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_backoffice_rat_messages
;

CREATE TABLE
IF NOT EXISTS lord.lord_backoffice_rat_messages
(
  backoffice_rat_message_id INT NOT NULL AUTO_INCREMENT,
  backoffice_rat_entry_id INT NOT NULL,
  user_staff_id INT NULL,
  backoffice_rat_message_staff_comments TEXT NULL,
  backoffice_rat_message_owner_comments TEXT NULL,
  backoffice_rat_message_date_staff_comments DATE NULL,
  backoffice_rat_message_date_owner_comments DATE NULL,
  PRIMARY KEY
(backoffice_rat_message_id),
  CONSTRAINT fk_lord_sav_lord_utilisateurs1
    FOREIGN KEY
(user_staff_id)
    REFERENCES lord.lord_users
(user_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_lord_backoffice_rat_messages_lord_backoffice_rat_entries1
FOREIGN KEY
(backoffice_rat_entry_id)
    REFERENCES lord.lord_backoffice_rat_entries
(lord_backoffice_rat_entry_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table lord.lord_backoffice_rattery_messages
-- -----------------------------------------------------
DROP TABLE IF EXISTS lord.lord_backoffice_rattery_messages
;

CREATE TABLE
IF NOT EXISTS lord.lord_backoffice_rattery_messages
(
  backoffice_rattery_message_id INT NOT NULL AUTO_INCREMENT,
  rattery_id INT NOT NULL,
  user_staff_id INT NULL,
  backoffice_rattery_message_staff_comments TEXT NULL,
  backoffice_rattery_message_owner_comments TEXT NULL,
  backoffice_rattery_messages_date_staff_comments DATE NULL,
  backoffice_rattery_messages_date_owner_comments DATE NULL,
  PRIMARY KEY
(backoffice_rattery_message_id),
  CONSTRAINT fk_lord_backoffice_rattery_messages_lord_ratteries1
    FOREIGN KEY
(rattery_id)
    REFERENCES lord.lord_ratteries
(rattery_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION,
  CONSTRAINT fk_lord_backoffice_rattery_messages_lord_users1
FOREIGN KEY
(user_staff_id)
    REFERENCES lord.lord_users
(user_id)
    ON
DELETE NO ACTION
    ON
UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = 'Echange backoffice / utilisateur sur une fiche raterie\n\nUne ligne = un échange (<> aller retour backoffice utilisateur)';


-- -----------------------------------------------------
-- Data for table lord.lord_roles
-- -----------------------------------------------------
-- START TRANSACTION;
-- USE lord;
-- INSERT INTO
-- lord.lord_roles
--
-- (roles, role_name) VALUES
-- (DEFAULT, 'user');
-- INSERT INTO
-- lord.lord_roles
--
-- (roles, role_name) VALUES
-- (DEFAULT, 'admin');

-- COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_users
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (1, 'raterie@raterie-stella.com', '6cfab3c59675dc5c99353c5e6f5be008', 'F', 'VALIA', 'VERRIERE', 'stella', '1976-07-09', NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (2, 'administrateur@lord-rat.org', NULL, NULL, 'Admin', NULL, 'admin', NULL, NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
10:"ROLE_ADMIN";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (3, 'sine.alexia@free.fr', '5d81d465cfc6f03bff54c5709a4737ba', 'F', 'Alexia', 'Siné', 'Limë', '1984-02-05', NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
10:"ROLE_ADMIN";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (5, 'artefact@entierement.nu', 'e8a8f22e0ebfcfd17f6f6170208621d9', 'F', 'Nancy', 'Bertin', 'Artefact', '1981-08-01', NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
10:"ROLE_ADMIN";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (6, 'pa@paratsite.fr', '992e29d3b368923a6383f05cdd4b4aa2', 'F', 'Marie', 'PA', 'Petit_ange', NULL, NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
10:"ROLE_ADMIN";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (DEFAULT, 'vautier.joanna@hotmail.fr', '8dd377e29ca5356032dc15fcb4cd877a', 'F', 'Joanna', 'Vautier', 'm0ua-haha', '2013-04-14', NULL, '2013-04-14', '2013-04-14', 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (DEFAULT, 'lorelei91310@hotmail.fr', '30f4ebe2cb080527ad19d808d00b8d6f', 'F', 'Loreleï', 'AMAURY', 'Miss-lolo-91', '1998-05-26', NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (DEFAULT, 'pouikpouiky@gmail.com', NULL, 'F', NULL, NULL, 'Pinky', NULL, NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (DEFAULT, 'marinar@lenautilus.fr', NULL, 'F', NULL, NULL, 'kerma', NULL, NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (DEFAULT, 'nezumi30@sfr.fr', NULL, 'F', NULL, NULL, 'ramses30', NULL, NULL, NULL, NULL, 'a:
1:{
i:
0;
s:
9:"ROLE_USER";}', NULL, NULL);
INSERT INTO
lord.lord_users

  (user_id, user_email, user_password, user_sex, user_name_first, user_name_last, user_login, user_date_birth, user_newsletter, user_date_creation, user_date_last_update, roles, user_is_locked, user_failed_login_attempts)
VALUES
  (DEFAULT, 'laurielegeret@free.fr', NULL, 'F', 'Laurie ', 'Legeret', 'louli', NULL, NULL, NULL, NULL, DEFAULT, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_ratteries
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, 'Les Vigies Pirates', 'VGP', 5, 'Propriétaire de mâles exclusivement. ', NULL, 1, 1, 2009, '2012-05-19', NULL);
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, '* Animalerie *', 'INC', 2, NULL, NULL, 1, 1, NULL, '2009-12-24', '2009-12-24');
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, '* Sauvetage *', 'INC', 2, NULL, NULL, 1, 1, NULL, '2009-12-24', '2009-12-24');
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, '* Eleveur indépendant *', 'IND', 2, NULL, NULL, 1, 1, NULL, '2009-05-14', '2009-05-14');
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, 'La Tarte au Citron', 'DTC', 3, 'La tarte au Citron est  membre de la National Fancy Rat Society et partenaire SRFA', NULL, 1, 1, NULL, NULL, '2018-01-20');
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, 'Soleil du grand sud', 'SGS', 1, NULL, NULL, 0, 0, 2003, '2009-07-01', '2009-07-01');
INSERT INTO
lord.lord_ratteries

  (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update)
VALUES
  (DEFAULT, 'PARatSite', 'PAZ', 6, 'Je ne souhaite faire que des portées externes, c\'est à dire avec des mâles', NULL, 0, 1, 2010, '2010-10-08
', NULL);
INSERT INTO lord.lord_ratteries (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update) VALUES (DEFAULT, 'RatLoween', 'WEE', 7, NULL, NULL, 0, 1, 2013, '2013-11-22', NULL);
INSERT INTO lord.lord_ratteries (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update) VALUES (DEFAULT, 'Le Souvenir de Moumix', 'MMX', 8, NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO lord.lord_ratteries (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update) VALUES (DEFAULT, 'Le Manoir des TouPoutouX', 'TPX', 9, 'Au Manoir des Toupoutoux, je travaille actuellement uniquement par les mâles. Nous avons collaboré à deux portées : RMM Xolotl et RLF-PAZ Zorya, et NIN-WYS Zizi et KTY Flash. ', NULL, 0, 1, NULL, NULL, NULL);
INSERT INTO lord.lord_ratteries (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update) VALUES (DEFAULT, 'KerMa Rats', 'KMR', 10, NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO lord.lord_ratteries (rattery_id, rattery_name, raterie_prefix, user_owner_id, rattery_comments, rattery_picture, rattery_status, rattery_validated, rattery_date_birth, rattery_date_creation, rattery_date_last_update) VALUES (DEFAULT, 'KTY-minis', 'KTY', 11, NULL, NULL, 1, 1, NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_eyecolors
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_eyecolors (eyecolor_id, eyecolor_name_fr, eyecolor_name_en, eyecolor_picture) VALUES (DEFAULT, 'Noir', NULL, NULL);
INSERT INTO lord.lord_eyecolors (eyecolor_id, eyecolor_name_fr, eyecolor_name_en, eyecolor_picture) VALUES (DEFAULT, 'Rouge', NULL, NULL);
INSERT INTO lord.lord_eyecolors (eyecolor_id, eyecolor_name_fr, eyecolor_name_en, eyecolor_picture) VALUES (DEFAULT, 'Dark rubis', NULL, NULL);
INSERT INTO lord.lord_eyecolors (eyecolor_id, eyecolor_name_fr, eyecolor_name_en, eyecolor_picture) VALUES (DEFAULT, 'Rose', NULL, NULL);
INSERT INTO lord.lord_eyecolors (eyecolor_id, eyecolor_name_fr, eyecolor_name_en, eyecolor_picture) VALUES (DEFAULT, 'Vairon', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_colors
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Agouti', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre', 'Agouti + PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre bleu', 'Agouti + PED + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre dove', 'Agouti + PED + Mink + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre dove mock', 'Agouti + PED + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre lavande', 'Agouti + PED + Mink + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre lavande mock', 'Agouti + PED + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre mink', 'Agouti + PED + Mink', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre mock', 'Agouti + PED + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ambre russe', 'Agouti + PED + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Beige', 'Noir + RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Beige dove', 'Noir + RED + Mink + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Beige dove mock', 'Noir + RED + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Beige mink', 'Noir + RED + Mink', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Beige mock', 'Noir + RED + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Beige russe', 'Noir + RED + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Bleu russe', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Bleu russe agouti', 'Agouti + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Bleu us', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Bleu us agouti', 'Agouti + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Cannelle', 'Agouti + Mink', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Cannelle mock', 'Agouti + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Champagne', 'Noir + PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Champagne mink', 'Noir + PED + Mink', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Champagne mock', 'Noir + PED + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Champagne russe', 'Noir + PED + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Chocolat', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double bleu', 'Noir + Bus + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double bleu agouti', 'Agouti + Bus + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double cannelle bleu', 'Agouti + Mink + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double cannelle russe', 'Agouti + Mink + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double cannelle', 'Agouti + Mink + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double havane', 'Noir + Mink + Mock + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double havane agouti', 'Agouti + Mink + Mock + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double havane russe', 'Noir + Mink + Mock + Br + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double havane russe agouti', 'Agouti + Mink + Mock + Br + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double lilas', 'Noir + Mink + Mock + Bus + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double lilas agouti', 'Agouti + Mink + Mock + Bus + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double mink', 'Noir + Mink + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double mink bleu', 'Noir + Mink + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double mink russe', 'Noir + Mink + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double moka', 'Noir + Mink + Mock + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double moka agouti', 'Agouti + Mink + Mock + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double moka bleu', 'Noir + Mink + Mock + Bus + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double moka bleu agouti', 'Agouti + Mink + Mock + Bus + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double moka russe', 'Noir + Mink + Mock + Br + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Double moka russe agouti', 'Agouti + Mink + Mock + Br + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Dove', 'Noir + Mink + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Dove agouti', 'Agouti + Mink + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Dove mock', 'Noir + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Dove mock agouti', 'Agouti + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Graphite', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane', 'Noir + Mink + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane agouti', 'Agouti + Mink + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane mock', 'Noir + Mock + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane mock agouti', 'Agouti + Mock + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane russe', 'Noir + Mink + Br + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane russe agouti', 'Agouti + Mink + Br + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane russe mock', 'Noir + Mock + Br + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Havane russe mock agouti', 'Agouti + Mock + Br + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ice', 'Noir + PED + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ice mink', 'Noir + PED + Mink + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Ice mock', 'Noir + PED + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lavande', 'Noir + Mink + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lavande agouti', 'Agouti + Mink + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lavande mock', 'Noir + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lavande mock agouti', 'Agouti + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lilas', 'Noir + Mink + Bus + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lilas agouti', 'Agouti + Mink + Bus + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lilas mock', 'Noir + Mock + Bus + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Lilas mock agouti', 'Agouti + Mock + Bus + porteur RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Mink', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Mock', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka', 'Noir + Mink + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka agouti', 'Agouti + Mink + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka bleu', 'Noir + Mink + Bus + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka bleu agouti', 'Agouti + Mink + Bus + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka bleu mock', 'Noir + Mock + Bus + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka bleu mock agouti', 'Agouti + Mock + Bus + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka mock', 'Noir + Mock + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka mock agouti', 'Agouti + Mock + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka russe', 'Noir + Mink + Br + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka russe agouti', 'Agouti + Mink + Br + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka russe mock', 'Noir + Mock + Br + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Moka russe mock agouti', 'Agouti + Mock + Br + porteur PED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Noir', NULL, NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Platine', 'Noir + RED + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Platine mink', 'Noir + RED + Mink + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Platine mock', 'Noir + RED + Mock + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze', 'Agouti + RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze bleu', 'Agouti + RED + Bus', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze dove', 'Agouti + RED + Mink + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze dove mock', 'Agouti + RED + Mock + Br', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze mink', 'Agouti + Mink + RED', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze mock', 'Agouti + RED + Mock', NULL, NULL, NULL);
INSERT INTO lord.lord_colors (color_id, color_name_fr, color_genotype, color_name_en, color_picture, eyecolor_id) VALUES (DEFAULT, 'Topaze russe', 'Agouti + RED + Br', NULL, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_earsets
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_earsets (earset_id, earset_name_fr, earset_name_en, earset_picture) VALUES (DEFAULT, 'Standard', NULL, NULL);
INSERT INTO lord.lord_earsets (earset_id, earset_name_fr, earset_name_en, earset_picture) VALUES (DEFAULT, 'Dumbo', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_dilutions
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Albinos', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'BED - Black Eyed Devil', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'BEH - Black Eyed Himalayan', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'BES - Black Eyed Siamese', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Burmese himalayen', '', NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Burmese sable himalayen', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Burmese sable siamois', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Burmese siamois', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Biscuit
(burmese albinos)', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Himalayen', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Ivory
(albinos yeux noirs)', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'RED - Red Eyed Devil', NULL, NULL);
INSERT INTO lord.lord_dilutions (dilution_id, dilution_name_fr, dilution_name_en, dilution_picture) VALUES (DEFAULT, 'Siamois', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_coats
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Lisse', NULL, NULL);
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Rex', NULL, NULL);
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Double-rex', NULL, NULL);
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Velours', NULL, NULL);
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Nu', NULL, NULL);
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Satin', NULL, NULL);
INSERT INTO lord.lord_coats (coat_id, coat_name_fr, coat_name_en, coat_picture) VALUES (DEFAULT, 'Harley', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_markings
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Uni', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Irish', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Hooded', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Varieberk', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Capé', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Berkshire', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Varihooded', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Bareback', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Variegated', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Masqué', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Dalmatien', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Patché', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Oppossum', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Husky', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Essex', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'Baldie', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'PEW', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'REW', NULL, NULL);
INSERT INTO lord.lord_markings (marking_id, marking_name_fr, marking_name_en, marking_picture) VALUES (DEFAULT, 'BEW', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_death_causes_primary
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (1, 'Cause inconnue', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (2, 'Accidents, traumatismes, intoxications', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (3, 'Cardio-vasculaire', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (4, 'Digestif', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (5, 'Mortalité infantile
(moins de 6 semaines)', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (6, 'Muscles et squelette', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (7, 'Neurologique
(cerveau, moelle épinière, nerfs)', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (8, 'Œil, oreille, bouche, face', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (9, 'Peau', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (10, 'Respiratoire', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (11, 'Système reproducteur', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (12, 'Système urinaire
(reins, vessie)', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (13, 'Vieillesse, mort naturelle
(24 mois minimum)', NULL);
INSERT INTO lord.lord_death_causes_primary (death_cause_primary_id, death_cause_primary_name_fr, death_cause_primary_name_en) VALUES (14, 'Autres', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_death_causes_secondary
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (1, 'Aucune information
(présumé mort)', NULL, 1);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Cause indéterminée
(date connue)', NULL, 1);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Accident domestique
(écrasement, accident de porte... )', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Accident vétérinaire
(anesthésie lors d’une opération mineure, erreur médicale...)', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Bagarres, blessures, morsures graves, hémorragie consécutive
(hors hémorragie anormale)', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Brûlures thermiques ou chimiques', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Chutes, fractures, traumatisme crânien ou de la moelle épinière
(hors bagarres)', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Coup de chaleur', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Étouffement, fausse route', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Empoisonnement
(produits ménagers, poisons, médicaments volés...)', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Intoxication alimentaire', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Surdosage médicamenteux
(médicaments vétérinaires prescrits)', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre accident ou traumatisme', NULL, 2);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Crise cardiaque, infarctus, embolie pulmonaire', NULL, 3);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Insuffisance cardiaque, valvulopathie', NULL, 3);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Hémorragie
(exagérée par rapport au contexte, anomalie de la coagulation, hémophilie)', NULL, 3);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème cardiaque ou vasculaire', NULL, 3);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Abcès digestif', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Gastro-entérite, diarrhée', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Hémorragie digestive', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Insuffisance hépatique', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Malnutrition', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Mégacôlon héréditaire', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Occlusion intestinale
(hors mégacôlon)', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Prolapsus rectal', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur digestive
(estomac, foie, pancréas, intestins...)', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème digestif', NULL, 4);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Malformation, hydrocéphalie', NULL, 5);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Manque de lait', NULL, 5);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Mort-né', NULL, 5);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre cause de mort infantile', NULL, 5);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection / abcès musculaire', NULL, 6);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection articulaire ou osseuse, arthrite septique', NULL, 6);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur musculaire', NULL, 6);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur osseuse', NULL, 6);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème du système locomoteur', NULL, 6);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Accident vasculaire cérébral', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Atteinte progressive de la moelle épinière, paralysie dégénérative', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Epilepsie', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection du cerveau, encéphalite, méningite', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur cérébrale', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur hypophysaire
(pituitaire)', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème neurologique', NULL, 7);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Abcès dentaire', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Abcès facial
(hors dentaire et Zymbal)', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Abcès rétro-orbitaire', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Glaucome', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Malocclusion dentaire', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Otite, abcès dans l’oreille', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur de la glande de Zymbal', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur de la face
(hors Zymbal)', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur rétro-orbitaire', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème touchant la tête', NULL, 8);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Abcès sous-cutané', NULL, 9);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection étendue de la peau
(pyodermite, escarres...)', NULL, 9);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Pododermatite', NULL, 9);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur cutanée, cancer de la peau', NULL, 9);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème de peau', NULL, 9);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Bronchite, pneumonie', NULL, 10);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Œdème pulmonaire', NULL, 10);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur pulmonaire, métastases pulmonaires', NULL, 10);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème respiratoire', NULL, 10);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Complications de gestation ou de mise-bas', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection de l’utérus
(métrite, pyomètre)', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Prolapsus vaginal
(hors tumeurs et postpartum)', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur mammaire', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur ovarienne', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur utérine', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur vaginale', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur de la prostate', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur testiculaire', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur des glandes préputiales', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème du système reproducteur', NULL, 11);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection urinaire ou rénale', NULL, 12);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Insuffisance rénale', NULL, 12);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Obstruction de l’urètre, rétention urinaire, calculs', NULL, 12);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur de la vessie', NULL, 12);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur du rein', NULL, 12);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre problème du système urinaire', NULL, 12);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Allergie, choc anaphylactique', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Cancer généralisé, leucémie, lymphome', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Diabète', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Euthanasie sans cause médicale', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Infection / abcès indéterminé', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Parasites', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Septicémie', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur autre
(salivaire, splénique, surrénale, thyroïde...)', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Tumeur indéterminée
(organe atteint inconnu)', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Virus, épidémie, déficience immunitaire
(SDA, Sendaï, Tyzzer...)', NULL, 14);
INSERT INTO lord.lord_death_causes_secondary (death_cause_secondary_id, death_cause_secondary_name_fr, death_cause_secondary_name_en, deces_principal_id) VALUES (DEFAULT, 'Autre cause connue ne rentrant dans aucune catégorie', NULL, 14);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_litters
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_litters (litter_id, litter_date_mating, litter_date_birth, litter_number_pups, litter_number_pups_stillborn, litter_comments, rat_mother_id, rat_father_id, user_owner_id) VALUES (1, '2013-10-31', '2013-11-22', 13, 1, NULL, 34308, 31523, 7);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_rats
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO lord.lord_rats (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update) VALUES (29036, 'Pillywiggin', 'Barbabulle', 'F', 'KTY29036F', '2012-01-07', '2014-04-24', 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 12, 4, NULL, NULL, NULL, 11, 1, 2, 1, NULL, 4, 2, '4', 6, NULL, NULL);
INSERT INTO lord.lord_rats (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update) VALUES (34232, 'Nemo', '', 'M', 'INC34232M', '2012-11-15', '2014-10-30', 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, 8, 19, 2, 1, NULL, 2, 1, NULL, 6, NULL, NULL);
INSERT INTO lord.lord_rats (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update) VALUES (34231, 'Liloux', 'Liloute', 'F', 'IND34231F', '2012-05-15', '2014-11-02', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 4, NULL, NULL, NULL, NULL, 8, 17, 2, 1, NULL, 1, 1, NULL, 6, NULL, NULL);
INSERT INTO lord.lord_rats (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update) VALUES (34308, 'Fizz', 'Scratch', 'F', 'MMX34308F', '2013-02-10', '2015-01-07', 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 9, 9, 34231, 34232, NULL, 7, 19, 2, 1, NULL, 2, 1, NULL, 6, NULL, NULL);
INSERT INTO lord.lord_rats (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update) VALUES (31523, 'Oshu\'Gun', NULL, 'M', 'TPX31523M', '2012-07-28', '2014-07-14', 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 10, 10, 29036, 23407, NULL, 6, 1, 2, 1, NULL, 3, 1, NULL, 6, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (37802, 'Tanannan', NULL, 'M', 'WEE37802M', '2013-11-22', '2016-01-23', 4, NULL, 1, 1, NULL, NULL, NULL, NULL, 1, 8, 7, 34308, 31523, 1, 6, 19, 2, 1, NULL, 3, 1, NULL, 6, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (37801, 'Manannan Mac Jean-Rat', 'Toutatis', 'M', 'WEE37801M', '2013-11-22', '2015-08-09', 1, 2, 1, NULL, NULL, NULL, NULL, NULL, 1, 8, 7, 34308, 31523, 1, 6, 19, 2, 1, NULL, 3, 1, NULL, 6, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (37806, 'Tuulikki', 'Aífé', 'F', 'WEE37806F', '2013-11-22', '2015-07-22', 12, 74, NULL, NULL, NULL, NULL, NULL, NULL, 1, 8, 7, 34308, 31523, 1, 6, 86, 2, 2, 13, 2, NULL, NULL, 6, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (23407, 'Nagual', 'Canis Mucilagus', 'M', 'KMR23407M', '2010-12-21', '2012-10-05', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, 1, 11, 10, NULL, NULL, NULL, 9, 64, 2, 4, 13, 2, 1, NULL, 6, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (31543, 'Woodewood Chuckchuck', NULL, 'M', 'TPX31543M', '2012-07-28', '2014-01-18', 7, NULL, 1, NULL, NULL, NULL, NULL, NULL, 1, 10, 10, 29036, 23407, NULL, 5, 1, 2, 1, NULL, 3, 2, '4', 5, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (31549, 'Piccadilly', NULL, 'F', 'TPX31549F', '2012-07-28', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, 1, 10, 10, 29306, 23407, NULL, 6, 1, 2, 1, NULL, 3, 4, '1;4', 6, NULL, NULL);
INSERT INTO
lord.lord_rats

  (rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, litter_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (44255, 'Evinrude', 'Niniane', 'F', 'KMR44255F', '2015-06-23', '2017-02-06', 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, 0, 11, 7, NULL, 37802, NULL, 12, 1, 2, 1, NULL, 2, 2, NULL, 6, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_singularities
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO
lord.lord_singularities

  (singularity_id, singularity_name_fr, singularity_name_en, singularity_picture)
VALUES
  (DEFAULT, 'Etoilé', NULL, NULL);
INSERT INTO
lord.lord_singularities

  (singularity_id, singularity_name_fr, singularity_name_en, singularity_picture)
VALUES
  (DEFAULT, 'Fléché', NULL, NULL);
INSERT INTO
lord.lord_singularities

  (singularity_id, singularity_name_fr, singularity_name_en, singularity_picture)
VALUES
  (DEFAULT, 'Down under', NULL, NULL);
INSERT INTO
lord.lord_singularities

  (singularity_id, singularity_name_fr, singularity_name_en, singularity_picture)
VALUES
  (DEFAULT, 'Gants', NULL, NULL);
INSERT INTO
lord.lord_singularities

  (singularity_id, singularity_name_fr, singularity_name_en, singularity_picture)
VALUES
  (DEFAULT, 'Dwarf', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_backoffice_rat_entries
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO
lord.lord_backoffice_rat_entries

  (lord_backoffice_rat_entry_id, lord_backoffice_rat_entry_status, rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (DEFAULT, 0, 44255, 'Evinrude', 'Niniane', 'F', 'KMR44255F', '2015-06-23', '2017-02-06', 1, 2, NULL, NULL, NULL, NULL, NULL, 'Ajout d\'
un commentaire sur le rat ', NULL, 11, 7, NULL, 37802, 12, 1, 2, 1, NULL, 2, 2, NULL, 6, NULL, NULL);
INSERT INTO lord.lord_backoffice_rat_entries (lord_backoffice_rat_entry_id, lord_backoffice_rat_entry_status, rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update) VALUES (DEFAULT, 0, NULL, 'Rat
Create Test', NULL, 'M', NULL, '2018-09-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Test d\'une soumission de création de rat', NULL, 11, 7, NULL, 37802, 6, 1, 2, 1, NULL, 2, 2, NULL, 6, '2018-09-15', NULL);
INSERT INTO
lord.lord_backoffice_rat_entries

  (lord_backoffice_rat_entry_id, lord_backoffice_rat_entry_status, rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (DEFAULT, 1, 31549, 'Piccadilly', 'Bébé raton', 'F', 'TPX31549F', '2012-07-28', '2015-11-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 10, 29306, 23407, 6, 1, 2, 1, NULL, 3, 4, '1;4', 6, NULL, '2018-09-15');
INSERT INTO
lord.lord_backoffice_rat_entries

  (lord_backoffice_rat_entry_id, lord_backoffice_rat_entry_status, rat_id, rat_name_owner, rat_name_pup, rat_sex, rat_pedigree_identifier, rat_date_birth, rat_date_death, death_cause_primary_id, death_cause_secondary_id, rat_death_euthanized, rat_death_diagnosed, rat_death_necropsied, rat_picture, rat_picture_thumbnail, rat_comments, rat_validated, rattery_mother_id, rattery_father_id, rat_mother_id, rat_father_id, user_owner_id, color_id, earset_id, eyecolor_id, dilution_id, coat_id, marking_id, singularity_id_list, user_creator_id, rat_date_create, rat_date_last_update)
VALUES
  (DEFAULT, 2, NULL, 'Be-Bop-a-Lula', 'Sianna', 'F', NULL, '2015-06-23', '2018-02-10', 10, 59, 1, NULL, NULL, NULL, NULL, NULL, NULL, 11, 7, NULL, 37802, 6, 1, 2, 1, NULL, 2, 2, NULL, 6, '2018-09-15', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table lord.lord_backoffice_rat_messages
-- -----------------------------------------------------
START TRANSACTION;
USE lord;
INSERT INTO
lord.lord_backoffice_rat_messages

  (backoffice_rat_message_id, backoffice_rat_entry_id, user_staff_id, backoffice_rat_message_staff_comments, backoffice_rat_message_owner_comments, backoffice_rat_message_date_staff_comments, backoffice_rat_message_date_owner_comments)
VALUES
  (DEFAULT, 3, 5, 'Merci de préciser la cause de décès', NULL, '2018-09-15', NULL);
INSERT INTO
lord.lord_backoffice_rat_messages

  (backoffice_rat_message_id, backoffice_rat_entry_id, user_staff_id, backoffice_rat_message_staff_comments, backoffice_rat_message_owner_comments, backoffice_rat_message_date_staff_comments, backoffice_rat_message_date_owner_comments)
VALUES
  (DEFAULT, 4, 5, 'Merci de préciser la cause de décès', 'Je l\'
avais oubliée, pardon c\'est corrigé', '2018-09-15', '2018-09-15');

COMMIT;


SET SQL_MODE
=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS
=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS
=@OLD_UNIQUE_CHECKS;
