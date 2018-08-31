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
	
	if(isset($_POST['offset']) AND !empty($_POST['offset']) AND is_numeric($_POST['offset']))
	{
		$offset = $_POST['offset'];
	}
	else
	{
		$offset = 0;
	}
	
	if(isset($_POST['ordre']) AND !empty($_POST['ordre']))
	{
		
	}
	else
	{
		$req = $db_v2->prepare("SELECT * FROM `users` ORDER BY `id_membre` DESC LIMIT :offset,25");
		$req->bindValue(":offset", $offset, PDO::PARAM_INT);
		$req->execute();
		
		if($req->rowCount())
		{
			
		}
		else
		{
			
		}
		
		$req->closeCursor();
	}
}
else
{
	echo "auth";
}