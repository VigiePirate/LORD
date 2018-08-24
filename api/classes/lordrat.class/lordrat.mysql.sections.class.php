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