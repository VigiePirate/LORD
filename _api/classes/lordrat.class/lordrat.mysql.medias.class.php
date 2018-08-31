<?php

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
