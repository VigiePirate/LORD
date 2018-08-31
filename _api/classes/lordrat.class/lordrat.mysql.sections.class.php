<?php

// Classe pour la gestion des sections
class LORDRAT_MYSQL_SECTIONS{
	private $_bdd;
	
	public function __construct($bdd)
	{
		if($bdd instanceof PDO)
		{
			$this->_bdd = $bdd;
		}
		else
		{
			throw new Exception("This is not a PDO Object !\n");
		}
	}
	
	// OK
	public function get($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("
			SELECT 
			FROM `sections` s
			LEFT JOIN `sections_contenus` sc ON sc.article = s.article
			WHERE s.id = :id");
			$req->execute(array("id" => $params['id']));
		}
		else if(array_key_exists('nom',$params))
		{
			$req = $this->_bdd->prepare("
			SELECT * FROM `sections` WHERE s.nom = :nom");
			$req->execute(array("nom" => $params['nom']));
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		if(!array_key_exists('error', $datas))
		{
			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array(
					"id"			=> $donnees['id'],
					"nom"			=> $donnees['nom'],
					"titre"			=> $donnees['titre'],
					"desc"			=> $donnees['desc'],
					"contenu"		=> $donnees['contenu'],
				);
			}
			else
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM);
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	// OK
	public function search($content = "full")
	{
		$req = $this->_bdd->prepare("SELECT * FROM `sections` ORDER BY `nom`");
		$req->execute();
		
		switch(TRUE)
		{
			case $req->rowCount() == 0:
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
				break;
			case $req->rowCount() > LORDRAT_MAX_QUERY_RESULTS:
				$datas = array("error" => LORDRAT_ERROR_TO_MANY_RESULTS);
				break;
			default:
				$datas = array();
				while($donnees = $req->fetch())
				{
					switch($content)
					{
						case "full":
							$datas[] = array(
								"id"			=> $donnees['id'],
								"nom"			=> $donnees['nom'],
								"titre"			=> $donnees['titre'],
								"desc"			=> $donnees['desc'],
								"contenu"		=> $donnees['contenu']
							);
							break;
						case "list":
							$datas[] = array(
								"id"			=> $donnees['id'],
								"nom"			=> $donnees['nom'],
								"titre"			=> $donnees['titre'],
								"desc"			=> $donnees['desc']
							);
							break;
						case "menu":
							$datas[] = array(
								"id"			=> $donnees['id'],
								"nom"			=> $donnees['nom'],
								"titre"			=> $donnees['titre']
							);
							break;
						default:
							$datas = array("error" => LORDRAT_ERROR_WRONG_CONTENT_SELECTION);
							break;
					}
				}
				break;
		}
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function save($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `sections` SET `titre` = :titre, `desc` = :desc, `contenu` = :contenu, `last_edit` = :last_edit WHERE `id` = :id");
		$upt->execute($params);

		if($upt->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_UPDATE_NO_CHANGE);
		}

		$upt->closeCursor();
		
		return $datas;
	}
}

