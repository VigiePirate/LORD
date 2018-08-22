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
	
	if(isset($_POST['id'],$_POST['titre'],$_POST['section'],$_POST['desc'],$_POST['contenu'],$_POST['system'],$_POST['special']) AND !empty($_POST['titre']) AND !empty($_POST['contenu']))
	{
		// Définition date de publication article
		if(empty($_POST['date']))
		{
			$date_publication = time();
		}
		else
		{
			$date_publication = strtotime(str_replace('/', '-',trim($_POST['date'])));
		}
		
		$upt = $db_v2->prepare("UPDATE `articles` SET `section` = :section, `system` = :system, `publie` = :publie, `titre` = :titre, `desc` = :desc, `contenu` = :contenu, `special` = :special, `date_publication` = :date_publication,`last_edit` = :last_edit WHERE `id` = :id");
		$upt->execute(array(
			"id"				=> $_POST['id'],
			"section"			=> $_POST['section'],
			"system"			=> $_POST['system'],
			"publie"			=> $_POST['publie'],
			"titre"				=> trim($_POST['titre']),
			"desc"				=> trim($_POST['desc']),
			"contenu"			=> trim($_POST['contenu']),
			"special"			=> trim($_POST['special']),
			"date_publication"	=> $date_publication,
			"last_edit"			=> time(),
		));

		if($upt->rowCount())
		{
			echo "success";
		}
		else
		{
			echo "already";
		}

		$upt->closeCursor();
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