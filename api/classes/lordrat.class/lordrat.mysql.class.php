<?php

class LORDRAT_MYSQL {
	private $_bdd;
	
	public function __construct($db_host,$db_database,$db_user,$db_password)
	{
		try
		{
			$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			
			$this->_bdd = new PDO("mysql:host=".$db_host.";dbname=".$db_database, $db_user, $db_password, $pdo_options);
			
			$this->_bdd->query("SET NAMES UTF8");
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
	}
	
	//////////////////////////////////
	//	Gestion des medias			//
	//////////////////////////////////
	
	public function addMedia($params)
	{
		try
		{
			$medias = new LORDRAT_MYSQL_MEDIAS($this->_bdd);
			
			$datas = $medias->add($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function deleteMedia($params)
	{
		try
		{
			$medias = new LORDRAT_MYSQL_MEDIAS($this->_bdd);
			
			$datas = $medias->delete($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getMedia($params)
	{
		try
		{
			$medias = new LORDRAT_MYSQL_MEDIAS($this->_bdd);
			
			$datas = $medias->get($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveMedia($params)
	{
		try
		{
			$medias = new LORDRAT_MYSQL_MEDIAS($this->_bdd);
			
			$datas = $medias->save($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchMedias($params)
	{
		try
		{
			$medias = new LORDRAT_MYSQL_MEDIAS($this->_bdd);
			
			$datas = $medias->search($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//	Gestion des sections		//
	//////////////////////////////////
	
	public function getSection($params)
	{
		try
		{
			$sections = new LORDRAT_MYSQL_SECTIONS($this->_bdd);
			
			$datas = $sections->getSection($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveSection($params)
	{
		try
		{
			$sections = new LORDRAT_MYSQL_SECTIONS($this->_bdd);
			
			$datas = $sections->saveSection($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchSections($params)
	{
		try
		{
			$sections = new LORDRAT_MYSQL_SECTIONS($this->_bdd);
			
			$datas = $sections->listSections($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//	Gestion des articles		//
	//////////////////////////////////
	
	public function addArticle($params)
	{
		try
		{
			$articles = new LORDRAT_MYSQL_ARTICLES($this->_bdd);
			
			$datas = $articles->add($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function delArticle($params)
	{
		try
		{
			$articles = new LORDRAT_MYSQL_ARTICLES($this->_bdd);
			
			$datas = $articles->del($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getArticle($params)
	{
		try
		{
			$articles = new LORDRAT_MYSQL_ARTICLES($this->_bdd);
			
			$datas = $articles->get($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveArticle($params)
	{
		try
		{
			$articles = new LORDRAT_MYSQL_ARTICLES($this->_bdd);
			
			$datas = $articles->save($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchArticles($params)
	{
		try
		{
			$articles = new LORDRAT_MYSQL_ARTICLES($this->_bdd);
			
			$datas = $articles->search($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//		Statistiques			//
	//////////////////////////////////
	
	public function getStats($section,$params = NULL)
	{
		try
		{
			$users = new LORDRAT_MYSQL_STATS($this->_bdd);
			
			$datas = $users->get($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//	Gestion des utilisateurs	//
	//////////////////////////////////
	
	public function addUser($section,$params)
	{
		try
		{
			$users = new LORDRAT_MYSQL_USERS($this->_bdd);
			
			$datas = $users->add($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function delUser($section,$params)
	{
		try
		{
			$users = new LORDRAT_MYSQL_USERS($this->_bdd);
			
			$datas = $users->del($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getUser($section,$params)
	{
		try
		{
			$users = new LORDRAT_MYSQL_USERS($this->_bdd);
			
			$datas = $users->get($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveUser($section,$params)
	{
		try
		{
			$users = new LORDRAT_MYSQL_USERS($this->_bdd);
			
			$datas = $users->save($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchUsers($params)
	{
		try
		{
			$users = new LORDRAT_MYSQL_USERS($this->_bdd);
			
			$datas = $users->search($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//	Gestion des rateries		//
	//////////////////////////////////
	
	public function addRaterie($section,$params)
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->add($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function countRateries()
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->count();
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function delRaterie($section,$params)
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->del($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getRaterie($section,$params)
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->get($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function mapRateries()
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->map();
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function moveCriteres($section, $params)
	{
		try
		{
			$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);
			
			$datas = $criteres->move($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveRaterie($section,$params)
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->save($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchRateries($params)
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->search($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function toggleMapRaterie($id)
	{
		try
		{
			$rateries = new LORDRAT_MYSQL_RATERIES($this->_bdd);
			
			$datas = $rateries->toggleMap($id);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////////
	//	Gestion des criteres des rats	//
	//////////////////////////////////////
	
	public function addCriteres($section,$params)
	{
		try
		{
			$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);
			
			$datas = $criteres->add($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function deleteCriteres($section,$params)
	{
		try
		{
			$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);
			
			$datas = $criteres->delete($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getCriteres($section,$params)
	{
		try
		{
			$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);
			
			$datas = $criteres->get($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveCriteres($section,$params)
	{
		try
		{
			$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);
			
			$datas = $criteres->save($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchCriteres($critere,$params)
	{
		try
		{
			$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);
			
			$datas = $criteres->search($critere,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//	Gestion des rats			//
	//////////////////////////////////
	
	public function addRat($section,$params)
	{
		try
		{
			$rats = new LORDRAT_MYSQL_RATS($this->_bdd);
			
			$datas = $rats->add($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function countRats($params = NULL)
	{
		try
		{
			$rats = new LORDRAT_MYSQL_RATS($this->_bdd);
			
			$datas = $rats->count($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function delRat($params)
	{
		try
		{
			$rats = new LORDRAT_MYSQL_RATS($this->_bdd);
			
			$datas = $rats->del($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getRat($section,$params)
	{
		try
		{
			$rats = new LORDRAT_MYSQL_RATS($this->_bdd);
			
			$datas = $rats->get($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function saveRat($section,$params)
	{
		try
		{
			$rats = new LORDRAT_MYSQL_RATS($this->_bdd);
			
			$datas = $rats->save($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchRats($params)
	{
		try
		{
			$rats = new LORDRAT_MYSQL_RATS($this->_bdd);
			
			$datas = $rats->search($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	//////////////////////////////////
	//	Gestion des portées			//
	//////////////////////////////////
	
	public function addPortee($params)
	{
		try
		{
			$portees = new LORDRAT_MYSQL_PORTEES($this->_bdd);
			
			$datas = $portees->add($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function delPortee($params)
	{
		try
		{
			$portees = new LORDRAT_MYSQL_PORTEES($this->_bdd);
			
			$datas = $portees->del($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function getPortee($params)
	{
		try
		{
			$portees = new LORDRAT_MYSQL_PORTEES($this->_bdd);
			
			$datas = $portees->get($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function savePortee($section,$params)
	{
		try
		{
			$portees = new LORDRAT_MYSQL_PORTEES($this->_bdd);
			
			$datas = $portees->save($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function searchPortees($params)
	{
		try
		{
			$portees = new LORDRAT_MYSQL_PORTEES($this->_bdd);
			
			$datas = $portees->search($params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	  /////////////////////////////////////////////////
	 //			Gestion de la messagerie SAV		//
	/////////////////////////////////////////////////
	
	public function addSavMsg($section,$params)
	{
		try
		{
			$sav = new LORDRAT_MYSQL_SAV($this->_bdd);
			
			$datas = $sav->addMsg($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function listSavMsg($section,$params)
	{
		try
		{
			$sav = new LORDRAT_MYSQL_SAV($this->_bdd);
			
			$datas = $sav->searchMsg($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
	
	public function statusSav($section,$params)
	{
		try
		{
			$sav = new LORDRAT_MYSQL_SAV($this->_bdd);
			
			$datas = $sav->status($section,$params);
		}
		catch (Exception $e)
		{
			$datas = array("error", $e->getMessage());
		}
		
		return $datas;
	}
}

// Classe pour la gestion des articles
class LORDRAT_MYSQL_ARTICLES{
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
	
	public function add($params)
	{
		$add = $this->_bdd->prepare("INSERT INTO `` () VALUES ()");
		$add->execute($params);
		
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
	
	public function del($id)
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
	
	public function get($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("
			SELECT a.id id, a.section section_id, s.nom section_nom, a.ordre ordre, a.system `system`, a.publie publie, a.nom nom, a.titre titre, a.desc `desc`, a.contenu contenu, a.special special, a.auteur auteur_id, u.pseudo auteur_nom, a.date_ajout date_ajout, a.date_publication date_publication, a.last_edit last_edit, a.nbr_vues nbr_vues
			FROM `articles` a
			LEFT JOIN `sections` s ON s.id = a.section
			LEFT JOIN `users` u ON u.id_membre = a.auteur
			WHERE a.id = :id");
			$req->execute(array("id" => $params['id']));
		}
		else if(array_key_exists('nom',$params))
		{
			$req = $this->_bdd->prepare("
			SELECT a.id id, a.section section_id, s.nom section_nom, a.ordre ordre, a.system `system`, a.publie publie, a.nom nom, a.titre titre, a.desc `desc`, a.contenu contenu, a.special special, a.auteur auteur_id, u.pseudo auteur_nom, a.date_ajout date_ajout, a.date_publication date_publication, a.last_edit last_edit, a.nbr_vues nbr_vues
			FROM `articles` a
			LEFT JOIN `sections` s ON s.id = a.section
			LEFT JOIN `users` u ON u.id_membre = a.auteur
			WHERE a.nom = :nom");
			$req->execute(array("nom" => $params['nom']));
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}

		if(!array_key_exists('error',$datas))
		{
			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array(
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
				);
			}
			else
			{
				$datas = array("error"	=> LORDRAT_ERROR_NO_RESULTS);
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	public function search($params)
	{
		$query = "
		SELECT a.id id, a.section section_id, s.nom section_nom, s.titre section_titre, a.ordre ordre, a.system system, a.menu menu, a.publie publie, ac.langue langue, ac.nom nom, ac.titre titre, ac.description description, ac.contenu contenu, ac.special special, ac.auteur auteur_id, u.pseudo auteur_pseudo, ac.date_ajout date_ajout, ac.date_publication date_publication, ac.last_edit last_edit, ac.nbr_vues nbr_vues
		FROM `articles` a
		LEFT JOIN `articles_contenus` ac ON ac.article = a.id
		LEFT JOIN `sections` s ON a.section = s.id
		LEFT JOIN `users` u ON u.id_membre = ac.auteur
		WHERE `ac.langue` = :langue";
		
		if(!array_key_exists('langue', $params))
		{
			$params['langue'] = 'FR';
		}
		
		if(is_null($params['section']) AND is_null($params['auteur']))
		{
			// Tous les articles de toutes les sections de tous les auteurs
			switch($params['order'])
			{
				case "nom":
					$query .= " ORDER BY a.nom ASC";
					break;
				case "!nom":
					$query .= " ORDER BY a.nom DESC";
					break;
				case "ordre":
					$query .= " ORDER BY a.ordre ASC";
					break;
				case "!ordre":
					$query .= " ORDER BY a.ordre DESC";
					break;
				case "section":
					$query .= " ORDER BY s.nom ASC";
					break;
				case "!section":
					$query .= " ORDER BY s.nom DESC";
					break;
				case "section,nom":
					$query .= " ORDER BY s.nom ASC, a.nom ASC";
					break;
				case "!section,nom":
					$query .= " ORDER BY s.nom DESC, a.nom ASC";
					break;
				case "section,!nom":
					$query .= " ORDER BY s.nom ASC, a.nom DESC";
					break;
				case "!section,!nom":
					$query .= " ORDER BY s.nom DESC, a.nom DESC";
					break;
				case "section,ordre":
					$query .= " ORDER BY s.nom ASC, a.ordre ASC";
					break;
				case "!section,ordre":
					$query .= " ORDER BY s.nom DESC, a.ordre ASC";
					break;
				case "section,!ordre":
					$query .= " ORDER BY s.nom ASC, a.ordre DESC";
					break;
				case "!section,!ordre":
					$query .= " ORDER BY s.nom DESC, a.ordre DESC";
					break;
				default:
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
					break;
			}
			
			$req = $this->_bdd->prepare($query);
			
		}
		else if(is_null($params['auteur']))
		{
			// Filtrage par section
			if(ctype_digit(strval($params['section'])))
			{
				// Filtrage de section par l'id
				$query .= " WHERE a.section = :section";
				
				switch($params['order'])
				{
					case "nom":
						$query .= " ORDER BY a.nom ASC";
						break;
					case "!nom":
						$query .= " ORDER BY a.nom DESC";
						break;
					case "ordre":
						$query .= " ORDER BY a.ordre ASC";
						break;
					case "!ordre":
						$query .= " ORDER BY a.ordre DESC";
						break;
					case "section":
						$query .= " ORDER BY s.nom ASC";
						break;
					case "!section":
						$query .= " ORDER BY s.nom DESC";
						break;
					default:
						$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
			}
			else
			{
				// Filtrage de section par le nom
				$query .= " WHERE s.nom = :section";
				
				switch($params['order'])
				{
					case "nom":
						$query .= " ORDER BY a.nom ASC";
						break;
					case "!nom":
						$query .= " ORDER BY a.nom DESC";
						break;
					case "ordre":
						$query .= " ORDER BY a.ordre ASC";
						break;
					case "!ordre":
						$query .= " ORDER BY a.ordre DESC";
						break;
					case "section":
						$query .= " ORDER BY s.nom ASC";
						break;
					case "!section":
						$query .= " ORDER BY s.nom DESC";
						break;
					default:
						$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
			}
			
			// Si pas d'erreur sur l'ordre on execute la requête
			if(!isset($datas))
			{
				$req = $this->_bdd->prepare($query);
				$req->execute(array("section" => $params['section']));
			}
		}
		else if(is_null($params['section']))
		{
			// Filtrage par auteur
			$query .= " WHERE a.auteur = :auteur";
				
			switch($params['order'])
			{
				case "nom":
					$query .= " ORDER BY a.nom ASC";
					break;
				case "!nom":
					$query .= " ORDER BY a.nom DESC";
					break;
				case "ordre":
					$query .= " ORDER BY a.ordre ASC";
					break;
				case "!ordre":
					$query .= " ORDER BY a.ordre DESC";
					break;
				case "section":
					$query .= " ORDER BY s.nom ASC";
					break;
				case "!section":
					$query .= " ORDER BY s.nom DESC";
					break;
				default:
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
					break;
			}
			
			// Si pas d'erreur sur l'ordre on execute la requête
			if(!isset($datas))
			{
				$req = $this->_bdd->prepare($query);
				$req->execute(array("auteur" => $params['auteur']));
			}
		}
		else
		{
			// Filtrage par auteur et section
			if(ctype_digit(strval($params['section'])))
			{
				// Filtrage de section par l'id
				$query .= " WHERE s.id = :section AND a.auteur = :auteur";
				
				switch($params['order'])
				{
					case "nom":
						$query .= " ORDER BY a.nom ASC";
						break;
					case "!nom":
						$query .= " ORDER BY a.nom DESC";
						break;
					case "ordre":
						$query .= " ORDER BY a.ordre ASC";
						break;
					case "!ordre":
						$query .= " ORDER BY a.ordre DESC";
						break;
					case "section":
						$query .= " ORDER BY s.nom ASC";
						break;
					case "!section":
						$query .= " ORDER BY s.nom DESC";
						break;
					default:
						$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
			}
			else
			{
				// Filtrage de section par le nom
				$query .= " WHERE s.nom = :section AND a.auteur = :auteur";
				
				switch($params['order'])
				{
					case "nom":
						$query .= " ORDER BY a.nom ASC";
						break;
					case "!nom":
						$query .= " ORDER BY a.nom DESC";
						break;
					case "ordre":
						$query .= " ORDER BY a.ordre ASC";
						break;
					case "!ordre":
						$query .= " ORDER BY a.ordre DESC";
						break;
					case "section":
						$query .= " ORDER BY s.nom ASC";
						break;
					case "!section":
						$query .= " ORDER BY s.nom DESC";
						break;
					default:
						$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
			}
			
			// Si pas d'erreur sur l'ordre on execute la requête
			if(!isset($datas))
			{
				$req = $this->_bdd->prepare($query);
				$req->execute(array(
					"auteur"	=> $params['auteur'],
					"section"	=> $params['section']
				));
			}
		}
		
		if(!isset($datas))
		{
			switch(TRUE)
			{
				case $req->rowCount() == 0:
					$datas = array("error" => LORDRAT_ERROR_NO_RESULTS." ".$query);
					break;
				case $req->rowCount() > LORDRAT_MAX_QUERY_RESULTS:
					$datas = array("error" => LORDRAT_ERROR_TO_MANY_RESULTS);
					break;
				default:
					$datas = array();
					while($donnees = $req->fetch())
					{
						switch($params['content'])
						{
							case "full":
								$datas[] = array(
									"id"				=> $donnees['id'],
									"section"			=> array(
										"id"			=> $donnees['section_id'],
										"nom"			=> $donnees['section_nom'],
										"titre"			=> $donnees['section_titre']
									),
									"ordre"				=> $donnees['ordre'],
									"system"			=> $donnees['system'],
									"menu"				=> $donnees['menu'],
									"publie"			=> $donnees['publie'],
									"nom"				=> $donnees['nom'],
									"titre"				=> $donnees['titre'],
									"description"		=> $donnees['description'],
									"contenu"			=> $donnees['contenu'],
									"special"			=> $donnees['special'],
									"auteur"			=> array(
										"id"			=> $donnees['auteur_id'],
										"pseudo"		=> $donnees['auteur_pseudo']
									),
									"date_ajout"		=> date('d/m/Y H:i',$donnees['date_ajout']),
									"date_publication"	=> date('d/m/Y H:i',$donnees['date_publication']),
									"last_edit"			=> date('d/m/Y H:i',$donnees['last_edit']),
									"nbr_vues"			=> $donnees['nbr_vues']
								);
								break;
							case "list":
								$datas[] = array(
									"id"				=> $donnees['id'],
									"section"			=> array(
										"id"			=> $donnees['section_id'],
										"nom"			=> $donnees['section_nom'],
										"titre"			=> $donnees['section_titre']
									),
									"ordre"				=> $donnees['ordre'],
									"system"			=> $donnees['system'],
									"menu"				=> $donnees['menu'],
									"publie"			=> $donnees['publie'],
									"nom"				=> $donnees['nom'],
									"titre"				=> $donnees['titre'],
									"description"		=> $donnees['description'],
									"auteur"			=> array(
										"id"			=> $donnees['auteur_id'],
										"pseudo"		=> $donnees['auteur_pseudo']
									),
									"date_ajout"		=> date('d/m/Y H:i',$donnees['date_ajout']),
									"date_publication"	=> date('d/m/Y H:i',$donnees['date_publication']),
									"last_edit"			=> date('d/m/Y H:i',$donnees['last_edit']),
									"nbr_vues"			=> $donnees['nbr_vues']
								);
								break;
							case "menu":
								$datas[] = array(
									"id"		=> $donnees['id'],
									"section"	=> array(
										"id"	=> $donnees['section_id'],
										"nom"	=> $donnees['section_nom'],
										"titre"	=> $donnees['section_titre']
									),
									"ordre"		=> $donnees['ordre'],
									"menu"		=> $donnees['menu'],
									"publie"	=> $donnees['publie'],
									"nom"		=> $donnees['nom'],
									"titre"		=> $donnees['titre'],
								);
								break;
						}
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	public function save($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `` SET `` WHERE ``");
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

// Classe pour la gestion de l'authentification utilisateur
class LORDRAT_MYSQL_AUTH{
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
	
	
}

// Classe pour la gestion des criteres
class LORDRAT_MYSQL_CRITERES{
	private $_bdd;
	private $_langues;
	
	public function __construct($bdd)
	{
		if($bdd instanceof PDO)
		{
			$this->_bdd = $bdd;
			
			$this->_langues = array();
			
			$req = $this->_bdd->query("SELECT * FROM `langues` ORDER BY `iso`");
			
			while($donnees = $req->fetch())
			{
				$this->_langues[] = $donnees['iso'];
			}
			
			$req->closeCursor();
		}
		else
		{
			throw new Exception("This is not a PDO Object !\n");
		}
	}
	
	public function add($critere,$params)
	{
		$datas = NULL;
		
		switch($critere)
		{
			case "causesdeces":
				$critere = $this->getCausesDeces($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_causes_deces` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_causes_deces` WHERE `nom` LIKE :nom ORDER BY `id`");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_causes_deces` (nom) VALUES(:nom)");
				}*/
				break;
			case "couleurs":
				$critere = $this->getCouleurs($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_couleurs` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_couleurs` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_couleurs` (nom) VALUES(:nom)");
				}*/
				break;
			case "dilutions":
				$critere = $this->getDilutions($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_dilutions` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_dilutions` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_dilutions` (nom) VALUES(:nom)");
				}*/
				break;
			case "marquages":
				$critere = $this->getMarquages($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_marquages` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_marquages` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_marquages` (nom) VALUES(:nom)");
				}*/
				break;
			case "oreilles":
				$critere = $this->getOreilles($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_oreilles` (nom) VALUES(:nom)");
				}
				/*
				$req = $this->_bdd->prepare("SELECT * FROM `rats_oreilles` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_oreilles` (nom) VALUES(:nom)");
				}*/
				break;
			case "pbsantes":
				$critere = $this->getPbSantes($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_pb_santes` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_pb_santes` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".json_encode($params['nom'])."%"));
				
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_pb_santes` (nom) VALUES(:nom)");
				}*/
				break;
			case "poils":
				$critere = $this->getPoils($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_poils` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_poils` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_poils` (nom) VALUES(:nom)");
				}*/
				break;
			case "uniques":
				$critere = $this->getUniques($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_uniques` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_uniques` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_uniques` (nom) VALUES(:nom)");
				}*/
				break;
			case "yeux":
				$critere = $this->getYeux($params);
				
				if(is_array($critere) AND !array_key_exists('error', $critere))
				{
					$datas = "already";
				}
				else
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_yeux` (nom) VALUES(:nom)");
				}
				/*$req = $this->_bdd->prepare("SELECT * FROM `rats_yeux` WHERE `nom` LIKE :nom");
				$req->execute(array("nom" => "%".$params['nom']."%"));
				if($req->rowCount())
				{
					while($donnees = $req->fetch())
					{
						$noms = json_decode($donnees['nom']);
						
						foreach($this->_langues as $langue)
						{
							if(isset($noms->{$langue}))
							{
								if($params['nom'] == $noms->{$langue})
								{
									$datas = "already";
								}
							}
						}
					}
				}
				$req->closeCursor();
				
				if($datas == NULL)
				{
					$ins = $this->_bdd->prepare("INSERT INTO `rats_yeux` (nom) VALUES(:nom)");
				}*/
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if($datas == NULL)
		{
			$ins->execute(array("nom" => json_encode(array('FR' => $params['nom']))));

			if($ins->rowCount())
			{
				$datas = "success";
			}
			else
			{
				$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
			}

			$ins->closeCursor();
		}
		
		return $datas;
	}
	
	private function countRats($critere,$id)
	{
		switch($critere)
		{
			case "causesdeces":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `cause_deces` = :causes_deces");
				$req->execute(array('causes_deces' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "couleurs":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `couleur` = :couleur");
				$req->execute(array('couleur' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "dilutions":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `dilution` = :dilution");
				$req->execute(array('dilution' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "marquages":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `marquage` = :marquage");
				$req->execute(array('marquage' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "oreilles":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `oreilles` = :oreilles");
				$req->execute(array('oreilles' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "pbsantes":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `pb_santes` = :pb_santes");
				$req->execute(array('pb_santes' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "poils":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `poils` = :poils");
				$req->execute(array('poils' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "uniques":$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `uniques` LIKE :uniques");
				$req->execute(array('uniques' => '%"'.$id.'"%'));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			case "yeux":
				$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `yeux` = :yeux");
				$req->execute(array('yeux' => $id));
				
				$datas = $req->rowCount();
				
				$req->closeCursor();
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	public function delete($critere,$params)
	{
		switch($critere)
		{
			case "causesdeces":
				$datas = $this->deleteCausesDeces($params);
				break;
			case "couleurs":
				$datas = $this->deleteCouleurs($params);
				break;
			case "dilutions":
				$datas = $this->deleteDilutions($params);
				break;
			case "marquages":
				$datas = $this->deleteMarquages($params);
				break;
			case "pbsantes":
				$datas = $this->deletePbSantes($params);
				break;
			case "poils":
				$datas = $this->deletePoils($params);
				break;
			case "oreilles":
				$datas = $this->deleteOreilles($params);
				break;
			case "uniques":
				$datas = $this->deleteUniques($params);
				break;
			case "yeux":
				$datas = $this->deleteYeux($params);
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function deleteCausesDeces($params)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_causes_deces` WHERE `id` = :id");
		$del->execute($params);
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deleteCouleurs($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_couleurs` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deleteDilutions($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_dilutions` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deleteMarquages($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_marquages` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deleteOreilles($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_oreilles` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deletePbSantes($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_pb_santes` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deletePoils($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_poils` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deleteUniques($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_uniques` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	private function deleteYeux($id)
	{
		$del = $this->_bdd->prepare("DELETE FROM `rats_yeux` WHERE `id` = :id");
		$del->execute(array("id" => $id));
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array("error"	=> LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		return $datas;
	}
	
	public function get($critere,$params)
	{
		switch($critere)
		{
			case "causesdeces":
				$datas = $this->getCausesDeces($params);
				break;
			case "couleurs":
				$datas = $this->getCouleurs($params);
				break;
			case "dilutions":
				$datas = $this->getDilutions($params);
				break;
			case "marquages":
				$datas = $this->getMarquages($params);
				break;
			case "poils":
				$datas = $this->getPoils($params);
				break;
			case "oreilles":
				$datas = $this->getOreilles($params);
				break;
			case "pbsantes":
				$datas = $this->getPbSantes($params);
				break;
			case "uniques":
				$datas = $this->getUniques($params);
				break;
			case "yeux":
				$datas = $this->getYeux($params);
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function getCausesDeces($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_causes_deces` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_causes_deces` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getCouleurs($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_couleurs` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_couleurs` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}

		return $datas;
	}
	
	private function getDilutions($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_dilutions` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_dilutions` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getMarquages($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_marquages` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_marquages` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getOreilles($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_oreilles` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_oreilles` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getPbSantes($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_pb_santes` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_pb_santes` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getPoils($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_poils` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_poils` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getUniques($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_uniques` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_uniques` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	private function getYeux($params)
	{
		if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_yeux` WHERE `id` = :id ORDER BY `id`");
			$req->execute(array("id" => $params['id']));

			$datas = NULL;

			if($req->rowCount())
			{
				$donnees = $req->fetch();

				$datas = array();

				$datas[] = array(
					"id"	=> $donnees['id'],
					"nom"	=> json_decode($donnees['nom'])
				);
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_INEXISTENT_ITEM." - id : ".$params['id']);
			}
		}
		else if(array_key_exists('nom', $params))
		{
			$req = $this->_bdd->query("SELECT * FROM `rats_yeux` ORDER BY `nom`");
			
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$noms = json_decode($donnees['nom']);

				foreach($this->_langues as $langue)
				{
					if(isset($noms->{$langue}))
					{
						if($params['nom'] == $noms->{$langue})
						{
							$datas = array();

							$datas[] = array(
								"id"	=> $donnees['id'],
								"nom"	=> $noms
							);
						}
					}
				}
			}

			$req->closeCursor();

			if($datas == NULL)
			{
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
			}
		}
		else
		{
			$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		return $datas;
	}
	
	public function move($critere, $params)
	{
		switch($critere)
		{
			case "causesdeces":
				$datas = $this->moveCausesDeces($params);
				break;
			case "couleurs":
				$datas = $this->moveCouleurs($params);
				break;
			case "dilutions":
				$datas = $this->moveDilutions($params);
				break;
			case "marquages":
				$datas = $this->moveMarquages($params);
				break;
			case "oreilles":
				$datas = $this->moveOreilles($params);
				break;
			case "pbsantes":
				$datas = $this->movePbSantes($params);
				break;
			case "poils":
				$datas = $this->movePoils($params);
				break;
			case "uniques":
				$datas = $this->moveUniques($params);
				break;
			case "yeux":
				$datas = $this->moveYeux($params);
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function moveCausesDeces($params)
	{
		$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `cause_deces` = :source");
		$req->execute(array('source' => $params['source']));
		
		$tomove = $req->rowCount();
		
		if($tomove)
		{
			$upt = $this->_bdd->prepare("UPDATE `rats` SET `cause_deces` = :cible WHERE `cause_deces` = :source");
			$upt->execute($params);
			
			if($upt->rowCount() == $tomove)
			{
				$datas = "success";
			}
			else
			{
				$datas = array('error' => LORDRAT_ERROR_UPDATE_TABLE_FAILED);
			}
			
			$upt->closeCursor();
		}
		else
		{
			$datas = "success";
		}
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function search($critere, $params)
	{
		switch($critere)
		{
			case "causesdeces":
				$datas = $this->searchCausesDeces($params);
				break;
			case "couleurs":
				$datas = $this->searchCouleurs($params);
				break;
			case "dilutions":
				$datas = $this->searchDilutions($params);
				break;
			case "marquages":
				$datas = $this->searchMarquages($params);
				break;
			case "oreilles":
				$datas = $this->searchOreilles($params);
				break;
			case "pbsantes":
				$datas = $this->searchPbSantes($params);
				break;
			case "poils":
				$datas = $this->searchPoils($params);
				break;
			case "uniques":
				$datas = $this->searchUniques($params);
				break;
			case "yeux":
				$datas = $this->searchYeux($params);
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function searchCausesDeces($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_causes_deces` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_causes_deces` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("causesdeces",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchCouleurs($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_couleurs` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_couleurs` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("couleurs",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchDilutions($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_dilutions` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_dilutions` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("dilutions",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchMarquages($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_marquages` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_marquages` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("marquages",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchOreilles($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_oreilles` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_oreilles` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("oreilles",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchPbSantes($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_pb_santes` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_pb_santes` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("pbsantes",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchPoils($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_poils` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_poils` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("poils",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	private function searchUniques($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_uniques` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_uniques` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("uniques",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}

		return $datas;
	}
	
	private function searchYeux($params)
	{
		switch($params['order'])
		{
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_yeux` ORDER BY `nom` ASC");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_yeux` ORDER BY `nom` DESC");
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if(isset($req))
		{
			$req->execute(array());

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
						$datas[] = array(
							"id"		=> $donnees["id"],
							"nom"		=> json_decode($donnees["nom"]),
							"count"		=> $this->countRats("yeux",$donnees['id'])
						);
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	public function save($critere,$params)
	{
		switch($critere)
		{
			case "causesdeces":
				$datas = $this->saveCausesDeces($params);
				break;
			case "couleurs":
				$datas = $this->saveCouleurs($params);
				break;
			case "dilutions":
				$datas = $this->saveDilutions($params);
				break;
			case "marquages":
				$datas = $this->saveMarquages($params);
				break;
			case "pbsantes":
				$datas = $this->savePbSantes($params);
				break;
			case "poils":
				$datas = $this->savePoils($params);
				break;
			case "oreilles":
				$datas = $this->saveOreilles($params);
				break;
			case "uniques":
				$datas = $this->saveUniques($params);
				break;
			case "yeux":
				$datas = $this->saveYeux($params);
				break;
			default:
				$datas = array("error"	=> LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function saveCausesDeces($params)
	{
		error_log(json_encode($params));
		
		$upt = $this->_bdd->prepare("UPDATE `rats_causes_deces` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function saveCouleurs($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_couleurs` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function saveDilutions($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_dilutions` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function saveMarquages($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_marquages` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function saveOreilles($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_oreilles` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function savePbSantes($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_pb_santes` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function savePoils($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_poils` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function saveUniques($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_uniques` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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
	
	private function saveYeux($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `rats_yeux` SET `nom` = :nom WHERE `id` = :id");
		$upt->execute(array(
			'id'	=> $params['id'],
			'nom'	=> json_encode(array('FR' => $params['nom']))
		));
		
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

// Classe pour la gestion des Medias
class LORDRAT_MYSQL_MEDIAS{
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
	
	public function add($params)
	{
		$ins = $this->_bdd->prepare("INSERT INTO `medias` VALUES('',:fichier,:nom,:desc,:auteur,:meta,:timestamp,:timestamp)");
		$ins->execute(array(
			"fichier"		=> $params['fichier'],
			"nom"			=> $params['nom'],
			"desc"			=> $params['desc'],
			"auteur"		=> $params['auteur'],
			"meta"			=> $params['meta'],
			"timestamp"		=> time()
		));

		if($ins->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_INSERT_TABLE_FAILED);
		}

		$ins->closeCursor();
		
		return $datas;
	}
	
	public function delete($params)
	{
		$del = $this->_bdd->prepare("DELETE FROM `medias` WHERE `id` = :id");
		$del->execute($params);
		
		if($del->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_DELETE_TABLE_FAILED);
		}
		
		$del->closeCursor();
		
		return $datas;
	}
	
	public function get($params)
	{
		$req = $this->_bdd->prepare("
		SELECT m.id id, m.fichier fichier, m.nom nom, m.commentaires commentaires, m.auteur auteur_id, m.meta meta, m.date_ajout date_ajout, m.date_edit date_edit, u.pseudo auteur_pseudo
		FROM `medias` m
		LEFT JOIN `users` u ON u.id_membre = m.auteur
		WHERE `id` = :id");
		$req->execute($params);
		
		if($req->rowCount())
		{
			$datas = array();
			
			$donnees = $req->fetch();
			
			$datas[] = array(
				'id'			=> $donnees['id'],
				'fichier'		=> $donnees['fichier'],
				'nom'			=> $donnees['nom'],
				'commentaires'	=> $donnees['commentaires'],
				'auteur'		=> array(
					'id'		=> $donnees['auteur_id'],
					'pseudo'	=> $donnees['auteur_pseudo']
				),
				'meta'			=> json_decode($donnees['meta']),
				'date_ajout'	=> $donnees['date_ajout'],
				'date_edit'		=> $donnees['date_edit']
			);
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_NO_RESULTS);
		}
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function save($params)
	{
		
	}
	
	public function search($params)
	{
		// Base de la requete
		$query = "
		SELECT m.id id, m.fichier fichier, m.nom nom, m.commentaires commentaires, m.auteur auteur_id, m.meta meta, m.date_ajout date_ajout, m.date_edit date_edit, u.pseudo auteur_pseudo
		FROM `medias` m
		LEFT JOIN `users` u ON u.id_membre = m.auteur
		";
		
		// Gestion du filtrage, lien entre paramètre de recherche et les champs ou faire la requête
		$autorized_params = array(
			"fichier"		=> array("fichier"),
			"nom"			=> array("nom"),
			"auteur"		=> array("auteur")
		);
		
		$select = "";
		
		$request_array = array();
		
		foreach($params as $param_key => $param_value)
		{
			if(!empty($param_value) AND array_key_exists($param_key,$autorized_params))
			{
				if(empty($select))
				{
					$select .= " WHERE (";
				}
				else
				{
					$select .= " AND (";
				}
				
				$i = 0;

				foreach($autorized_params[$param_key] as $field)
				{
					if(is_numeric($param_value))
					{
						$request_array[$field] = $param_value;
						
						if($i == 0)
						{
							$select .= "`".$field."` = :".$field;
						}
						else
						{
							$select .= " OR `".$field."` = :".$field;
						}
					}
					else
					{
						$request_array[$field] = "%".$param_value."%";
						
						if($i == 0)
						{
							$select .= "`".$field."` LIKE :".$field;
						}
						else
						{
							$select .= " OR `".$field."` LIKE :".$field;
						}
					}
					
					$i++;
				}

				$select .= ")";
			}
		}
		
		// Assemblage de la requête
		$query .= $select." ORDER BY `id` DESC";
		
		$search_infos = "Search query is : ".$query."; With parameters : ".json_encode($request_array);
		
		$req = $this->_bdd->prepare($query);
		$req->execute($request_array);
		
		switch(TRUE)
		{
			case $req->rowCount() == 0:
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
				$search_infos .= " - Results : ".LORDRAT_ERROR_NO_RESULTS;
				break;
			case $req->rowCount() > LORDRAT_MAX_QUERY_RESULTS:
				$datas = array("error" => LORDRAT_ERROR_TO_MANY_RESULTS);
				$search_infos .= " - Results : ".LORDRAT_ERROR_TO_MANY_RESULTS;
				break;
			default:
				$datas = array();
				$search_infos .= " - Results : ".$req->rowCount()." results.";
				while($donnees = $req->fetch())
				{
					$datas[] = array(
						"id"				=> $donnees['id'],
						"fichier"			=> $donnees['fichier'],
						"nom"				=> $donnees['nom'],
						"commentaires"		=> $donnees['commentaires'],
						"auteur"			=> array(
							"id"		=> $donnees['auteur_id'],
							"pseudo"	=> $donnees['auteur_pseudo']
						),
						"meta"				=> json_decode($donnees['meta']),
						"date_ajout"		=> $donnees['date_ajout'],
						"date_edit"			=> $donnees['date_edit']
					);
				}
				break;
		}
		
		$req->closeCursor();
		
		return $datas;
	}
}

// Classe pour la gestion des portéess
class LORDRAT_MYSQL_PORTEES{
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
	
	public function add($params)
	{
		$add = $this->_bdd->prepare("INSERT INTO `rats_portees` (`old_id`,`id_mere`,`id_pere`,`user`,`date_accouchement`,`nombres_petits`,`commentaires`) VALUES (:old_id,:id_mere,:id_pere,:user,:date_accouchement,:nombres_petits,:commentaires)");
		$add->execute($params);
		
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
	
	public function del($id)
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
	
	public function get($params)
	{
		if(array_key_exists('old_id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_portees` WHERE `old_id` = :old_id");
		}
		else if(array_key_exists('id',$params))
		{
			$req = $this->_bdd->prepare("SELECT * FROM `rats_portees` WHERE `id` = :id");
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
		}
		
		if(!isset($datas))
		{
			$req->execute($params);
			
			$datas = array();

			if($req->rowCount())
			{
				$donnees = $req->fetch();
				
				$datas[] = array(
					"id"				=> $donnees['id'],
					"old_id"			=> $donnees['old_id'],
					"id_mere"			=> $donnees['id_mere'],
					"id_pere"			=> $donnees['id_pere'],
					"user"				=> $donnees['user'],
					"date_accouchement"	=> $donnees['date_accouchement'],
					"nombres_petits"	=> $donnees['nombres_petits'],
					"commentaires"		=> $donnees['commentaires']
				);
			}
			else
			{
				$datas = array("error"	=> LORDRAT_ERROR_NO_RESULTS);
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	public function search($order)
	{
		$req = $this->_bdd->prepare("
        SELECT 
		FROM ``
		WHERE ``");
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
					
				}
				break;
		}
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function save($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `` SET `` WHERE ``");
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

// Classe pour la gestion des rats
class LORDRAT_MYSQL_RATS{
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
			case "base":
				$add = $this->_bdd->prepare("INSERT INTO `rats` (raterie,nom_courant,nom_naissance,sexe,numero,pere,mere,vivant,pb_santes,date_naissance,date_deces,cause_deces,user,couleur,dilution,marquage,oreilles,poils,uniques,yeux,portee,repro,repro_date,commentaires,date_ajout,date_user_view,date_last_edit,sav_check,etat) VALUES (:raterie,:nom_courant,:nom_naissance,:sexe,:numero,:pere,:mere,:vivant,:pb_santes,:date_naissance,:date_deces,:cause_deces,:user,:couleur,:dilution,:marquage,:oreilles,:poils,:uniques,:yeux,:portee,:repro,:repro_date,:commentaires,:date_ajout,:date_user_view,:date_last_edit,:sav_check,:etat)");
				$add->execute($params);

				if($add->rowCount())
				{
					$datas = "success";
				}
				else
				{
					$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
				}

				$add->closeCursor();
				break;
			case "image":
				$add = $this->_bdd->prepare("INSERT INTO `rats_images` (id_rat,fichier,status,date_ajout,date_user_view,date_last_edit) VALUES (:id_rat,:fichier,:status,:date_ajout,:date_user_view,:date_last_edit)");
				$add->execute($params);

				if($add->rowCount())
				{
					$datas = "success";
				}
				else
				{
					$datas = array("error"	=> LORDRAT_ERROR_INSERT_TABLE_FAILED);
				}

				$add->closeCursor();
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	public function count($params)
	{
		if(!is_null($params) AND array_key_exists('sav', $params))
		{
			switch($params['sav'])
			{
				case "1":
					#$req = $this->_bdd->query("SELECT `id` FROM `rats` WHERE `etat` = 1");
					$req = $this->_bdd->query("SELECT count(`id`) FROM `rats` WHERE `etat` = 1");
					break;
				default:
					#$req = $this->_bdd->query("SELECT `id` FROM `rats` WHERE `etat` = 2");
					$req = $this->_bdd->query("SELECT count(`id`) FROM `rats` WHERE `etat` = 2");
					break;
			}
		}
		else
		{
			#$req = $this->_bdd->query("SELECT `id` FROM `rats`");
			$req = $this->_bdd->query("SELECT count(`id`) FROM `rats`");
		}
		
		#$datas = $req->rowCount();
		$datas = $req->fetchColumn();

		$req->closeCursor();
		
		return intval($datas);
	}
	
	public function del($id)
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
	
	private function getParentsId($id,$depth,$max_depth)
	{
		$req = $this->_bdd->prepare("SELECT `pere`,`mere` FROM `rats`");
		$req->execute(array('id' => $id));
		
		
		
		$req->closeCursor();
		
		// Si on n'a pas atteint la profondeur maximale pour la généalogie on continue de remonter le fil des parents
		if($depth == $max_depth)
		{
			
		}
	}
	
	public function get($section,$params)
	{
		switch($section)
		{
			case "base":
				if(array_key_exists('id',$params))
				{
					$req = $this->_bdd->prepare("
					SELECT r.id id, r.raterie id_raterie, ra.affixe affixe_raterie, ra.nom nom_raterie, r.nom_courant nom_courant, r.nom_naissance, r.sexe sexe, r.numero numero, r.pere id_pere, r.mere id_mere, r.vivant vivant, r.pb_santes pb_santes, r.date_naissance date_naissance, r.date_deces date_deces, r.cause_deces id_cause_deces, cd.nom nom_cause_deces, r.user id_proprio, u.pseudo nom_proprio, r.couleur id_couleur, r.dilution id_dilution, r.marquage id_marquage, r.oreilles id_oreilles, r.poils id_poils, r.uniques ids_uniques, r.yeux id_yeux, r.portee id_portee, r.repro repro, r.repro_date repro_date, r.commentaires commentaires, r.date_ajout date_ajout, r.date_user_view date_user_view, r.date_last_edit date_last_edit, r.sav_check sav_check, r.etat etat
					FROM `rats` r
					LEFT JOIN `users` u ON u.id_membre = r.user
					LEFT JOIN `rateries` ra ON ra.id_raterie = r.raterie
					LEFT JOIN `rats_causes_deces` cd ON cd.id = r.cause_deces
					WHERE r.id = :id");
					$req->execute($params);
				}
				else if(array_key_exists('numero',$params))
				{
					$req = $this->_bdd->prepare("
					SELECT r.id id, r.raterie id_raterie, ra.affixe affixe_raterie, ra.nom nom_raterie, r.nom_courant nom_courant, r.nom_naissance, r.sexe sexe, r.numero numero, r.pere id_pere, r.mere id_mere, r.vivant vivant, r.pb_santes pb_santes, r.date_naissance date_naissance, r.date_deces date_deces, r.cause_deces id_cause_deces, cd.nom nom_cause_deces, r.user id_proprio, u.pseudo nom_proprio, r.couleur id_couleur, r.dilution id_dilution, r.marquage id_marquage, r.oreilles id_oreilles, r.poils id_poils, r.uniques ids_uniques, r.yeux id_yeux, r.portee id_portee, r.repro repro, r.repro_date repro_date, r.commentaires commentaires, r.date_ajout date_ajout, r.date_user_view date_user_view, r.date_last_edit date_last_edit, r.sav_check sav_check, r.etat etat
					FROM `rats` r
					LEFT JOIN `users` u ON u.id_membre = r.user
					LEFT JOIN `rateries` ra ON ra.id_raterie = r.raterie
					LEFT JOIN `rats_causes_deces` cd ON cd.id = r.cause_deces
					WHERE r.numero = :numero");
					$req->execute($params);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				
				$criteres = new LORDRAT_MYSQL_CRITERES($this->_bdd);

				if(!isset($datas))
				{
					if($req->rowCount())
					{
						$donnees = $req->fetch();

						$datas = array();
						
						$uniques = array();
						
						// Réccupération des informations sur les parents
						if($donnees['id_pere'] != 0)
						{
							$pere = $this->get("base",array("id" => $donnees['id_pere']))[0];
						}
						else
						{
							$pere = array(
								"raterie"		=> array(
									"affixe"	=> NULL
								),
								"nom_naissance"	=> NULL
							);
						}
						
						if($donnees['id_mere'] != 0)
						{
							$mere = $this->get("base",array("id" => $donnees['id_mere']))[0];
						}
						else
						{
							$mere = array(
								"raterie"		=> array(
									"affixe"	=> NULL
								),
								"nom_naissance"	=> NULL
							);
						}
						
						$nullcritere = array(
							'id'	=> NULL,
							'nom'	=> array(
								'FR' => ""
							)
						);
						
						// Réccupération des informations sur les critères
						if($donnees["id_couleur"] != 0)
						{
							$couleur = $criteres->get("couleurs",array("id" => $donnees['id_couleur']))[0];
						}
						else
						{
							$couleur = $nullcritere;
						}
						
						if($donnees["id_dilution"] != 0)
						{
							$dilution = $criteres->get("dilutions",array("id" => $donnees['id_dilution']))[0];
						}
						else
						{
							$dilution = $nullcritere;
						}
						
						if($donnees["id_marquage"] != 0)
						{
							$marquage = $criteres->get("marquages",array("id" => $donnees['id_marquage']))[0];
						}
						else
						{
							$marquage = $nullcritere;
						}
						
						if($donnees["id_oreilles"] != 0)
						{
							$oreilles = $criteres->get("oreilles",array("id" => $donnees['id_oreilles']))[0];
						}
						else
						{
							$oreilles = $nullcritere;
						}
						
						if($donnees["id_poils"] != 0)
						{
							$poils = $criteres->get("poils",array("id" => $donnees['id_poils']))[0];
						}
						else
						{
							$poils = $nullcritere;
						}
						
						if(is_array(json_decode($donnees['ids_uniques'])))
						{
							foreach(json_decode($donnees['ids_uniques']) as $unique)
							{
								$uniques[] = $criteres->get("uniques",array("id" => $unique))[0];
							}
						}
						
						while(count($uniques) < 4)
						{
							$uniques[] = $nullcritere;
						}
						
						if($donnees["id_yeux"] != 0)
						{
							$yeux = $criteres->get("yeux",array("id" => $donnees['id_yeux']))[0];
						}
						else
						{
							$yeux = $nullcritere;
						}
						
						// Date de naissance au format string
						if($donnees['date_naissance'] < 1000000)
						{
							$date_naissance = "Non définie";
						}
						else
						{
							$date_naissance = date('d/m/Y',$donnees['date_naissance']);
						}
						
						// Date de naissance au format string
						if($donnees['date_deces'] < 1000000)
						{
							$date_deces = "Non définie";
						}
						else
						{
							$date_deces = date('d/m/Y',$donnees['date_deces']);
						}
			
						$datas[] = array(
							"id_rat"			=> $donnees['id'],
							"image"				=> $this->get("image",array("id_rat" => $donnees['id'])),
							"raterie"			=> array(
								"id"		=> $donnees['id_raterie'],
								"affixe"	=> $donnees['affixe_raterie'],
								"nom"		=> $donnees['nom_raterie']
							),
							"nom_courant"		=> $donnees['nom_courant'],
							"nom_naissance"		=> $donnees['nom_naissance'],
							"sexe"				=> $donnees['sexe'],
							"numero"			=> $donnees['numero'],
							"pere"				=> array(
								"id"			=> $donnees['id_pere'],
								"affixe"		=> $pere['raterie']['affixe'],
								"nom_naissance"	=> $pere['nom_naissance']
							),
							"mere"				=> array(
								"id"			=> $donnees['id_mere'],
								"affixe"		=> $mere['raterie']['affixe'],
								"nom_naissance"	=> $mere['nom_naissance']
							),
							"vivant"			=> $donnees['vivant'],
							"pb_santes"			=> $donnees['pb_santes'],
							"date_naissance"	=> array(
								"raw"				=> $donnees['date_naissance'],
								"string"			=> $date_naissance
							),
							"date_deces"		=> array(
								"raw"				=> $donnees['date_deces'],
								"string"			=> $date_deces
							),
							"cause_deces"		=> array(
								"id"	=> $donnees['id_cause_deces'],
								"nom"	=> json_decode($donnees['nom_cause_deces'])
							),
							"proprio"			=> array(
								"id"	=> $donnees['id_proprio'],
								"nom"	=> $donnees['nom_proprio']
							),
							"couleur"			=> $couleur,
							"dilution"			=> $dilution,
							"marquage"			=> $marquage,
							"oreilles"			=> $oreilles,
							"poils"				=> $poils,
							"uniques"			=> $uniques,
							"yeux"				=> $yeux,
							"portee"			=> array(
								"id" => $donnees['id_portee']
							),
							"repro"				=> $donnees['repro'],
							"repro_date"		=> $donnees['repro_date'],
							"commentaires"		=> htmlspecialchars($donnees['commentaires'],ENT_QUOTES),
							"date_ajout"		=> array(
								"raw"				=> $donnees['date_ajout'],
								"string"			=> date('d/m/Y à H:i',$donnees['date_ajout'])
							),
							"date_user_view"	=> array(
								"raw"				=> $donnees['date_user_view'],
								"string"			=> date('d/m/Y à H:i',$donnees['date_user_view'])
							),
							"date_last_edit"	=> array(
								"raw"				=> $donnees['date_last_edit'],
								"string"			=> date('d/m/Y à H:i',$donnees['date_last_edit'])
							),
							"sav_check"			=> array(
								'raw'				=> $donnees['sav_check'],
								'html'				=> nl2br($donnees['sav_check'])
							),
							"etat"				=> $donnees['etat']
						);
					}
					else
					{
						$datas = array("error"	=> LORDRAT_ERROR_NO_RESULTS);
					}

					$req->closeCursor();
				}
				break;
			case "descendance":
				if(is_array($params))
				{
					if(array_key_exists('id',$params))
					{
						$req = $this->_bdd->prepare("
						SELECT r.id id, r.raterie id_raterie, ra.affixe affixe_raterie, ra.nom nom_raterie, r.nom_courant nom_courant, r.nom_naissance, r.sexe sexe, r.numero numero, r.pere id_pere, r.mere id_mere, r.vivant vivant, r.pb_santes pb_santes, r.date_naissance date_naissance, r.date_deces date_deces, r.cause_deces id_cause_deces, cd.nom nom_cause_deces, r.user id_proprio, u.pseudo nom_proprio, r.couleur id_couleur, r.dilution id_dilution, r.marquage id_marquage, r.oreilles id_oreilles, r.poils id_poils, r.uniques ids_uniques, r.yeux id_yeux, r.portee id_portee, r.repro repro, r.repro_date repro_date, r.commentaires commentaires, r.date_ajout date_ajout, r.date_user_view date_user_view, r.date_last_edit date_last_edit, r.sav_check sav_check, r.etat etat
						FROM `rats` r
						LEFT JOIN `users` u ON u.id_membre = r.user
						LEFT JOIN `rateries` ra ON ra.id_raterie = r.raterie
						LEFT JOIN `rats_causes_deces` cd ON cd.id = r.cause_deces
						WHERE `pere` = :id OR `mere` = :id
						ORDER BY `id` DESC");
						$req->execute(array('id' => $params['id']));
						
						if($req->rowCount())
						{
							$datas = array();
							
							while($donnees = $req->fetch())
							{
								// Réccupération des informations sur les parents
								if($donnees['id_pere'] != 0)
								{
									$pere = $this->get("base",array("id" => $donnees['id_pere']))[0];
								}
								else
								{
									$pere = array(
										"raterie"		=> array(
											"affixe"	=> NULL
										),
										"nom_naissance"	=> NULL
									);
								}

								if($donnees['id_mere'] != 0)
								{
									$mere = $this->get("base",array("id" => $donnees['id_mere']))[0];
								}
								else
								{
									$mere = array(
										"raterie"		=> array(
											"affixe"	=> NULL
										),
										"nom_naissance"	=> NULL
									);
								}
								
								$datas[] = array(
									"id_rat"			=> $donnees['id'],
									"raterie"			=> array(
										"id"		=> $donnees['id_raterie'],
										"affixe"	=> $donnees['affixe_raterie'],
										"nom"		=> $donnees['nom_raterie']
									),
									"nom_naissance"		=> $donnees['nom_naissance'],
									"numero"			=> $donnees['numero'],
									"pere"				=> array(
										"id"			=> $donnees['id_pere'],
										"affixe"		=> $pere['raterie']['affixe'],
										"nom_naissance"	=> $pere['nom_naissance']
									),
									"mere"				=> array(
										"id"			=> $donnees['id_mere'],
										"affixe"		=> $mere['raterie']['affixe'],
										"nom_naissance"	=> $mere['nom_naissance']
									),
									"vivant"			=> $donnees['vivant'],
									"date_naissance"	=> array(
										"raw"				=> $donnees['date_naissance'],
										"string"			=> date('d/m/Y',$donnees['date_naissance'])
									), 
									"date_deces"		=> array(
										"raw"				=> $donnees['date_deces'],
										"string"			=> date('d/m/Y',$donnees['date_deces'])
									),
									"cause_deces"		=> array(
										"id"	=> $donnees['id_cause_deces'],
										"nom"	=> json_decode($donnees['nom_cause_deces'])
									)
								);
							}
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_NO_RESULTS);
						}
						
						$req->closeCursor();
					}
					else
					{
						$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS." - Missing id");
					}
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS." - Not Array");
				}
				break;
			case "genealogie":
				if(is_array($params))
				{
					if(array_key_exists('id',$params))
					{
						
					}
					else
					{
						$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
					}
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "image":
				$req = $this->_bdd->prepare("SELECT * FROM `rats_images` WHERE `id_rat` = :id_rat");
				$req->execute($params);
				
				if($req->rowCount())
				{
					$datas = array();
					
					while($donnees = $req->fetch())
					{
						$datas[] = array(
							"id_image"	=> $donnees['id_photo_rat'],
							"fichier"	=> $donnees['fichier']
						);
					}
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
				}
				
				$req->closeCursor();
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		
		return $datas;
	}
	
	public function save($section,$params)
	{
		switch($section)
		{
			case "base":
				$upt = $this->_bdd->prepare("UPDATE `rats` SET raterie = :raterie, nom_courant = :nom_courant, nom_naissance = :nom_naissance, sexe = :sexe, numero = :numero, pere = :pere, mere = :mere, vivant = :vivant, pb_santes = :pb_santes, date_naissance = :date_naissance, date_deces = :date_deces, cause_deces = :cause_deces, user = :user, couleur = :couleur, dilution = :dilution, marquage = :marquage, oreilles = :oreilles, poils = :poils, uniques = :uniques, yeux = :yeux, portee = :portee, repro = :repro, repro_date = :repro_date, commentaires = :commentaires, date_ajout = :date_ajout, date_user_view = :date_user_view, date_last_edit = :date_last_edit, sav_check = :sav_check, etat = :etat WHERE `id` = :id_rat");
				$upt->execute($params);

				if($upt->rowCount())
				{
					$datas = "success";
				}
				else
				{
					$datas = "already";
				}

				$upt->closeCursor();
				break;
			case "image":
				$upt = $this->_bdd->prepare("UPDATE `rats_images` SET fichier = :fichier, status = :status, date_ajout = :date_ajout, date_user_view = :date_user_view, date_last_edit = :date_last_edit WHERE id_photo = :id_photo AND id_rat = :id_rat");
				$upt->execute($params);

				if($upt->rowCount())
				{
					$datas = "success";
				}
				else
				{
					$datas = "already";
				}

				$upt->closeCursor();
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	public function search($params)
	{
		// Base de la requete
		$query = "
		SELECT r.id id, r.raterie raterie_id, rt.affixe raterie_affixe, rt.nom raterie_nom, r.nom_courant, r.nom_naissance, r.sexe, r.numero, ri.fichier, r.pere, r.mere, r.vivant, r.date_naissance, r.date_deces, r.cause_deces, r.user, r.couleur, r.dilution, r.marquage, r.oreilles, r.poils, r.yeux, r.portee, r.repro, r.repro_date, r.commentaires, r.date_ajout, r.date_user_view, r.date_last_edit, r.sav_check, r.etat, u.id_membre, u.pseudo pseudo
		FROM `rats` r
		LEFT JOIN `rats_images` ri ON ri.id_rat = r.id
		LEFT JOIN `rateries` rt ON rt.id_raterie = r.raterie
		LEFT JOIN `users` u ON u.id_membre = r.user
		";
		
		// Gestion du filtrage, lien entre paramètre de recherche et les champs ou faire la requête
		$autorized_params = array(
			"origine"		=> array("r.raterie"),
			"proprio"		=> array("r.user"),
			"couleurs"		=> array("r.couleur"),
			"dilutions"		=> array("r.dilution"),
			"fastsearch"	=> array("r.nom_courant","r.nom_naissance","r.numero"),
			"marquages"		=> array("r.marquage"),
			"nom"			=> array("r.nom_courant","r.nom_naissance"),
			"numero"		=> array("r.numero"),
			"oreilles"		=> array("r.oreilles"),
			"poils"			=> array("r.poils"),
			"raterie"		=> array("r.raterie"),
			"etat"			=> array("r.etat"),
			"sexe"			=> array("r.sexe"),
			"user"			=> array("r.user"),
			"uniques"		=> array("r.unique"),
			"vivant"		=> array("r.vivant"),
			"yeux"			=> array("r.yeux")
		);
		
		$select = "";
		
		$request_array = array();
		
		foreach($params as $param_key => $param_value)
		{
			if(!empty($param_value) AND array_key_exists($param_key,$autorized_params))
			{
				if(empty($select))
				{
					$select .= " WHERE (";
				}
				else
				{
					$select .= " AND (";
				}
				
				$i = 0;

				foreach($autorized_params[$param_key] as $field)
				{
					if(is_numeric($param_value))
					{
						$request_array[$param_key] = $param_value;
						
						if($i == 0)
						{
							$select .= $field." = :".$param_key;
						}
						else
						{
							$select .= " OR ".$field." = :".$param_key;
						}
					}
					else
					{
						$request_array[$param_key] = "%".$param_value."%";
						
						if($i == 0)
						{
							$select .= $field." LIKE :".$param_key;
						}
						else
						{
							$select .= " OR ".$field." LIKE :".$param_key;
						}
					}
					
					$i++;
				}

				$select .= ")";
			}
		}
		
		// Tri des entrées "affixe","!affixe","nom","!nom","numero","!numero","origine","!origine","proprio","!proprio"
		switch($params['order'])
		{
			case "affixe":
				$order = " ORDER BY rt.affixe ASC";
				break;
			case "!affixe":
				$order = " ORDER BY rt.affixe DESC";
				break;
			case "dateajout":
				$order = " ORDER BY r.date_ajout ASC";
				break;
			case "!dateajout":
				$order = " ORDER BY r.date_ajout DESC";
				break;
			case "nom":
				$order = " ORDER BY r.nom_naissance ASC";
				break;
			case "!nom":
				$order = " ORDER BY r.nom_naissance DESC";
				break;
			case "numero":
				$order = " ORDER BY r.numero ASC";
				break;
			case "!numero":
				$order = " ORDER BY r.numero DESC";
				break;
			case "origine":
				$order = " ORDER BY rt.nom ASC";
				break;
			case "!origine":
				$order = " ORDER BY rt.nom DESC";
				break;
			case "proprio":
				$order = " ORDER BY u.pseudo ASC";
				break;
			case "!proprio":
				$order = " ORDER BY u.pseudo DESC";
				break;
			default:
				$order = " ORDER BY r.numero DESC";
				break;
		}
		
		$limit = " LIMIT :quantity OFFSET :start";
		$request_array['quantity']	= $params['quantity'];
		$request_array['start']		= $params['start'];
		
		// Assemblage de la requête
		$query .= $select.$order.$limit;
		
		$search_infos = "Search query is : ".$query."; With parameters : ".json_encode($request_array);
		
		error_log($search_infos);
		
		$typeArray = array(
			'quantity'	=> PDO::PARAM_INT,
			'start'		=> PDO::PARAM_INT
		);
		
		$req = bindArrayValue($this->_bdd->prepare($query),$request_array);
		$req->execute();
		/*$req->bindValue(':quantity', (int) $filters['quantity'], PDO::PARAM_INT); 
		$req->bindValue(':start', (int) $filters['start'], PDO::PARAM_INT);
		if(count($request_array) == 0)
		{
			$req->execute();
		}
		else
		{
			$req->execute($request_array);
		}*/
		
		switch(TRUE)
		{
			case $req->rowCount() == 0:
				$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
				$search_infos .= " - Results : ".LORDRAT_ERROR_NO_RESULTS;
				break;
			case $req->rowCount() > LORDRAT_MAX_QUERY_RESULTS:
				$datas = array("error" => LORDRAT_ERROR_TO_MANY_RESULTS);
				$search_infos .= " - Results : ".LORDRAT_ERROR_TO_MANY_RESULTS;
				break;
			default:
				$datas = array();
				$search_infos .= " - Results : ".$req->rowCount()." results.";
				while($donnees = $req->fetch())
				{
					$datas[] = array(
						"id"				=> $donnees['id'],
						"raterie"			=> array(
							"id"		=> $donnees['raterie_id'],
							"affixe"	=> $donnees['raterie_affixe'],
							"nom"		=> $donnees['raterie_nom']
						),
						"proprio"			=> array(
							"id"		=> $donnees['id_membre'],
							"pseudo"	=> $donnees['pseudo']
						),
						"nom_courant_rat"	=> $donnees['nom_courant'],
						"nom_naissance_rat"	=> $donnees['nom_naissance'],
						"sexe"				=> $donnees['sexe'],
						"numero"			=> $donnees['numero'],
						"fichier"			=> $donnees['fichier'],
						"pere"				=> $donnees['pere'],
						"mere"				=> $donnees['mere'],
						"date_naissance"	=> $donnees['date_naissance'],
						"date_deces"		=> $donnees['date_deces'],
						"cause_deces"		=> $donnees['cause_deces'],
						"user"				=> $donnees['user'],
						"couleur"			=> $donnees['couleur'],
						"dilution"			=> $donnees['dilution'],
						"marquage"			=> $donnees['marquage'],
						"oreilles"			=> $donnees['oreilles'],
						"poils"				=> $donnees['poils'],
						"yeux"				=> $donnees['yeux'],
						"portee"			=> $donnees['portee'],
						"repro"				=> $donnees['repro'],
						"repro_date"		=> $donnees['repro_date'],
						"commentaires"		=> $donnees['commentaires'],
						"date_ajout"		=> $donnees['date_ajout'],
						"date_user_view"	=> $donnees['date_user_view'],
						"date_last_edit"	=> $donnees['date_last_edit'],
						"sav_check"			=> $donnees['sav_check'],
						"etat"				=> $donnees['etat']
					);
				}
				break;
		}
		
		$req->closeCursor();
		
		return $datas;
	}
}

// Classe pour la gestion des rateries
class LORDRAT_MYSQL_RATERIES{
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
			case "base":
				$ins = $this->_bdd->prepare("
				INSERT INTO `rateries` (id_membre,affixe,nom,presentation,logo,status,on_map,date_ajout,date_last_edit)
				VALUES (:id_membre,:affixe,:nom,:presentation,:logo,:status,:on_map,:date_ajout,:date_last_edit)");
				$ins->execute($params);
				
				if($ins->rowCount())
				{
					$datas = "success";
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_INSERT_TABLE_FAILED);
				}
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	public function count()
	{
		$req = $this->_bdd->query("SELECT `id_raterie` FROM `rateries`");
		
		$datas = $req->rowCount();
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function del($params)
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
			case "base":
				if(!empty($params['id']))
				{
					$req = $this->_bdd->prepare("SELECT * FROM `rateries` WHERE `id_raterie` = :id_raterie");
					$req->execute(array("id_raterie" => $params['id']));
				}
				else if(!empty($params['affixe']))
				{
					$req = $this->_bdd->prepare("SELECT * FROM `rateries` WHERE `affixe` LIKE :affixe");
					$req->execute(array("affixe" => $params['affixe']));
				}
				else if(!empty($params['proprio']))
				{
					$req = $this->_bdd->prepare("SELECT * FROM `rateries` WHERE `id_membre` = :proprio");
					$req->execute(array("proprio" => $params['proprio']));
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				
				if(!isset($datas))
				{
					if($req->rowCount())
					{
						$donnees = $req->fetch();
						
						$datas = array();
						
						$datas[] = array(
							"id_raterie"		=> $donnees['id_raterie'],
							"id_membre"			=> $donnees['id_membre'],
							"affixe"			=> $donnees['affixe'],
							"nom"				=> $donnees['nom'],
							"presentation"		=> $donnees['presentation'],
							"logo"				=> $donnees['logo'],
							"status"			=> $donnees['status'],
							"on_map"			=> $donnees['on_map'],
							"date_ajout"		=> $donnees['date_ajout'],
							"date_user_view"	=> $donnees['date_user_view'],
							"date_last_edit"	=> $donnees['date_last_edit']
						);
					}
					else
					{
						$datas = array("error"	=> LORDRAT_ERROR_NO_RESULTS);
					}
				}
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_WRONG_CONTENT_SELECTION);
				break;
		}
		
		return $datas;
	}
	
	public function map()
	{
		function make_seed()
		{
		  list($usec, $sec) = explode(' ', microtime());
		  return (float) $sec + ((float) $usec * 100000);
		}

		srand(make_seed());
		
		$req = $this->_bdd->query("
		SELECT r.id_raterie id_raterie, r.affixe affixe, r.nom nom, ua.ville ville, ua.lat lat, ua.lng lng, us.url url
		FROM `rateries` r
		LEFT JOIN `users_adresses` ua ON ua.id_membre = r.id_membre
		LEFT JOIN `users_sites` us ON us.id_membre = r.id_membre
		WHERE r.on_map = 1
		ORDER BY r.id_raterie");
		
		$min = 2;
		$max = 20;
		
		$datas = array();
		
		while($donnees = $req->fetch())
		{
			if(empty($donnees['url']))
			{
				$url_site = NULL;
			}
			else if (!preg_match("~^(?:f|ht)tps?://~i", $donnees['url']))
			{
				$url_site = "https://" . $donnees['url'];
			}
			else
			{
				$url_site = $donnees['url'];
			}
			
			$datas[] = array(
				"id"		=> $donnees['id_raterie'],
				"lng"		=> $donnees['lng'] + rand($min,$max)/1000,
				"lat"		=> $donnees['lat'] + rand($min,$max)/1000,
				"affixe"	=> $donnees['affixe'],
				"nom"		=> $donnees['nom'],
				"ville"		=> $donnees['ville'],
				"url"		=> $url_site
			);
		}
		
		$req->closeCursor();
		
		return $datas;
	}
	
	public function save($params)
	{
		$upt = $this->_bdd->prepare("UPDATE `` SET `` WHERE ``");
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
	
	public function search($params)
	{
		$datas = NULL;
		
		switch($params['order'])
		{
			case "affixe":
				$req = $this->_bdd->prepare("SELECT * FROM `rateries` ORDER BY `affixe` LIMIT :quantity OFFSET :start");
				break;
			case "!affixe":
				$req = $this->_bdd->prepare("SELECT * FROM `rateries` ORDER BY `affixe` DESC LIMIT :quantity OFFSET :start");
				break;
			case "nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rateries` ORDER BY `nom` LIMIT :quantity OFFSET :start");
				break;
			case "!nom":
				$req = $this->_bdd->prepare("SELECT * FROM `rateries` ORDER BY `nom` DESC LIMIT :quantity OFFSET :start");
				break;
			case "proprio":
				$req = $this->_bdd->prepare("SELECT * FROM `rateries` ORDER BY `id_membre` LIMIT :quantity OFFSET :start");
				break;
			case "!proprio":
				$req = $this->_bdd->prepare("SELECT * FROM `rateries` ORDER BY `id_membre` DESC LIMIT :quantity OFFSET :start");
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		if($datas == NULL)
		{
			$req->bindValue(':quantity', (int) $params['quantity'], PDO::PARAM_INT); 
			$req->bindValue(':start', (int) $params['start'], PDO::PARAM_INT);
			$req->execute();

			switch(TRUE)
			{
				case $req->rowCount() == 0:
					$datas = array("error" => LORDRAT_ERROR_NO_RESULTS);
					break;
				default:
					switch($params['content'])
					{
						case "full":
							$datas = array();
							while($donnees = $req->fetch())
							{
								$datas[] = array(
									"id_raterie"		=> $donnees['id_raterie'],
									"id_membre"			=> $donnees['id_membre'],
									"affixe"			=> $donnees['affixe'],
									"nom"				=> $donnees['nom'],
									"presentation"		=> $donnees['presentation'],
									"logo"				=> $donnees['logo'],
									"status"			=> $donnees['status'],
									"on_map"			=> $donnees['on_map'],
									"date_ajout"		=> $donnees['date_ajout'],
									"date_user_view"	=> $donnees['date_user_view'],
									"date_last_edit"	=> $donnees['date_last_edit']
								);
							}
							break;
						case "list":
							$datas = array();
							while($donnees = $req->fetch())
							{

								$datas[] = array(
									"id_raterie"		=> $donnees['id_raterie'],
									"id_membre"			=> $donnees['id_membre'],
									"affixe"			=> $donnees['affixe'],
									"nom"				=> $donnees['nom'],
									"status"			=> $donnees['status'],
									"on_map"			=> $donnees['on_map']
								);
							}
							break;
						case "menu":
							$datas = array();
							while($donnees = $req->fetch())
							{

								$datas[] = array(
									"id_raterie"		=> $donnees['id_raterie'],
									"affixe"			=> $donnees['affixe'],
									"nom"				=> $donnees['nom']
								);
							}
							break;
						default:
							$datas = array("error" => LORDRAT_ERROR_WRONG_CONTENT_SELECTION);
							break;
					}
					break;
			}

			$req->closeCursor();
		}
		
		return $datas;
	}
	
	public function toggleMap($id)
	{
		$req = $this->_bdd->prepare("SELECT `on_map` FROM `rateries` WHERE `id_raterie` = :id");
		$req->execute(array("id" => $id));
		
		if($req->rowCount())
		{
			$donnees = $req->fetch();
			
			if($donnees['on_map'])
			{
				$upt = $this->_bdd->prepare("UPDATE `rateries` SET `on_map` = FALSE WHERE `id_raterie` = :id");
			}
			else
			{
				$upt = $this->_bdd->prepare("UPDATE `rateries` SET `on_map` = TRUE WHERE `id_raterie` = :id");
			}
			
			$upt->execute(array("id" => $id));
			
			if($upt->rowCount())
			{
				$datas = "success";
			}
			else
			{
				$datas = array('error' => LORDRAT_ERROR_UPDATE_NO_CHANGE);
			}
			
			$upt->closeCursor();
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_INEXISTENT_ITEM);
		}
		
		$req->closeCursor();
		
		return $datas;
	}
}

// Classe pour la gestion de la messagerie SAV
class LORDRAT_MYSQL_SAV{
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
	
	public function addMsg($section,$params)
	{
		switch($section)
		{
			case "rat":
				$datas = $this->addRatMsg($params);
				break;
			default:
				$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function addRatMsg($params)
	{
		$ins = $this->_bdd->prepare("INSERT INTO `sav_messagerie_rat` (`rat`,`user`,`message`,`date_sent`) VALUE(:rat,:user,:message,:date_sent)");
		$ins->execute(array(
			'rat'		=> $params['rat'],
			'user'		=> $params['user'],
			'message'	=> $params['message'],
			'date_sent'	=> time()
		));
		
		if($ins->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_INSERT_TABLE_FAILED);
		}
		
		$ins->closeCursor();
		
		return $datas;
	}
	
	public function searchMsg($section,$params)
	{
		switch($section)
		{
			case "rat":
				$datas = $this->searchRatMsg($params);
				break;
			default:
				$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function searchRatMsg($params)
	{
		$base = "
		SELECT smr.id id, smr.rat rat, smr.user id_membre, u.pseudo pseudo, u.level level, smr.message message, smr.date_sent date_sent, smr.date_read date_read
		FROM `sav_messagerie_rat` smr
		LEFT JOIN `users` u ON u.id_membre = smr.user";
		
		$select = "";
		
		$query_params = NULL;
		
		if(!is_null($params['rat']))
		{
			if(empty($select))
			{
				$query_params = array();
				$select = " WHERE smr.rat = :rat";
			}
			else
			{
				$select .= " AND smr.rat > :rat";
			}
			
			$query_params['rat'] = $params['rat'];
		}
		
		if(!is_null($params['user']))
		{
			if(empty($select))
			{
				$query_params = array();
				$select = " WHERE smr.user = :user";
			}
			else
			{
				$select .= " AND smr.user > :user";
			}
			
			$query_params['user'] = $params['user'];
		}
		
		if($params['recent'])
		{
			if(empty($select))
			{
				$query_params = array();
				$select = " WHERE smr.date_sent > :date_start";
			}
			else
			{
				$select .= " AND smr.date_sent > :date_start";
			}
			
			$query_params['date_start'] = time() - (3600 * 24 * 15);
		}
		
		$order = " ORDER BY smr.date_sent DESC";
		
		$query = $base.$select.$order;
		
		error_log("params : ".print_r($query_params,TRUE)." - query : ".print_r($query,TRUE));
		
		$req = $this->_bdd->prepare($query);
		$req->execute($query_params);
		
		if($req->rowCount())
		{
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$datas[] = array(
					'id'		=> $donnees['id'],
					'rat'		=> $donnees['rat'],
					'user'		=> array(
						'id_membre'	=> $donnees['id_membre'],
						'level'		=> $donnees['level'],
						'pseudo'	=> $donnees['pseudo']
					),
					'message'	=> nl2br($donnees['message']),
					'date_sent'	=> array(
						'raw'		=> $donnees['date_sent'],
						'string'	=> date('d/m/Y à H:i',$donnees['date_sent'])
					),
					'date_read'	=> array(
						'raw'		=> $donnees['date_read'],
						'string'	=> date('d/m/Y à H:i',$donnees['date_read'])
					)
				);
			}
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_NO_RESULTS);
		}
		
		return $datas;
	}
	
	public function status($section,$params)
	{
		switch($section)
		{
			case "rat":
				$datas = $this->statusRat($params);
				break;
			default:
				$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function statusRat($params)
	{
		if($params['status'])
		{
			$upt = $this->_bdd->prepare("UPDATE `rats` SET `etat` = 1 WHERE `id` = :rat");
		}
		else
		{
			$upt = $this->_bdd->prepare("UPDATE `rats` SET `etat` = 2 WHERE `id` = :rat");
		}
		
		$upt->execute(array('rat' => $params['rat']));
		
		if($upt->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_UPDATE_NO_CHANGE);
		}
		
		return $datas;
	}
}

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

// Calsse pour les statistiques et les graphs
class LORDRAT_MYSQL_STATS{
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
	
	private function count($table,$colonne = NULL,$value = NULL)
	{
		if($colonne == NULL)
		{
			switch($table)
			{
				case "users":
					$req = $this->_bdd->query("SELECT * FROM `users`");
					break;
				case "portees":
					$req = $this->_bdd->query("SELECT * FROM `rats_portees`");
					break;
				case "rateries":
					$req = $this->_bdd->query("SELECT * FROM `rateries`");
					break;
				case "rats":
					$req = $this->_bdd->query("SELECT * FROM `rats`");
					break;
				default :
					$count = -1;
					break;
			}

			if(!isset($count))
			{
				$count = $req->rowCount();

				$req->closeCursor();
			}
		}
		else
		{
			switch($table)
			{
				case "rats":
					$cols = array("sexe");
					if(in_array($colonne,$cols))
					{
						$req = $this->_bdd->prepare("SELECT `id` FROM `rats` WHERE `sexe` = :value");
						$req->execute(array("value" => $value));
					}
					else
					{
						$count = -1;
					}
					break;
				default:
					$count = -1;
					break;
			}
			
			if(!isset($count))
			{
				$count = $req->rowCount();

				$req->closeCursor();
			}
		}
		
		return $count;
	}
	
	private function deces($sexe = "A")
	{
		switch($sexe)
		{
			case "F":
				$req = $this->_bdd->query("SELECT * FROM `rats` WHERE `sexe` = 'F'");
				break;
			case "M":
				$req = $this->_bdd->query("SELECT * FROM `rats` WHERE `sexe` = 'M'");
				break;
			default:
				$req = $this->_bdd->query("SELECT * FROM `rats`");
				break;
		}
		
		$count = 0;
		$total = 0;
		
		while($donnees = $req->fetch())
		{
			if($donnees['date_naissance'] != 0 AND $donnees['date_deces'] != 0)
			{
				$duree = $donnees['date_deces'] - $donnees['date_naissance'];
				
				// Ne prend pas en compte les rats décédés avant 4 mois et apres 5 ans
				if($duree > (3600 * 24 * 31 * 4) AND $duree < (3600 * 24 * 365 * 5))
				{
					$total += $duree;
					$count++;
				}
			}
		}
		
		$moyenne = number_format(($total / $count)/(3600 * 24 * 31),0);
		
		return $moyenne;
	}
	
	public function get($section,$params = array())
	{
		switch($section)
		{
			case "base":
				$datas = array(
					"count"	=> array(
						"membres"	=> $this->count("users"),
						"portees"	=> $this->count("portees"),
						"rateries"	=> $this->count("rateries"),
						"rats"		=> $this->count("rats")
					),
					"graphs"	=> array(
						"causes_deces" => array(
							"top10"	=> $this->getTopCausesDeces(10)
						)
					),
					"moyennes" => array(
						"deces"	=> array(
							"M"	=> $this->deces("M"),
							"F"	=> $this->deces("F"),
							"A"	=> $this->deces("A")
						),
						"portees" => array(
							"nb_petits"	=> $this->portees()
						)
					),
					"ratio"	=> array(
						"rats"	=> array(
							"sexe"	=> $this->ratios("rats","sexe")
						)
					)
				);
				break;
			default:
				$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function getTopCausesDeces($nbr)
	{
		// Id des causes de dèces ignorées dans le graphique
		$ignored = array(8,59);
		
		$req = $this->_bdd->query("SELECT * FROM `rats` WHERE `cause_deces` <> 0");
		
		$datas = array();
		$count = 0;
		
		while($donnees = $req->fetch())
		{
			if(! isset($datas[$donnees['cause_deces']]))
			{
				$datas[$donnees['cause_deces']] = 0;
			}
			else
			{
				$datas[$donnees['cause_deces']]++;
			}
			$count++; // Semble inutile
		}
		
		// Tri du tableau
		arsort($datas);
		
		$labels = array();
		$data = array();
		
		$count_entry = 0;
		
		foreach($datas as $key => $value)
		{
			if(!in_array($key,$ignored))
			{
				if($count_entry < $nbr)
				{
					$req = $this->_bdd->prepare("SELECT * FROM `rats_causes_deces` WHERE `id` = :id");
					$req->execute(array("id" => $key));
					$donnees = $req->fetch();
					$req->closeCursor();
					$labels[] = json_decode($donnees['nom'])->FR;
					$data[] = $value;
				}

				$count_entry++;
			}
		}
		
		return array(
			"labels"	=> $labels,
			"datasets"	=> array(
				array(
					"label"				=> "Les 10 Principales Causes de Dèces",
					"data"				=> $data,
					"backgroundColor"	=> "rgba(204, 137, 108, 0.6)", 
					"borderColor"		=> "rgba(204, 137, 108, 1)",
					"borderWitdh"		=> 1
				)
			)
		);
	}
	
	private function portees()
	{
		$req = $this->_bdd->query("SELECT * FROM `rats_portees` WHERE `nombres_petits` <> 0");
		
		$total = 0;
		$count = 0;
		
		while($donnees = $req->fetch())
		{
			$total += $donnees['nombres_petits'];
			$count++;
		}
		
		return number_format($total/$count,0);
	}
	
	private function ratios($table,$colonne)
	{
		switch($table)
		{
			case "rats":
				$table_name = "rats";
				switch($colonne)
				{
					case "sexe":
						$colonne_name = "sexe";
						break;
				}
				break;
		}
		
		if(isset($table_name) AND isset($colonne_name))
		{
			$req = $this->_bdd->query("SELECT * FROM ".$table_name." GROUP BY ".$colonne_name);
			
			$fields = array();
			
			while($donnees = $req->fetch())
			{
				$fields[$donnees[$colonne_name]] = round($this->count($table_name,$colonne_name,$donnees[$colonne_name]) * 100 / $this->count($table_name),2);
			}
		}
	
		return $fields;
	}
}

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

