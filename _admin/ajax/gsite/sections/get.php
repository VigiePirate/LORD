<?php
// Démarrage du moteur de session
session_start();

usleep(400000);

require_once($_SESSION['root_path']."core/classes/user.class/user.class.php");

$User = unserialize($_SESSION['login']);

if(isset($User->connect) AND $User->connect)
{
	$index = TRUE;

	require_once($_SESSION['root_path'].'core/config.php');
	require_once($_SESSION['root_path'].'core/co_db.php');
	
	if(isset($_POST['id']) AND !empty($_POST['id']))
	{
		$req = $db_v2->prepare("SELECT * FROM `sections` WHERE `id` = :id");
		$req->execute(array("id" => $_POST['id']));
		
		if($req->rowCount())
		{
			$donnees = $req->fetch();
			
			echo json_encode(array(
				"id"			=> $donnees['id'],
				"nom"			=> $donnees['nom'],
				"titre"			=> $donnees['titre'],
				"desc"			=> $donnees['desc'],
				"contenu"		=> $donnees['contenu'],
			));
		}
		else
		{
			echo "empty";
		}
		
		$req->closeCursor();
	}
	else
	{
		echo "missing";
	}
}
else
{
	echo "auth";
}