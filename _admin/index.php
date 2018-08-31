<?php
	session_start();
	
	// Permet la sécurisation de l'appel de tous les fichiers php du site
	$index = TRUE;
	
	// Réccupére le chemin absolu de l'index du site pour les appels des fichiers 
	// sans erreur possible
	$root_path = realpath("./")."/";
	error_log("root_path : ".$root_path);
	// Stockage du chemin dans les variables de session pour les requestes AJAX
	$_SESSION['root_path'] = $root_path;
	
	// Par défaut, l'accès au site n'est pas autorisé, sera changé par le script 
	// de login si l'authentification est correcte ou non necessaire
	$granted = FALSE;
	
	// Chargement de la configuration du site
	require_once($root_path."core/config.php");
	
	// Connexion à la base de données
	require_once($root_path."core/co_db.php");
	
	// Chargement des fonctions
	require_once($root_path."core/fonctions/include.php");
	
	// Chargement des classes
	require_once($root_path."core/classes/include.php");
	
	// Création de l'objet pour intéraction avec l'API du LORD
	$lordrat = new LORDRAT_API(LORDRAT_API_APP,LORDRAT_API_KEY,LORDRAT_API_URL,LORDRAT_AGENT);
	
	// Chargement des fichiers de config des plugins appelés
	foreach($plugins as $plugin_name => $plugin_config)
	{
		if(file_exists($root_path."plugins/".$plugin_name."/config.php"))
		{
			require_once($root_path."plugins/".$plugin_name."/config.php");
		}
		else
		{
			error_log("Plugin ".$plugin_name." loaded without config file");
		}
	}
	
	// Chargement des fonctions php des plugins appelé si existent
	foreach($plugins as $plugin_name => $plugin_config)
	{
		if($plugin_config['php'])
		{
			if(file_exists($root_path."plugins/".$plugin_name."/fonctions.php"))
			{
				require_once($root_path."plugins/".$plugin_name."/fonctions.php");
			}
			else
			{
				error_log("Plugin ".$plugin_name." tried to load unexistent php file");
			}
		}
	}
	
	if($auth_required)
	{
		// Réccupération de l'adresse IP du visiteur
		if(isset($_SERVER['HTTP_X_REMOTE_IP']))
		{
			$_SESSION['ip'] = $_SERVER['HTTP_X_REMOTE_IP'];
		}
		else
		{
			$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		}
		
		// On vérifie si l'objet de données utilisateur est stocké dans la variable $_SESSION
		if(isset($_SESSION['login']))
		{
			/*echo "Value Session login : ";
			print_r($_SESSION['login']);
			echo "\n\n";*/
			$User = unserialize($_SESSION['login']);
		}
		else
		{
			//echo "Value Session login : Undefined\n\n";
			$User = new User();
		}
		
		/*echo "Value User : ";
		print_r($User);
		echo "\n\n";*/
		
		// On créé l'objet de gestion de session pour cette execution du script
		$Login = new Login($db_v2,$cookie_lifespan,$User);
		
		// Si non connecté on vérifie la présence d'un cookie
		if(!$User->connect)
		{
			$Login->checkCookie();
		}
		
		/*echo "Value Login User : ";
		print_r($Login->User);
		echo "\n\n";*/
		
		// On vérifie si l'utilisateur est connecté
		if($Login->User->connect)
		{
			// Demande a être déconnecté
			if(isset($_GET['logout']))
			{
				require_once($root_path."core/logout.php");
			}
			else
			{
				$granted = TRUE;
			}
		}
		else
		{
			require_once($root_path."core/login.php");
		}
	}
	else
	{
		$granted = TRUE;
	}
	
	if($granted)
	{
		if($Login->User->memco)
		{
			$Login->updateCookies();
		}
		
		// Réccupération de la demande de page
		if(!empty(filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING)))
		{
			$page = filter_input(INPUT_GET,'page',FILTER_SANITIZE_STRING);
			
			// Réccupération de la demande de section
			if(!empty(filter_input(INPUT_GET,'section',FILTER_SANITIZE_STRING)))
			{
				$section = filter_input(INPUT_GET,'section',FILTER_SANITIZE_STRING);
			}
			else
			{
				$section = NULL;
			}
		}
		else
		{
			$page = "dashboard";
		}
		
		// Chargement de l'entête HTML et des menus
		require_once($root_path."core/header.php");

		// Chargement Corps de la page
		require_once($root_path."core/center.php");

		// Chargement Pied de page
		require_once($root_path."core/footer.php");
	}
	
	// stockage de l'object utilisateur dans la variable $_SESSION['login']
	$_SESSION['login'] = serialize($Login->User);
	
	//print_r($_SESSION['login']);
