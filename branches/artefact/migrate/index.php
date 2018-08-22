<?php

//======================================================//
//  Création BDD LORD v2 et migration datas v1 vers v2	//
//======================================================//
//  Nom du fichier : 	index.php						//
//======================================================//

  /////////////////////////////////////////////////////////
 //	Démarrage du compteur de temps d'execution			//
/////////////////////////////////////////////////////////

$timestart=microtime(true);

  /////////////////////////////////////////////////////////
 //	Définition des variables de configuration			//
/////////////////////////////////////////////////////////

require_once("variables.php");

  /////////////////////////////////////////////////////////
 //	Ouverture de la connexion à la base de données		//
/////////////////////////////////////////////////////////

try
{
	$db_v1 = new PDO('mysql:host='.$db_v1_infos['db_host'].';dbname='.$db_v1_infos['db_name'].';charset=utf8', ''.$db_v1_infos['db_user'].'', ''.$db_v1_infos['db_password'].'');
	//$db_v2 = new PDO('mysql:host='.$db_v2_infos['db_host'].';dbname='.$db_v2_infos['db_name'].';charset=utf8', ''.$db_v2_infos['db_user'].'', ''.$db_v2_infos['db_password'].'');
	
	$db_v1->query("SET NAMES 'utf8'");
	//$db_v2->query("SET NAMES 'utf8'");
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}

  /////////////////////////////////////////////////////
 //	Appel de la classe GEONAMES_API					//
/////////////////////////////////////////////////////

require_once('class/geonames.class/geonames.api.config.php');
require_once('class/geonames.class/geonames.api.class.php');

  /////////////////////////////////////////////////////
 //	Création de l'objet $geoname					//
/////////////////////////////////////////////////////

$geoname = new GEONAMES_API(GEONAMES_API_APP,GEONAMES_API_KEY,GEONAMES_API_URL,GEONAMES_API_AGENT);

  /////////////////////////////////////////////////////
 //	Appel de la classe LORDRAT_API					//
/////////////////////////////////////////////////////

require_once('class/lordrat.class/lordrat.api.config.php');
require_once('class/lordrat.class/lordrat.api.class.php');

  /////////////////////////////////////////////////////
 //	Création de l'objet $lordrat					//
/////////////////////////////////////////////////////

$api_v2 = new LORDRAT_API(LORDRAT_API_APP,LORDRAT_API_KEY,LORDRAT_API_URL,LORDRAT_API_AGENT);

  /////////////////////////////////////////////////////
 //	Déclaration de la classe LORDRAT_SYNC			//
/////////////////////////////////////////////////////

require_once('class/lordrat.class/lordrat.sync.class.php');

  /////////////////////////////////////////////////////
 //	Création de l'objet $lordrat_sync				//
/////////////////////////////////////////////////////

try{
	$lordrat_sync = new LORDRAT_SYNC($db_v1,$api_v2,$geoname,TRUE);
} catch (Exception $ex) {
	die('Erreur : ' . $ex->getMessage());
}

  /////////////////////////////////////////////////////
 // Appel du fichier contenant les fonctions		//
/////////////////////////////////////////////////////

require_once('fonctions.php');

  /////////////////////////////////////////////////////
 // Réalisation de la syncrhonisation des tables	//
/////////////////////////////////////////////////////

echo "Synchro de la BDD LORD v1 vers v2\n\n";

echo "\n### Synchro des utilisateurs ###\n";
//$lordrat_sync->syncMembres();				// Insertion OK, Synchro à faire

echo "\n### Synchro des rateries ###\n";
//$lordrat_sync->syncRateries();				// Insertion OK, Synchro à faire

echo "\n### Synchro des criteres des rats ###\n";
//$lordrat_sync->syncCriteres();			// Insertion OK, pas de synchro nécéssaire

echo "\n### Synchro des rats ###\n";
$lordrat_sync->syncRats();

echo "\n### Synchro des portées ###\n";
//$lordrat_sync->syncPortees();

echo $lordrat_sync->printEvents();

$timeend=microtime(true);
$time = number_format(($timeend-$timestart), 3);
echo "Convertion réalisée en $time sec.\n\n";


