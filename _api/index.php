<?php

header('Content-Type: application/json; charset=utf-8');

$index = TRUE;

// Démarrage compteur execution
$timestart=microtime(true);

// Inclusion des fonctions
require_once('./fonctions/globales.php');

// Inclusion des infos de configuration
require_once('./config.php');

// Définition des messages d'erreurs
define('API_ERROR_APP_NOT_ACTIVE_OR_INEXISTENT',	"App Inactive or Inexistent");
define('API_ERROR_AUTH',							"Authentification Error");
define('API_ERROR_BANNED_IP',						"Your Ip adresse have been banned.");
define('API_ERROR_IP_NOT_IN_LIST',					"Your Ip adress is not allowed to use this Application.");
define('API_ERROR_NO_APP_SELECTED',					"You must select a valid Application. Please contact an Administrator.");
define('API_ERROR_NO_KEY_PROVIDED',					"You must provide a valid API Key for this Application.");
define('API_ERROR_UNKNOWN',							"This is an Unknown Error. Please contact an Administrator.");
define('API_ERROR_WRONG_METHOD',					"This method is not know by the server.");

// Inclusion de la classe de gestion des l'authentification API

require_once('./classes/api.class/api.mysql.config.php');
require_once('./classes/api.class/api.mysql.class.php');

// Création de l'objet API_MYSQL

$api = new API_MYSQL(API_DB_HOST,API_DB_DATABASE,API_DB_USER,API_DB_PASSWORD);

// Gestion de l'authentification

$auth = array(
	"app"		=> NULL,
	"key"		=> NULL,
	"client_ip"	=> filter_input(INPUT_SERVER,'REMOTE_ADDR',FILTER_VALIDATE_IP),
	"valid"		=> FALSE
);

$flag = TRUE;

// Réccupération de l'uid de l'application
if(!empty(filter_input(INPUT_GET,'app',FILTER_SANITIZE_STRING)))
{
	$auth['app']	= filter_input(INPUT_GET,'app',FILTER_SANITIZE_STRING);
}
else if(!empty(filter_input(INPUT_POST,'app',FILTER_SANITIZE_STRING)))
{
	$auth['app']	= filter_input(INPUT_POST,'app',FILTER_SANITIZE_STRING);
}
else
{
	$flag = FALSE;
	$response = array("error" => API_ERROR_NO_APP_SELECTED);
}

// Réccupération clé uniquement si application fournie
if($flag)
{
	if(!empty(filter_input(INPUT_GET,'key',FILTER_SANITIZE_STRING)))
	{
		$auth['key']	= filter_input(INPUT_GET,'key',FILTER_SANITIZE_STRING);
	}
	else if(!empty(filter_input(INPUT_POST,'key',FILTER_SANITIZE_STRING)))
	{	
		$auth['key']	= filter_input(INPUT_POST,'key',FILTER_SANITIZE_STRING);
	}
	else
	{
		$flag = FALSE;
		$response = array("error" => API_ERROR_NO_KEY_PROVIDED);
	}
}

// Réccupération version API appelée pour l'application
if($flag)
{
	if(!empty(filter_input(INPUT_GET,'version',FILTER_SANITIZE_STRING)))
	{
		$auth['version']	= filter_input(INPUT_GET,'version',FILTER_SANITIZE_STRING);
	}
	else if(!empty(filter_input(INPUT_POST,'version',FILTER_SANITIZE_STRING)))
	{	
		$auth['version']	= filter_input(INPUT_POST,'version',FILTER_SANITIZE_STRING);
	}
	else
	{
		$auth['version']	= "default";
	}
}

