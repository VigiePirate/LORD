<?php

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