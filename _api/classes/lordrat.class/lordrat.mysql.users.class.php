<?php

// Classe pour la gestion des utilisateurs
class LORDRAT_MYSQL_USERS{
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
	
	public function add($section,$params)
	{
		switch($section)
		{
			case "adresse":
				$datas = $this->addAdresse($params);
				break;
			case "base":
				$datas = $this->addBase($params);
				break;
			case "nom":
				$datas = $this->addNom($params);
				break;
			case "site":
				$datas = $this->addSite($params);
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function addAdresse($params)
	{
		// Vérification si adresse est pas deja définie
		$adresse = $this->getAdresse(array('id_membre' => $params['id_membre']));
		
		if(array_key_exists('error',$adresse))
		{
			$add = $this->_bdd->prepare("INSERT INTO `users_adresses` (`id_membre`,`adresse`,`cp`,`ville`,`pays`,`geoname`,`lat`,`lng`) VALUES(:id_membre,:adresse,:cp,:ville,:pays,:geoname,:lat,:lng)");
			$add->execute($params);

			if($add->rowCount())
			{
				$datas = "success";
			}
			else
			{
				$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
			}
		}
		else
		{
			$datas = $this->saveAdresse($params);
		}
		
		return $datas;
	}
	
	private function addBase($params)
	{
		if(array_key_exists('old_id',$params))
		{
			// Ajout d'un utilisateur depuis le LORD v1
			$add = $this->_bdd->prepare("
			INSERT INTO `users` (`old_id`,`email`,`mdp`,`pseudo`,`level`,`date_naissance`,`date_inscription`,`date_visite`,`date_maj`,`etat`)
			VALUES (:old_id,:email,:mdp,:pseudo,:level,:date_naissance,:date_inscription,:date_visite,:date_maj,:etat)");
			$add->execute(array(
				"old_id"			=> $params['old_id'],
				"email"				=> $params['email'],
				"mdp"				=> $params['mdp'],
				"pseudo"			=> $params['pseudo'],
				"level"				=> $params['level'],
				"date_naissance"	=> $params['date_naissance'],
				"date_inscription"	=> $params['date_inscription'],
				"date_visite"		=> 0,
				"date_maj"			=> $params['date_maj'],
				"etat"				=> 0
			));
		}
		else
		{
			// Ajout d'un utilisateur tout neuf
			$add = $this->_bdd->prepare("
			INSERT INTO `users` (`old_id`,`email`,`mdp`,`pseudo`,`level`,`date_naissance`,`date_inscription`,`date_visite`,`date_maj`,`etat`)
			VALUES (:old_id,:email,:mdp,:pseudo,:level,:date_naissance,:date_inscription,:date_visite,:date_maj,:etat)");
			$add->execute(array(
				"old_id"			=> 0,
				"email"				=> $params['email'],
				"mdp"				=> $params['mdp'],
				"pseudo"			=> $params['pseudo'],
				"level"				=> $params['level'],
				"date_naissance"	=> $params['date_naissance'],
				"date_inscription"	=> time(),
				"date_visite"		=> 0,
				"date_maj"			=> time(),
				"etat"				=> 0
			));
		}
		
		if($add->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
		}
		
		$add->closeCursor();
		
		return $datas;
	}
	
	private function addNom($params)
	{
		// Vérification si un nom n'est pas deja associé a cet utilisateur
		
		$add = $this->_bdd->prepare("INSERT INTO `users_noms` (`id_membre`,`civilite`,`prenom`,`nom`) VALUES(:id_membre,:civilite,:prenom,:nom)");
		$add->execute($params);
		
		if($add->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function addSite($params)
	{
		$add = $this->_bdd->prepare("INSERT INTO `users_sites` (`id_membre`,`nom`,`url`) VALUES(:id_membre,:nom,:url)");
		$add->execute($params);
		
		if($add->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	public function delete($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		$del->closeCursor();
		
		return $datas;
	}
	
	public function get($section,$params)
	{
		switch($section)
		{
			case "adresse":
				$datas = $this->getAdresse($params);
				break;
			case "base":
				$datas = $this->getBase($params);
				break;
			case "fiche":
				$datas = $this->getFiche($params);
				break;
			case "site":
				$datas = $this->getSite($params);
				break;
			case "full":
				$datas = $this->getFull($params);
				break;
			default:	// Full
				$datas = $this->getFull($params);
				break;
		}
		
		return $datas;
	}
	
	private function getAdresse($params)
	{
		$req = $this->_bdd->prepare("SELECT * FROM `users_adresses` WHERE `id_membre` = :id_membre");
		$req->execute($params);
		
		if($req->rowCount())
		{
			$donnees = $req->fetch();
			
			$datas = array();
			
			$datas[] = array(
				"id_membre"	=> $donnees['id_membre'],
				"adresse"	=> $donnees['adresse'],
				"cp"		=> $donnees['cp'],
				"ville"		=> $donnees['ville'],
				"pays"		=> $donnees['pays'],
				"geoname"	=> $donnees['geoname'],
				"lat"		=> $donnees['lat'],
				"lng"		=> $donnees['lng']
			);
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_NO_RESULTS);
		}
		
		return $datas;
	}
	
	private function getBase($params)
	{
		$req = $this->_bdd->prepare("SELECT * FROM `users` u WHERE u.id_membre = :id OR u.old_id = :old_id OR u.email LIKE :email OR u.pseudo LIKE :pseudo");
		$req->execute($params);

		if($req->rowCount())
		{
			$datas = array();

			while($donnees = $req->fetch())
			{
				$datas[] = array(
					"id_membre"			=> $donnees['id_membre'],
					"old_id"			=> $donnees['old_id'],
					"email"				=> $donnees['email'],
					"pseudo"			=> $donnees['pseudo'],
					"level"				=> $donnees['level'],
					"date_inscription"	=> $donnees['date_inscription'],
					"date_visite"		=> $donnees['date_visite'],
					"date_maj"			=> $donnees['date_maj'],
					"etat"				=> $donnees['etat']
				);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
		}

		return $datas;
	}
	
	private function getFiche($params)
	{
		$req = $this->_bdd->prepare("
		SELECT u.id_membre id_membre, u.pseudo pseudo, u.level role, us.nom nom_site, us.url url_site, r.id_raterie id_raterie, r.affixe affixe_raterie, r.nom nom_raterie
		FROM `users` u
		LEFT JOIN `users_sites` us ON us.id_membre = u.id_membre
		LEFT JOIN `rateries` r ON r.id_membre = u.id_membre
		WHERE u.id_membre = :id");
		$req->execute($params);

		if($req->rowCount())
		{
			$datas = array();

			while($donnees = $req->fetch())
			{
				$datas[] = array(
					"id_membre"			=> $donnees['id_membre'],
					"pseudo"			=> $donnees['pseudo'],
					"role"				=> $donnees['role'],
					"site"				=> array(
						"nom"			=> $donnees['nom_site'],
						"url"			=> $donnees['url_site']
					),
					"raterie"			=> array(
						"id"			=> $donnees['id_raterie'],
						"affixe"		=> $donnees['affixe_raterie'],
						"nom"			=> $donnees['nom_raterie']
					)
				);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
		}

		return $datas;
	}
	
	private function getFull($params)
	{
		$req = $this->_bdd->prepare("SELECT * FROM `users` u WHERE u.id_membre = :id OR u.old_id = :old_id OR u.email LIKE :email OR u.pseudo LIKE :pseudo");
		$req->execute($params);

		if($req->rowCount())
		{
			$datas = array();

			while($donnees = $req->fetch())
			{
				$datas[] = array(
					"id_membre"			=> $donnees['id_membre'],
					"old_id"			=> $donnees['old_id'],
					"email"				=> $donnees['email'],
					"pseudo"			=> $donnees['pseudo'],
					"level"				=> $donnees['level'],
					"date_inscription"		=> $donnees['date_inscription'],
					"date_visite"			=> $donnees['date_visite'],
					"date_maj"			=> $donnees['date_maj'],
					"etat"				=> $donnees['etat']
				);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
		}

		return $datas;
	}
	
	private function getSite($params)
	{
		$req = $this->_bdd->prepare("
		SELECT * FROM `users_sites` us WHERE us.id_membre = :id");
		$req->execute($params);

		if($req->rowCount())
		{
			$datas = array();

			while($donnees = $req->fetch())
			{
				$datas[] = array(
					"id_membre"		=> $donnees['id_membre'],
					"nom"			=> $donnees['nom'],
					"url"			=> $donnees['url']
				);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
		}

		return $datas;
	}
	
	public function search($params)
	{
		$req = $this->_bdd->query("
        SELECT *
		FROM `users`
		ORDER BY `pseudo`");
		//$req->execute($params);
		
		switch(TRUE)
		{
			case $req->rowCount() == 0:
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
				break;
			default:
				$datas = array();
				while($donnees = $req->fetch())
				{
					$datas[] = array(
						"id"		=> $donnees['id_membre'],
						"pseudo"	=> htmlspecialchars($donnees['pseudo'],ENT_QUOTES)
					);
				}
				break;
		}
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function save($section,$params)
	{
		switch($section)
		{
			case "adresse":
				$datas = $this->saveAdresse($params);
				break;
			case "base":
				$datas = $this->saveBase($params);
				break;
			case "nom":
				$datas = $this->saveNom($params);
				break;
			case "site":
				$datas = $this->saveSite($params);
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function saveAdresse($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `users_adresses` SET `adresse` = :adresse, `cp` = :cp, `ville` = :ville, `pays` = :pays, `geoname` = :geoname, `lat` = :lat, `lng` = :lng WHERE `id_membre` = :id_membre");
		$upt->execute($params);
		
		if($upt->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_UPDATE_NO_CHANGE);
		}
		
		return $datas;
	}
	
	private function saveBase($params)
	{
		
	}
	
	private function saveNom($params)
	{
		
	}
	
	private function saveSite($params)
	{
		
	}
}

