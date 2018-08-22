<?php

  /////////////////////////////////////////////////////
 //	Variables contenant les tables SQL				//
/////////////////////////////////////////////////////

require_once("variables_tables.php");

  /////////////////////////////////////////////////////
 //	Variables contenant le contenu des tables SQL	//
/////////////////////////////////////////////////////

require_once("variables_rows.php");


  /////////////////////////////////////////////////////
 //	Variables de configuration des BDD				//
/////////////////////////////////////////////////////

$db_v1_infos = array(
	"db_host"		=> "localhost",
	"db_name"		=> "lordrat_v1",
	"db_user"		=> "lordrat",
	"db_password"	=> "BBxyzISAJfG4hpMf"
);

$db_v2_infos = array(
	"db_host"		=> "localhost",
	"db_name"		=> "lordrat_v2",
	"db_user"		=> "lordrat",
	"db_password"	=> "BBxyzISAJfG4hpMf"
);

  /////////////////////////////////////////////////////
 //	Définitions des variables de travail			//
/////////////////////////////////////////////////////

// $RUN_METHOD permet de choisir le mode d'execution du script de convertion
// test : Pas d'insertion
// debug : Insertion mais pas de suppression
// run : Insertion et suppression
$RUN_METHOD = "debug";

// Tableau contenant les evenements
$events = array();

// Compteur d'erreur
$nbr_erreurs = 0;
