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
	
	if(isset($_POST['id']) AND !empty($_POST['id']))
	{
		$del = $db_v2->prepare("DELETE FROM `articles` WHERE `id` = :id");
		$del->execute(array("id" => $_POST['id']));
		
		if($del->rowCount())
		{
			echo "success";
		}
		else
		{
			echo "failed";
		}
		
		$del->closeCursor();
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