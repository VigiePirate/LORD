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
		$req = $db_v2->prepare("
		SELECT a.id id, a.section section_id, s.nom section_nom, a.ordre ordre, a.system `system`, a.publie publie, a.nom nom, a.titre titre, a.desc `desc`, a.contenu contenu, a.special special, a.auteur auteur_id, u.pseudo auteur_nom, a.date_ajout date_ajout, a.date_publication date_publication, a.last_edit last_edit, a.nbr_vues nbr_vues
		FROM `articles` a
		LEFT JOIN `sections` s ON s.id = a.section
		LEFT JOIN `users` u ON u.id_membre = a.auteur
		WHERE a.id = :id");
		$req->execute(array("id" => $_POST['id']));

		if($req->rowCount())
		{
			$donnees = $req->fetch();
			
			echo json_encode(array(
				"id"		=> $donnees['id'],
				"section"	=> array(
					"id"	=> $donnees['section_id'],
					"nom"	=> $donnees['section_nom']
				),
				"ordre"		=> $donnees['ordre'],
				"system"	=> $donnees['system'],
				"publie"	=> $donnees['publie'],
				"nom"		=> $donnees['nom'],
				"titre"		=> $donnees['titre'],
				"desc"		=> $donnees['desc'],
				"contenu"	=> $donnees['contenu'],
				"special"	=> $donnees['special'],
				"auteur"	=> array(
					"id"	=> $donnees['auteur_id'],
					"nom"	=> $donnees['auteur_nom']
				),
				"date_ajout"		=> date('d/m/Y H:i',$donnees['date_ajout']),
				"date_publication"	=> date('d/m/Y H:i',$donnees['date_publication']),
				"last_edit"			=> date('d/m/Y H:i',$donnees['last_edit']),
				"nbr_vues"			=> $donnees['nbr_vues']
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