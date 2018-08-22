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
	
	if(isset($_POST['titre'],$_POST['section'],$_POST['desc'],$_POST['contenu'],$_POST['system'],$_POST['nom'],$_POST['special']) AND !empty($_POST['titre']) AND !empty($_POST['contenu']))
	{
		// Définition nom article
		if(isset($_POST['chemin']) AND !empty($_POST['chemin']))
		{
			$nom = substr(strtolower(preg_replace('/\s+/','_',trim($_POST['chemin']))),0,100);
		}
		else
		{
			if(empty($_POST['nom']))
			{
				$nom = substr(strtolower(preg_replace('/\s+/','_',trim($_POST['titre']))),0,100);
			}
			else
			{
				$nom = substr(strtolower(preg_replace('/\s+/','_',trim($_POST['nom']))),0,100);
			}
		}
		
		// Définition date de publication article
		if(empty($_POST['date']))
		{
			$date_publication = time();
		}
		else
		{
			$date_publication = strtotime(str_replace('/', '-',trim($_POST['date'])));
		}
		
		$req = $db_v2->prepare("SELECT * FROM `articles` WHERE `nom` = :nom AND `section` = :section");
		$req->execute(array(
			"nom"		=> $nom,
			"section"	=> $_POST['section']
		));
		
		if($req->rowCount())
		{
			echo "already";
		}
		else
		{
			$ins = $db_v2->prepare("INSERT INTO `articles` VALUES ('',:section,:ordre,:system,:publie,:nom,:titre,:desc,:contenu,:special,:auteur,:date_ajout,:date_publication,:date_ajout,0)");
			$ins->execute(array(
				"section"			=> $_POST['section'],
				"ordre"				=> getNextArticleOrder($_POST['section']),
				"system"			=> $_POST['system'],
				"publie"			=> $_POST['publie'],
				"nom"				=> $nom,
				"titre"				=> trim($_POST['titre']),
				"desc"				=> trim($_POST['desc']),
				"contenu"			=> trim($_POST['contenu']),
				"special"			=> trim($_POST['special']),
				"auteur"			=> $User->id,
				"date_ajout"		=> time(),
				"date_publication"	=> $date_publication
			));
			
			if($ins->rowCount())
			{
				echo "success";
			}
			else
			{
				echo "failed";
			}
			
			$ins->closeCursor();
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

function getNextArticleOrder($section)
{
	global $db_v2;

	$req = $db_v2->prepare("SELECT `ordre` FROM `article` WHERE `section` = :section ORDER BY `ordre` DESC LIMIT 1");
	$req->execute(array("section" => $section));

	if($req->rowCount())
	{
		$donnees = $req->fetch();
		$ordre = $donnees['ordre'] + 1;
	}
	else
	{
		$ordre = 1;
	}

	$req->closeCursor();

	return $ordre;
}

