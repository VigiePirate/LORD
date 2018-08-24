<?php

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
