<?php

$sql_chat = "
CREATE TABLE IF NOT EXISTS `chat` (
	`id`					INT						UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_membre`				INT						UNSIGNED NOT NULL,
	`date`					BIGINT					UNSIGNED NOT NULL,
	`message`				TEXT					NOT NULL,
	PRIMARY KEY(`id`),
	KEY(`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_log_edit = "
CREATE TABLE IF NOT EXISTS `log_edit` (
	`id`		INT		UNSIGNED NOT NULL AUTO_INCREMENT,
	`table`		VARCHAR(50)	NOT NULL,
	`id_membre`	INT		UNSIGNED NOT NULL,
	`colonne`	VARCHAR(50)	NOT NULL,
	`action`	VARCHAR(20)	NOT NULL,
	`old_value`	TEXT		NULL,
	`new_value`	TEXT		NULL,
	`date`		BIGINT		UNSIGNED NOT NULL,
	PRIMARY KEY(`id`),
	KEY(`table`),
	KEY(`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_users = "
CREATE TABLE IF NOT EXISTS `users` (
	`id_membre`				MEDIUMINT						UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`old_id`				MEDIUMINT						UNSIGNED NOT NULL UNIQUE,
	`email`					VARCHAR(255)					NOT NULL UNIQUE,
	`mdp`					VARCHAR(32)						NOT NULL,
	`mdp_v2`				VARCHAR(255)					NULL,
	`pseudo`				VARCHAR(50)						NOT NULL,
	`level`					ENUM('admin','membre','staff')	NOT NULL,
	`date_inscription`		BIGINT							UNSIGNED NOT NULL,
	`date_visite`			BIGINT							UNSIGNED NOT NULL,
	`date_maj`				BIGINT							UNSIGNED NOT NULL,
	`etat`					TINYINT							UNSIGNED NOT NULL,
	PRIMARY KEY(`id_membre`),
	KEY(`old_id`),
	KEY(`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_users_noms = "
CREATE TABLE IF NOT EXISTS `users_noms` (
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL UNIQUE,
	`civilite`				TINYINT(1)				UNSIGNED NULL,
	`prenom`				VARCHAR(64)				NULL,
	`nom`					VARCHAR(64)				NULL,
	KEY(`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$sql_users_civilites = "
CREATE TABLE IF NOT EXISTS `users_civilites` (
	`id_civilite`			TINYINT(1)				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom`					VARCHAR(10)				NOT NULL UNIQUE,
	`abreviation`			VARCHAR(4)				NOT NULL UNIQUE,
	PRIMARY KEY(`id_civilite`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;";

$sql_users_date_naissance = "
CREATE TABLE IF NOT EXISTS `users_date_naissance` (
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL UNIQUE,
	`date`					BIGINT					UNSIGNED NOT NULL,
	KEY(`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$sql_users_adresses = "
CREATE TABLE IF NOT EXISTS `users_adresses` (
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL UNIQUE,
	`adresse`				VARCHAR(100)			NOT NULL,
	`pays`					CHAR(3)					NOT NULL,
	`ville`					INT						UNSIGNED NOT NULL,
	KEY(`id_membre`),
	KEY(`pays`),
	KEY(`ville`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$sql_users_sites = "
CREATE TABLE IF NOT EXISTS `users_sites` (
	`id_site`				INT						UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL,
	`nom`					VARCHAR(50)				NULL,
	`url`					VARCHAR(255)			NOT NULL,
	PRIMARY KEY(`id_site`),
	KEY (`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_users_presentations = "
CREATE TABLE IF NOT EXISTS `users_presentations` (
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL UNIQUE,
	`presentation`			TEXT					NOT NULL,
	KEY(`id_membre`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_users_messagerie = "
CREATE TABLE IF NOT EXISTS `users_messagerie` (
	`id_message`			BIGINT					UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`expediteur`			MEDIUMINT				UNSIGNED NOT NULL,
	`destinataire`			MEDIUMINT				UNSIGNED NOT NULL,
	`titre`					VARCHAR(50)				NOT NULL,
	`message`				TINYTEXT				NOT NULL,
	`date`					BIGINT					UNSIGNED NOT NULL,
	PRIMARY KEY(`id_message`),
	KEY(`expediteur`),
	KEY(`destinataire`),
	KEY(`date`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_users_tokens = "
CREATE TABLE IF NOT EXISTS `users_tokens` (
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL,
	`token`					VARCHAR(40)				NOT NULL,
	`date_crea`				BIGINT					UNSIGNED NOT NULL,
	`date_expiration`		BIGINT					UNSIGNED NOT NULL,
	PRIMARY KEY(`token`),
	KEY(`id_membre`),
	KEY(`date_crea`),
	KEY(`date_expiration`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$sql_rateries = "
CREATE TABLE IF NOT EXISTS `rateries` (
	`id_raterie`			INT						UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_membre`				MEDIUMINT				UNSIGNED NOT NULL,
	`affixe`				VARCHAR(3)				NOT NULL,
	`nom`					VARCHAR(50)				NOT NULL,
	`status`				TINYINT(1)				UNSIGNED NOT NULL,
	`date_ajout`			BIGINT					UNSIGNED NOT NULL,
	`date_user_view`		BIGINT					UNSIGNED NOT NULL,
	`date_last_edit`		BIGINT					UNSIGNED NOT NULL,
	PRIMARY KEY(`id_raterie`),
	KEY(`id_membre`),
	KEY(`affixe`),
	KEY(`date_ajout`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rateries_messages = "
CREATE TABLE IF NOT EXISTS `rateries_messages` (
	`id_message`			INT						UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_raterie`			INT						UNSIGNED NOT NULL,
	`id_user`				MEDIUMINT				UNSIGNED NOT NULL,
	`titre`					VARCHAR(255)			NOT NULL,
	`message`				TEXT					NOT NULL,
	`date_envoi`			BIGINT					UNSIGNED NOT NULL,
	`date_lecture`			BIGINT					UNSIGNED NOT NULL,
	PRIMARY KEY(`id_message`),
	KEY(`id_raterie`),
	KEY(`id_user`),
	KEY(`date_envoi`),
	KEY(`date_lecture`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rateries_actions = "
CREATE TABLE IF NOT EXISTS `rateries_actions` (
	`id_action`				INT						UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_raterie`			INT						UNSIGNED NOT NULL,
	`id_user`				INT						UNSIGNED NOT NULL,
	`action`				TINYINT(1)				UNSIGNED NOT NULL,
	`date_action`			BIGINT					UNSIGNED NOT NULL,
	PRIMARY KEY(`id_action`),
	KEY(`id_raterie`),
	KEY(`id_user`),
	KEY(`date_action`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rateries_images = "
CREATE TABLE IF NOT EXISTS `rateries_images` (
	`id_photo_raterie`			INT					UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_raterie`				INT					UNSIGNED NOT NULL,
	`fichier`					VARCHAR(50)			NOT NULL,
	`status_rateries_images`	TINYINT(1)			UNSIGNED NOT NULL,
	`date_ajout`				BIGINT				UNSIGNED NOT NULL,
	`date_user_view`			BIGINT				UNSIGNED NOT NULL,
	`date_last_edit`			BIGINT				UNSIGNED NOT NULL,
	PRIMARY KEY(`id_photo_raterie`),
	KEY(`id_raterie`),
	KEY(`date_ajout`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rateries_presentations = "
CREATE TABLE IF NOT EXISTS `rateries_presentations` (
	`id_raterie`				INT					UNSIGNED NOT NULL UNIQUE,
	`presentation`				TEXT				NOT NULL,
	`status_presentation`		TINYINT(1)			UNSIGNED NOT NULL,
	KEY(`id_raterie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$sql_rateries_sites = "
CREATE TABLE IF NOT EXISTS `rateries_sites` (
	`id_site_raterie`			INT					UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_raterie`				MEDIUMINT			UNSIGNED NOT NULL,
	`nom`						VARCHAR(50)			NULL,
	`url`						VARCHAR(255)		NOT NULL,
	PRIMARY KEY(`id_site_raterie`),
	KEY (`id_raterie`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats = "
CREATE TABLE IF NOT EXISTS `rats` (
	`id`						INT					UNSIGNED NOT NULL AUTO_INCREMENT,
	`raterie`					INT					UNSIGNED NOT NULL,
	`nom_courant_rat`			VARCHAR(255)		NULL,
	`nom_naissance_rat`			VARCHAR(255)		NULL,
	`sexe`						ENUM('M','F')		NOT NULL,
	`numero`					VARCHAR(20)			NOT NULL UNIQUE,
	`pere`						INT					UNSIGNED NOT NULL DEFAULT '0',
	`mere`						INT					UNSIGNED NOT NULL DEFAULT '0',
	`date_naissance`			BIGINT				UNSIGNED NOT NULL DEFAULT '0',
	`date_deces`				BIGINT				UNSIGNED NOT NULL DEFAULT '0',
	`cause_deces`				TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`user`						MEDIUMINT			UNSIGNED NOT NULL DEFAULT '0',
	`couleur`					TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`dilution`					TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`marquage`					TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`oreilles`					TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`poils`						TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`yeux`						TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	`portee`					INT					UNSIGNED NOT NULL DEFAULT '0',
	`repro`						ENUM('Oui','Non')	NOT NULL DEFAULT 'Non',
	`repro_date`				BIGINT				UNSIGNED NOT NULL DEFAULT '0',
	`commentaires`				TEXT				NULL,
	`date_ajout`				BIGINT				UNSIGNED NOT NULL DEFAULT '0',
	`date_user_view`			BIGINT				UNSIGNED NOT NULL DEFAULT '0',
	`date_last_edit`			BIGINT				UNSIGNED NOT NULL DEFAULT '0',
	`etat`						TINYINT				UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY(`id`),
	KEY(`raterie`),
	KEY(`numero`),
	KEY(`etat`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_edit = "
CREATE TABLE IF NOT EXISTS `rats_edit` (
	`id_rat`					INT					UNSIGNED NOT NULL,
	`type_info`					VARCHAR(20)			NOT NULL,
	`contenu_info`				TEXT				NOT NULL,
	`status_edit`				TINYINT(1)			UNSIGNED NOT NULL,
	`date_edit`					BIGINT				NOT NULL,
	PRIMARY KEY(`id_rat`),
	KEY(`type_info`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";

$sql_rats_link_pb_santes = "
CREATE TABLE IF NOT EXISTS `rats_link_pb_santes` (
	`id_link`					INT					UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_rat`					INT					UNSIGNED NOT NULL,
	`id_pb_santes`				TINYINT				UNSIGNED NOT NULL,
	PRIMARY KEY(`id_link`),
	KEY(`id_rat`),
	KEY(`id_pb_santes`)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_link_uniques = "
CREATE TABLE IF NOT EXISTS `rats_link_uniques` (
	`id_link`					INT					UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_rat`					INT					UNSIGNED NOT NULL,
	`id_unique`					TINYINT				UNSIGNED NOT NULL,
	PRIMARY KEY(`id_link`),
	KEY(`id_rat`),
	KEY(`id_unique`)
)  ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_actions = "
CREATE TABLE IF NOT EXISTS `rats_actions` (
	`id_action`					BIGINT				UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_rat`					INT					UNSIGNED NOT NULL,
	`id_user`					INT					UNSIGNED NOT NULL,
	`action`					TINYINT(1)			UNSIGNED NOT NULL,
	`date_action`				INT					UNSIGNED NOT NULL,
	PRIMARY KEY(`id_action`),
	KEY(`id_rat`),
	KEY(`id_user`),
	KEY(`date_action`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_images = "
CREATE TABLE IF NOT EXISTS `rats_images` (
	`id_photo_rat`				INT					UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_rat`					INT					UNSIGNED NOT NULL,
	`fichier`					VARCHAR(50) 		NOT NULL,
	`status_rat_images`			TINYINT(1)			UNSIGNED NOT NULL,
	`date_ajout`				BIGINT				UNSIGNED NOT NULL,
	`date_user_view`			BIGINT				UNSIGNED NOT NULL,
	`date_last_edit`			BIGINT				UNSIGNED NOT NULL,
	PRIMARY KEY(`id_photo_rat`),
	KEY(`id_rat`),
	KEY(`date_ajout`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_causes_deces = "
CREATE TABLE IF NOT EXISTS `rats_causes_deces` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_couleurs = "
CREATE TABLE IF NOT EXISTS `rats_couleurs` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_dilutions = "
CREATE TABLE IF NOT EXISTS `rats_dilutions` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_oreilles = "
CREATE TABLE IF NOT EXISTS `rats_oreilles` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_marquages = "
CREATE TABLE IF NOT EXISTS `rats_marquages` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_parents = "
CREATE TABLE IF NOT EXISTS `rats_parents` (
	`id_rat` int(10) unsigned NOT NULL,
	`num_rat` varchar(15) NOT NULL,
	`num_parent` varchar(15) NOT NULL,
	`sexe` enum('M','F') NOT NULL,
	KEY(`id_rat`),
	KEY(`num_rat`),
	KEY(`num_parent`),
	KEY(`sexe`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$sql_rats_pb_santes = "
CREATE TABLE IF NOT EXISTS `rats_pb_santes` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(100)		NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_poils = "
CREATE TABLE IF NOT EXISTS `rats_poils` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_uniques = "
CREATE TABLE IF NOT EXISTS `rats_uniques` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_yeux = "
CREATE TABLE IF NOT EXISTS `rats_yeux` (
	`id`						TINYINT				UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`nom_fr`					VARCHAR(50)			NOT NULL UNIQUE,
	PRIMARY KEY(`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_portees = "
CREATE TABLE IF NOT EXISTS `rats_portees` (
	`id_portee`					INT					UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
	`id_mere`					INT					UNSIGNED NOT NULL,
	`id_pere`					INT					UNSIGNED NOT NULL,
	`date_accouchement`			BIGINT				UNSIGNED NOT NULL,
	`nombre_petits`				TINYINT				UNSIGNED NOT NULL,
	`commentaires`				TEXT				NULL,
	PRIMARY KEY(`id_portee`),
	KEY(`id_mere`),
	KEY(`id_pere`),
	KEY(`date_accouchement`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_rats_poids = "
CREATE TABLE IF NOT EXISTS `rats_poids` (
	`id_rat`					INT					UNSIGNED NOT NULL,
	`poid`						INT					UNSIGNED NOT NULL,
	`date_pesee`				BIGINT				UNSIGNED NOT NULL,
	KEY(`id_rat`),
	KEY(`date_pesee`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_antispam = "
CREATE TABLE IF NOT EXISTS `antispam` (
	`id`						INT NOT NULL AUTO_INCREMENT,
	`calcul`					VARCHAR(20) NOT NULL,
	`result`					INT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;";

$sql_langues = "
CREATE TABLE IF NOT EXISTS `langues` (
	`id`	TINYINT				UNSIGNED NOT NULL AUTO_INCREMENT,
	`nom`	VARCHAR(20)			NOT NULL UNIQUE,
	`etat`	ENUM('actif','dev'),
	PRIMARY KEY(`id`),
	KEY(`nom`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;";

$sql_mails = "
CREATE TABLE IF NOT EXISTS `mails` (
	`type`		VARCHAR(40)		NOT NULL,
	`subject`	VARCHAR(255)	NOT NULL,
	`text`		TEXT			NOT NULL,
	`html`		TEXT			NOT NULL,
	PRIMARY KEY (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ; ";