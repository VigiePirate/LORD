<?php
// Démarrage du moteur de session
session_start();

require_once($_SESSION['root_path']."core/classes/user.class/user.class.php");

$User = unserialize($_SESSION['login']);

if(isset($User->connect) AND $User->connect)
{
	$index = TRUE;

	require_once($_SESSION['root_path'].'core/config.php');
	require_once($_SESSION['root_path'].'core/co_db.php');
	
	$sections = array();
	
	$req = $db_v2->query("SELECT `id`,`nom` FROM `sections` ORDER BY `nom`");
	
	while($donnees = $req->fetch())
	{
		$sections[] = array(
			"id"	=> $donnees['id'],
			"nom"	=> $donnees['nom']
		);
	}
	
	echo json_encode($sections);
}
else
{
	echo "auth";
}

