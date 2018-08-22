<?php
// Déclaration Session
session_start();

// Indication que nous sommes à la racine du site
$index = TRUE;

// Appel des fonctions javascript
include("functions.php");

// Appel du fichier de configuration
include("config.php");

// Connexion BDD a faire ici
include("co_db.php");

// Appel de la classe LORDRAT_API
require_once('classes/lordrat.class/lordrat.api.config.php');
require_once('classes/lordrat.class/lordrat.api.class.php');

// Création de l'objet pour intéraction avec l'API du LORD
$lordrat = new LORDRAT_API(LORDRAT_API_APP,LORDRAT_API_KEY,LORDRAT_API_URL,LORDRAT_AGENT);

// Gestion de la variable de page
if(!empty(filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING)))
{
	$page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING);
	
	if($page == "article")
	{
		if(!empty(filter_input(INPUT_GET,'load',FILTER_SANITIZE_STRING)))
		{
			$load = filter_input(INPUT_GET,'load',FILTER_SANITIZE_STRING);
			
			$req = $bdd->prepare("SELECT * FROM articles WHERE nom = :nom");
			$req->execute(array("nom" => $load));
			
			$datas_page = $req->fetch();
			
			$req->closeCursor();
			
			// Ajout des formulaires et traitement des données diverses
			switch($load)
			{
				case "login":
					include("pages/login.php");
					break;
				case "missing_password":
					include("pages/missing_password.php");
					break;
				case "register":
					include("pages/register.php");
					break;
				default:
					break;
			}
		}
	}
	else if($page == "fiche")
	{
		include('fiche.php');
	}
	else if($page == "recherche")
	{
		include('recherche.php');
	}
	else if($page == "stats")
	{
		include('stats.php');
	}
	else
	{
		$req = $bdd->prepare("SELECT * FROM sections WHERE nom = :nom");
		$req->execute(array("nom" => $page));
		
		$datas_page = $req->fetch();
		
		$req->closeCursor();
	}
}
else
{
	$page = "accueil";
	
	$req = $bdd->query("SELECT * FROM sections_contenus WHERE nom = 'accueil'");
	
	$datas_page = $req->fetch();
	
	$req->closeCursor();
}

// Affichage de la page page.php
include ("page.php");
