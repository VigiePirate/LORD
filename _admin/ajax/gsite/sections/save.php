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
	
	if(isset($_POST['id'],$_POST['titre'],$_POST['desc'],$_POST['contenu']) AND !empty($_POST['id']) AND !empty($_POST['titre']) AND !empty($_POST['contenu']))
	{
		$req = $db_v2->prepare("SELECT `id` FROM `sections` WHERE `id` = :id AND `titre` = :titre AND `desc` = :desc AND `contenu` = :contenu");
		$req->execute(array(
			"id"		=> $_POST['id'],
			"titre"		=> $_POST['titre'],
			"desc"		=> $_POST['desc'],
			"contenu"	=> $_POST['contenu']
		));
		
		if($req->rowCount())
		{
			echo "already";
		}
		else
		{
			$upt = $db_v2->prepare("UPDATE `sections` SET `titre` = :titre, `desc` = :desc, `contenu` = :contenu, `last_edit` = :last_edit WHERE `id` = :id");
			$upt->execute(array(
				"id"		=> $_POST['id'],
				"titre"		=> $_POST['titre'],
				"desc"		=> $_POST['desc'],
				"contenu"	=> $_POST['contenu'],
				"last_edit"	=> $_POST['last_edit']
			));
			
			if($upt->rowCount())
			{
				echo "success";
			}
			else
			{
				echo "failed";
			}
			
			$upt->closeCursor();
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