if($flag)
{
	$auth["valid"]	= $api->checkAuth($auth['app'],$auth['key'],$auth['client_ip']);

	switch($auth['valid'])
	{
		case "success":
			$query = array(
				"module"	=> filter_input(INPUT_GET,'module',FILTER_SANITIZE_STRING),
				"method"	=> filter_input(INPUT_GET,'method',FILTER_SANITIZE_STRING),
				"section"	=> filter_input(INPUT_GET,'section',FILTER_SANITIZE_STRING),
				"params"	=> NULL
			);
			
			switch($auth['app'])
			{
				case "xezcv5gtT7shI5PGytyu":	// Geonames
					switch($auth['version'])
					{
						default:	// Version par défaut
							// Inclusion des fichiers de classes liés à cette application
							require_once('./classes/geonames.class/geonames.mysql.config.php');
							require_once('./classes/geonames.class/geonames.mysql.class.php');
							// Déclaration de l'objet
							$geonames = new GEONAMES_MYSQL(GEONAMES_DB_HOST,GEONAMES_DB_DATABASE,GEONAMES_DB_USER,GEONAMES_DB_PASSWORD);
							// Traitement des données dans un fichier dédié
							require_once('./applications/geonames.php');
							// Affichage des résultats
							$response = array(
								"query"	=> $query,
								"datas"	=> $datas
							);
							break;
					}
					break;
				case "3g4lDG8GrFicXlEHnpi5":	// L'archiviste - Collection
					switch($auth['version'])
					{
						default:
							// Inclusion des fichiers de classes liés à cette application
							require_once('./classes/larchiviste.class/larchiviste.collection.mysql.config.php');
							require_once('./classes/larchiviste.class/larchiviste.collection.mysql.class.php');
							// Déclaration de l'objet
							$geonames = new GEONAMES_MYSQL(LARCHIVISTE_COLLECTION_DB_HOST,LARCHIVISTE_COLLECTION_DB_DATABASE,LARCHIVISTE_COLLECTION_DB_USER,LARCHIVISTE_COLLECTION_DB_PASSWORD);
							// Traitement des données dans un fichier dédié
							require_once('./applications/larchiviste.collection.php');
							// Affichage des résultats
							$response = array(
								"query"	=> $query,
								"data"	=> "Soon"
							);
							break;
					}
					break;
				case "NhNWKfsvPJG09wlhT62o":	// Le LORD
					switch($auth['version'])
					{
						default:
							// Inclusion des fichiers de classes liés à cette application
							require_once('./classes/lordrat.class/lordrat.mysql.config.php');
							require_once('./classes/lordrat.class/lordrat.mysql.class.php');
							// Déclaration de l'objet
							$lord = new LORDRAT_MYSQL(LORDRAT_DB_HOST,LORDRAT_DB_DATABASE,LORDRAT_DB_USER,LORDRAT_DB_PASSWORD);
							// Traitement des données dans un fichier dédié
							require_once('./applications/lordrat.php');
							// Affichage des résultats
							$response = array(
								"query"	=> $query,
								"datas"	=> $datas
							);
							break;
					}
					break;
				default:
					$response = array("error" => API_ERROR_APP_NOT_ACTIVE_OR_INEXISTENT);
					break;
			}
			break;
		case "public":
			$query = array(
				"module"	=> filter_input(INPUT_GET,'module',FILTER_SANITIZE_STRING),
				"method"	=> filter_input(INPUT_GET,'method',FILTER_SANITIZE_STRING),
				"section"	=> filter_input(INPUT_GET,'section',FILTER_SANITIZE_STRING),
				"params"	=> NULL
			);
			
			switch($auth['app'])
			{
				case "NhNWKfsvPJG09wlhT62o":	// Le LORD
					// Inclusion des fichiers de classes liés à cette application
					require_once('./classes/lordrat.class/lordrat.mysql.config.php');
					require_once('./classes/lordrat.class/lordrat.mysql.class.php');
					// Déclaration de l'objet
					$lord = new LORDRAT_MYSQL(LORDRAT_DB_HOST,LORDRAT_DB_DATABASE,LORDRAT_DB_USER,LORDRAT_DB_PASSWORD);
					// Traitement des données dans un fichier dédié
					require_once('./applications/lordrat.public.php');
					// Affichage des résultats
					$response = array(
						"query"	=> $query,
						"datas"	=> $datas
					);
					break;
				default:
					$response = array("error" => API_ERROR_APP_NOT_ACTIVE_OR_INEXISTENT);
					break;
			}
			break;
		default:
			$response = $auth['valid'];
			break;
	}
}

$timeend=microtime(true);
$time = number_format(($timeend-$timestart), 3);
//echo "<p>Convertion réalisée en $time sec.</p>";

echo json_encode(array(
	"auth"				=> $auth,
	"response"			=> $response,
	"execution_time"	=> $time." secondes",
	"documentation"		=> $config['documentation']
));



