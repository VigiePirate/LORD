<?php

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