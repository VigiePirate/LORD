<?php

class LORDRAT_SYNC{
	private $_db_v1 = NULL;
	private $_api_v2 = NULL;
	private $_geoname = NULL;
	
	private $_verbose = NULL;
	
	private $_events = array();
	
	private $_flag = TRUE;
	
	public function __construct($db_v1,$api_v2,$geoname,$verbose = FALSE)
	{
		if($db_v1 instanceof PDO AND $api_v2 instanceof LORDRAT_API AND $geoname instanceof GEONAMES_API)
		{
			$this->_db_v1 = $db_v1;
			$this->_api_v2 = $api_v2;
			$this->_geoname = $geoname;
			$this->_verbose = $verbose;
		}
		else
		{
			throw new Exception("Invalid parameters !\n");
		}
	}
	
	  /////////////////////////////////////////////////////////////////////////////
	 //	Gestion des utilisateurs												//
	/////////////////////////////////////////////////////////////////////////////
	
	// Permet la réccupération du nouvel id de l'utilisateur via son ancien id. Renvoi 0 si aucun utilisateur ne correspond.
	private function checkUser($old_id)
	{
		$params = array(
			"old_id"	=> $old_id
		);
		
		$result = $this->_api_v2->getUtilisateur("base",$params);
		
		if(is_array($result->response->datas) AND count($result->response->datas) == 1)	
		{
			$new_id = $result->response->datas[0]->id_membre;
		}
		else
		{
			$new_id = 0;
		}

		return $new_id;
	}
	
	private function getCityCoordonates($city_infos)
	{
		if($city_infos['geoname'] != FALSE)
		{
			$datas = $this->_geoname->get($city_infos['geoname']);
			
			if(is_array($datas->response->datas) AND count($datas->response->datas) == 1)
			{
				$result = array(
					"geoname"	=> $datas->response->datas[0]->id,
					"ville"		=> $datas->response->datas[0]->ville,
					"cp"		=> $datas->response->datas[0]->cp,
					"pays"		=> $datas->response->datas[0]->pays,
					"lat"		=> $datas->response->datas[0]->lat,
					"lng"		=> $datas->response->datas[0]->lng
				);
			}
			else
			{
				$result = FALSE;
			}
		}
		else
		{
			// Première phase, recherche par pays et code poste, si résultat unique on valide
			$result = $this->getGeonamesInfos($city_infos);

			// Seconde phase, on recherche avec le nom de la ville
			if($result == FALSE)
			{
				$result = $this->getGeonamesInfos($city_infos,"full");
			}

			// Troisème phase, on recherche avec un portion du nom de la ville
			if($result == FALSE)
			{
				$result = $this->getGeonamesInfos($city_infos,"partial");
			}
		}
		
		return $result;
		//echo $city_infos['ville']." - ".$city_infos['cp']." - ".$city_infos['pays']." ";
	}
	
	private function getGeonamesInfos($params,$query_type = "cp",$retry = FALSE)
	{
		// Nettoyage du nom de la ville
		$ville = trim($params['ville']); // Suppression des espace en début et fin de chaine
		$ville = remove_accent($ville); // On enlève les accents
		$ville = remove_abreviations($ville); // On supprimer les abreviations
		$ville = strtoupper($ville); // On passe la chaine de caractère en majuscules
		
		switch($query_type)
		{
			case "cp":
				$params_query = array(
					"cp"	=> $params['cp'],
					"pays"	=> $params['pays']
				);
				break;
			case "full":
				if($retry)
				{
					$params_query = array(
						"ville"	=> str_replace("-", " ", $ville),
						"cp"	=> $params['cp'],
						"pays"	=> $params['pays'],
					);
				}
				else
				{
					$params_query = array(
						"ville"	=> $ville,
						"cp"	=> $params['cp'],
						"pays"	=> $params['pays'],
					);
				}
				break;
			case "partial":
				if($retry)
				{
					$params_query = array(
						"ville"	=> substr($ville,0,3),
						"cp"	=> $params['cp'],
						"pays"	=> $params['pays']
					);
				}
				else
				{
					$params_query = array(
						"ville"	=> substr($ville,0,5),
						"cp"	=> $params['cp'],
						"pays"	=> $params['pays']
					);
				}
				break;
		}
		
		$result = $this->_geoname->search($params_query);
		
		// Un seul résultat
		if(is_array($result->response->datas) AND count($result->response->datas) == 1)
		{
			$return = array(
				"geoname"	=> $result->response->datas[0]->id,
				"ville"		=> $result->response->datas[0]->ville,
				"cp"		=> $result->response->datas[0]->cp,
				"pays"		=> $result->response->datas[0]->pays,
				"lat"		=> $result->response->datas[0]->lat,
				"lng"		=> $result->response->datas[0]->lng
			);
		}
		else
		{
			if($retry == FALSE AND $query_type != "cp")
			{
				$return = $this->getGeonamesInfos($params,$query_type,TRUE);
			}
			else
			{
				$return = FALSE;
			}
		}
		
		return $return;
	}
	
	private function getUserID($email)
	{
		$datas = $this->_api_v2->getUtilisateur("base",array("email" => $email))->response->datas;
		
		if(is_array($datas) AND count($datas) == 1)	
		{
			$new_id = $datas[0]->id_membre;
		}
		else
		{
			$new_id = 0;
			
			$this->_flag = FALSE;
		}

		return $new_id;
	}
	
	private function insertUserAdresse($new_id,$adresse,$cp,$ville,$pays,$geoname,$lat,$lng)
	{
		$params = array(
			"id_membre"	=> $new_id,
			"adresse"	=> $adresse,
			"cp"		=> $cp,
			"ville"		=> $ville,
			"pays"		=> $pays,
			"geoname"	=> $geoname,
			"lat"		=> $lat,
			"lng"		=> $lng
		);
		
		$result = $this->_api_v2->addUser('adresse',$params);
		
		if($result->response->datas == "success")
		{
			if($this->_verbose)
			{
				echo " Insertion adresse OK ... ";
			}
		}
		else
		{
			if($this->_verbose)
			{
				echo " Insertion adresse Echec ... \n";
				
				print_r($params);
				
				echo "\n";
				
				print_r($result);
			}
			$this->_flag = FALSE;
		}
	}
	
	private function insertUserNom($new_id,$civilite,$prenom,$nom)
	{
		switch(strtolower($civilite))
		{
			case "m.":
				$civilite = 1;
				break;
			case "mlle":
				$civilite = 3;
				break;
			case "mme":
				$civilite = 2;
				break;
			default:
				$civilite = 0;
				break;
		}
		
		$params = array(
			"id_membre"	=> $new_id,
			"civilite"	=> $civilite,
			"prenom"	=> $prenom,
			"nom"		=> $nom
		);
		
		$result = $this->_api_v2->addUser('nom',$params);
				
		if($result->response->datas == "success")
		{
			if($this->_verbose)
			{
				echo " Insertion nom OK ... ";
			}
		}
		else
		{
			if($this->_verbose)
			{
				echo " Insertion nom Echec ... ";
				
				print_r($result);
			}
			$this->_flag = FALSE;
		}
	}
	
	private function insertUserSite($new_id,$nom,$url)
	{
		$params = array(
			"id_membre"		=> $new_id,
			"nom"			=> $nom,
			"url"			=> $url
		);
		
		$result = $this->_api_v2->addUser('site',$params);
				
		if($result->response->datas == "success")
		{
			if($this->_verbose)
			{
				echo " Insertion site OK ... ";
			}
		}
		else
		{
			if($this->_verbose)
			{
				echo " Insertion site Echec ... ";
				
				print_r($result);
			}
			$this->_flag = FALSE;
		}
	}
	
	private function migrateUser($old_id,$new_id)
	{
		$req = $this->_db_v1->prepare("SELECT * FROM `peel_utilisateurs` WHERE `id_utilisateur` = :old_id");
		$req->execute(array("old_id" => $old_id));
		
		if($req->rowCount())
		{
			$donnees = $req->fetch();
			
			// Validations des données de l'utilisateur
			$email = $this->validatePeelUtilisateursEmail($donnees['email'],$old_id);
			$level = $this->validatePeelUtilisateursPseudo($donnees['pseudo']);
			
			if(strtotime($donnees['date_insert']) < 0)
			{
				$date_inscription = 0;
			}
			else
			{
				$date_inscription = strtotime($donnees['date_insert']);
			}

			if(strtotime($donnees['date_update']) < 0)
			{
				$date_maj = 0;
			}
			else
			{
				$date_maj = strtotime($donnees['date_update']);
			}
			
			if(strtotime($donnees['naissance']) < 0)
			{
				$date_naissance = 0;
			}
			else
			{
				$date_naissance = strtotime($donnees['naissance']);
			}
			
			// Ajout des informations dans la table users
			if($this->_flag)
			{
				echo "User can be inserted ...";
				
				$params = array(
					"id_membre"			=> $new_id,
					"old_id"			=> $old_id,
					"email"				=> $email,
					"mdp"				=> $donnees['mot_passe'],
					"pseudo"			=> $donnees['pseudo'],
					"level"				=> $level,
					"presentation"		=> $donnees['description'],
					"date_naissance"	=> $date_naissance,
					"date_inscription"	=> $date_inscription,
					"date_maj"			=> $date_maj
				);
				
				switch($new_id)
				{
					case 0:	// Ajout
						$result = $this->_api_v2->addUser('base',$params);
				
						if($result->response->datas == "success")
						{
							if($this->_verbose)
							{
								echo " Insertion base OK ... ";
							}
						}
						else
						{
							if($this->_verbose)
							{
								echo " Insertion base Echec ... ";

								print_r($result);
							}
							$this->_flag = FALSE;
						}
						break;
					default: // MAJ
						$result = $this->_api_v2->saveUser('base',$params);
				
						if($result->response->datas == "success")
						{
							if($this->_verbose)
							{
								echo " MAJ base OK ... ";
							}
						}
						else
						{
							if($this->_verbose)
							{
								echo " MAJ base Echec ... ";

								print_r($result);
							}
							$this->_flag = FALSE;
						}
						break;
				}
				
			}
			
			// Réccupération du nouvel indentifiant de l'utilisateur
			if($this->_flag)
			{
				$new_id = $this->getUserID($email);
				if($this->_verbose)
				{
					echo "New ID : ".$new_id." ... ";
				}	
			}
			
			if($this->_flag)
			{
				if(!empty($donnees['prenom']) AND !empty($donnees['nom_famille']))
				
					$this->insertUserNom($new_id, $donnees['civilite'], $donnees['prenom'], $donnees['nom_famille']);
				}
			}
			
			if($this->_flag)
			{
				if(!empty($donnees['url']))
				{
					$this->insertUserSite($new_id, "", $donnees['url']);
				}
			}
			
			if($this->_flag)
			{
				if(!empty($donnees['ville']) AND !empty($donnees['code_postal']))
				{
					// Purification des données de la BDD
					
					
					$city_infos = $this->validatePeelUtilisateursCityInformations($old_id,$donnees['ville'],$donnees['code_postal'],$donnees['pays']);

					if($city_infos == FALSE)
					{
						if($this->_verbose)
						{
							echo "Adresse ignorée pour cet utilisateur ";
						}
					}
					else
					{
						// Réccupération latitude et longitude depuis geonames
						$full_infos = $this->getCityCoordonates($city_infos);
						
						if($full_infos == FALSE)
						{
							if($this->_verbose)
							{
								echo "Impossible de résoudre dans Geonames ";

								print_r($city_infos);
							}
							
							$this->_events[] = array(
								"id"		=> "insert_address",
								"type"		=> "warning",
								"details"	=> "Impossible de résoudre dans Geonames pour utilisateur ".$old_id
							);
							
							$this->insertUserAdresse($new_id,$donnees['adresse'],$city_infos['cp'],$city_infos['ville'],$city_infos['pays'],0,0,0);
						}
						else
						{
							$this->insertUserAdresse($new_id,$donnees['adresse'],$full_infos['cp'],$full_infos['ville'],$full_infos['pays'],$full_infos['geoname'],$full_infos['lat'],$full_infos['lng']);
						}
					}
				}
			}
		}
		else
		{
			$this->_events[] = array(
				"id"		=> "get_old_user",
				"type"		=> "error",
				"details"	=> "No user found with this ID (".$old_id.") in `peel_utilisateurs`"
			);
			$this->_flag = FALSE;
		}
		
		$req->closeCursor();
		//echo "No Migrate process operationnal";
	}
	
	// Gère la synchronisation des utilisateurs
	public function syncMembres()
	{
		// Réccupération de la liste des utilisateurs
		$req = $this->_db_v1->query("SELECT `id_utilisateur` FROM `peel_utilisateurs` ORDER BY `id_utilisateur` "/*LIMIT 1000 OFFSET 2180"*/);
		
		// On parcours la liste des utilisateurs
		while($donnees = $req->fetch())
		{
			//Tant que le flag est à TRUE on continue l'execution du script
			if($this->_flag)
			{
				// Réccupération de l'ancien identifiant d'utilisateur
				$old_id =  $donnees['id_utilisateur'];

				if($this->_verbose)
				{
					echo "Utilisateur ".$old_id." : ";
				}

				// On vérifie si l'utilisateur existe dans la nouvelle table
				$new_id = $this->checkUser($old_id);
				
				// On lance la migration
				$this->migrateUser($old_id,$new_id);
				
				/*switch($new_id)
				{
					case 0:		// Nouvel utilisateur
						if($this->_verbose)
						{
							echo "New User ... ";
						}

						$this->migrateUser($old_id);
						break;
					default:	// Utilisateur deja existant
						if($this->_verbose)
						{
							echo "To Sync ... ";
						}

						$this->syncUser($old_id);
						break;
				}*/

				// Retour à la ligne pour faire propre
				if($this->_verbose)
				{
					echo "\n";
				}
			}
		}
		
		// Fermuture du pointeur PDO
		$req->closeCursor();
	}
	
	private function validatePeelUtilisateursCityInformations($old_id,$ville,$cp,$pays)
	{
		$flag = TRUE;
		
		$geoname = FALSE;
		
		switch($pays) // Conversion des id pays (si rensignés)
		{
			case 1: case 127: case 239:
				$id_pays = 'FR';
				break;
			case 240:
				$id_pays = 'BE';
				break;
			case 241:
				$id_pays = 'CH';
				break;
			default:
				$id_pays = 'FR';
				break;
		}

		// Correction manuelle des erreurs de saisie
		switch($old_id)
		{
			case 11:
				$cp = '59140';
				break;
			case 19:
				$cp = '02330';
				break;
			case 20:				// Champs bidons dans ancienne version du LORD
				$flag = FALSE;
				break;
			case 21:				// Champs bidons dans ancienne version du LORD
				$flag = FALSE;
				break;
			case 54:				// Champs bidons dans ancienne version du LORD
				$flag = FALSE;
				break;
			case 55:
				$ville = "OZOIR LA FERRIERE";
				break;
			case 73:				// Suisse
				$id_pays = 'CH';
				break;
			case 104:				// Belgique
				$id_pays = 'BE';
				break;
			case 132:
				$cp = 57250;
				break;
			case 194:				// Belgique
				$id_pays = 'BE';
				break;
			case 195:
				$cp = 95000;
				break;
			case 204:				// Suisse
				$id_pays = 'CH';
				break;
			case 205:				// Belgique
				$id_pays = 'BE';
				break;
			case 211:				// Belgique
				$id_pays = 'BE';
				break;
			case 235:				// Suisse
				$id_pays = 'CH';
				break;
			case 240:				// Belgique
				$id_pays = 'BE';
				break;
			case 244:				// Belgique
				$id_pays = 'BE';
				break;
			case 245:
				$ville = "TALUYERS";
				break;
			case 247:				// Suisse
				$id_pays = 'CH';
				break;
			case 265:
				$cp = 75016;
				break;
			case 285:				// Suisse
				$id_pays = 'CH';
				break;
			case 293:				// Suisse
				$id_pays = 'CH';
				break;
			case 308:				// Suisse
				$id_pays = 'CH';
				break;
			case 316:
				$cp = 28000;
				break;
			case 323:				// Champs bidons dans ancienne version du LORD
				$flag = FALSE;
				break;
			case 343:				// Belgique
				$id_pays = 'BE';
				break;
			case 345:				// Belgique
				$id_pays = 'BE';
				break;
			case 361:				// Belgique
				$id_pays = 'BE';
				break;
			case 362: 				// Belgique
				$id_pays = 'BE';
				break;
			case 443:				// Belgique
				$id_pays = 'BE';
				break;
			case 444:
				$ville = "LE PETIT QUEVILLY";
				break;
			case 452:				// Belgique
				$id_pays = 'BE';
				break;
			case 476:				// Belgique
				$id_pays = 'BE';
				break;
			case 486:
				$geoname = 218713;
				break;
			case 489:				// Belgique
				$id_pays = 'BE';
				break;
			case 490: 				// Belgique
				$id_pays = 'BE';
				break;
			case 500:		// Code postal espagnol ne correspondant pas à la ville dans Geonames
				$id_pays = 'ES';
				$cp = 8001;
				break;
			case 526:
				$cp = 6000;
				break;
			case 534:
				$cp = 3200;
				break;
			case 572: 				// Belgique
				$id_pays = 'BE';
				break;
			case 574:				// Suisse
				$id_pays = 'CH';
				break;
			case 576:				// Suisse
				$id_pays = 'CH';
				break;
			case 577:				// Suisse
				$id_pays = 'CH';
				break;
			case 585: 				// Suisse
				$id_pays = 'CH';
				break;
			case 586: 				// Belgique
				$id_pays = 'BE';
				break;
			case 587:				// Suisse
				$id_pays = 'CH';
				break;
			case 588: 				// Belgique
				$geoname = 60654;
				break;
			case 597:				// Suisse
				$id_pays = 'CH';
				break;
			case 609:				// Suisse
				$id_pays = 'CH';
				break;
			case 611:				// Belgique
				$id_pays = 'BE';
				break;
			case 614:
				$geoname = 183350;
				break;
			case 627:				// Suisse
				$id_pays = 'CH';
				break;
			case 667:
				$id_pays = 'BE';
				$ville = 'Léglise';
				break;
			case 702:
				$ville = "CALUIRE ET CUIRE";
				break;
			case 722:				// Suisse
				$id_pays = 'CH';
				break;
			case 729: 				// Belgique
				$id_pays = 'BE';
				break;
			case 730: 				// Belgique
				$id_pays = 'BE';
				break;
			case 738:				// Suisse
				$id_pays = 'CH';
				break;
			case 806:				// Belgique
				$id_pays = 'BE';
				$ville = "Dison";
				break;
			case 849:				// Suisse
				$id_pays = 'CH';
				break;
			case 873:				// Belgique
				$cp = 5030;
				$id_pays = 'BE';
				break;
			case 887:
				$geoname = 171239;
				break;
			case 957:				// Belgique
				$ville = "Koekelberg";
				$id_pays = 'BE';
				break;
			case 980:				// Belgique
				$id_pays = 'BE';
				break;
			case 991:				// Belgique
				$id_pays = 'BE';
				break;
			case 1007:				// Belgique
				$id_pays = 'BE';
				break;
			case 1008:				// Belgique
				$id_pays = 'BE';
				break;
			case 1022:				// Belgique
				$id_pays = 'BE';
				break;
			case 1043:				// Belgique
				$id_pays = 'BE';
				break; 
			case 1045:				// Belgique
				$id_pays = 'BE';
				break;
			case 1054:				// Belgique
				$id_pays = 'BE';
				break;
			case 1055:				// Suisse
				$ville = "genève";
				$id_pays = 'CH';
				break;
			case 1058:				// Belgique
				$id_pays = 'BE';
				break;
			case 1087:				// Belgique
				$id_pays = 'BE';
				break;
			case 1136:				// Belgique
				$id_pays = 'BE';
				break;
			case 1163:				// Suisse
				$id_pays = 'CH';
				break;
			case 1177:
				$ville = "ROQUEFORT LA BEDOULE";
				break;
			case 1210:				// Belgique
				$id_pays = 'BE';
				break;
			case 1254:
				$ville = "Le Perreux-sur-Marne";
				break;
			case 1264:				// Belgique
				$id_pays = 'BE';
				break;
			case 1277:
				$cp = '60690';
				break;
			case 1310:				// Suisse
				$id_pays = 'CH';
				break;
			case 1322:				// Belgique
				$id_pays = 'BE';
				break;
			case 1324:
				$geoname = 213508;
				break;
			case 1331:				// France
				$cp = '02100';
				break;
			case 1358:
				$ville = "LE GRAND QUEVILLY";
				break;
			case 1371:
				$ville = "Morlanwelz";
				$id_pays = 'BE';
				break;
			case 1399:				// Belgique
				$id_pays = 'BE';
				break;
			case 1405:				// Suisse
				$id_pays = 'CH';
				break;
			case 1413:				// Belgique
				$id_pays = 'BE';
				break;
			case 1439:
				$ville = "Château-Larcher";
				break;
			case 1465:				// Belgique
				$id_pays = 'BE';
				$ville = "Tilff";
				break;
			case 1498:				// France
				$geoname = 185281;
				break;
			case 1503:				// Belgique
				$id_pays = 'BE';
				break; 
			case 1513:				// Suisse
				$id_pays = 'CH';
				break;
			case 1515:				// Suisse
				$id_pays = 'CH';
				break;
			case 1525:				// Belgique
				$id_pays = 'BE';
				break;
			case 1526:				// Belgique
				$id_pays = 'BE';
				break;
			case 1527:				// Belgique
				$id_pays = 'BE';
				break;
			case 1560:				// Champs bidons ancienne version LORD
				$flag = FALSE;
				break;
			case 1562:				// Suisse
				$id_pays = 'CH';
				$ville = "vernier";
				break;
			case 1613:				// Belgique
				$id_pays = 'BE';
				break; 
			case 1614:				// Belgique
				$id_pays = 'BE';
				break;
			case 1619:				// Belgique
				$id_pays = 'BE';
				break;
			case 1622:				// Belgique
				$id_pays = 'BE';
				$ville = "Bellevaux-Ligneuville";
				break;
			case 1624:				// Belgique
				$id_pays = 'BE';
				break;
			case 1626:				// Belgique
				$id_pays = 'BE';
				break;
			case 1634:
				$id_pays = 'BE';
				break;
			case 1638:
				$geoname = 216214;
				break;
			case 1644:				// Belgique
				$id_pays = 'BE';
				break;
			case 1702:				// Belgique
				$id_pays = 'BE';
				break;
			case 1709:				// Suisse
				$id_pays = 'CH';
				break;
			case 1719:				// Champs Bidons ancienne version LORD
				$flag = FALSE;
				break;
			case 1741:				// Belgique
				$ville = "Liège";
				$id_pays = 'BE';
				break;
			case 1747:
				$ville = "Saint-Jean-de-la-Motte";
				break;
			case 1763:
				$ville = "Bruz";
				break;
			case 1806:
				$ville = "LE KREMLIN BICETRE";
				break;
			case 1835:				// Belgique
				$id_pays = 'BE';
				break;
			case 1866:
				$cp = 13090;
				break;
			case 1878:
				$cp = '07200';
				break;
			case 1893:				// Suisse
				$id_pays = 'CH';
				break;
			case 1900:
				$ville = "Bressuire";
				break;
			case 1906:				// Belgique
				$id_pays = 'BE';
				break;
			case 1914:				// Belgique
				$id_pays = 'BE';
				break;
			case 1933:				// Belgique
				$id_pays = 'BE';
				$ville = "Koekelberg";
				break;
			case 1935:				// Suisse
				$id_pays = 'CH';
				break;
			case 1944:				// Belgique
				$id_pays = 'BE';
				break;
			case 1947:
				$ville = "BAILLY ROMAINVILLIERS";
				break;
			case 1948:				// Belgique
				$id_pays = 'BE';
				break;
			case 1951:				// Belgique
				$id_pays = 'BE';
				break;
			case 1958:				// Belgique
				$id_pays = 'BE';
				break;
			case 1969:
				$cp = '08000';
				break;
			case 1970:
				$ville = "Saint-Étienne-du-Rouvray";
				break;
			case 1971:				// Belgique
				$id_pays = 'BE';
				break;
			case 1973:
				$ville = "Saint-Crespin-sur-Moine";
				break;
			case 1978:				// Belgique
				$id_pays = 'BE';
				$ville = "Sint-Pieters-Leeuw";
				break;
			case 1997:				// Belgique
				$id_pays = 'BE';
				break;
			case 2027:				// Suisse
				$id_pays = 'CH';
				break; 
			case 2034:				// Belgique
				$id_pays = 'BE';
				break;
			case 2073:				// Belgique
				$id_pays = 'BE';
				break;
			case 2086:				// Belgique
				$id_pays = 'BE';
				break;
			case 2089:
				$id_pays = 'CH';
				break;
			case 2102:				// Belgique
				$id_pays = 'BE';
				break;
			case 2103:				// Suisse
				$id_pays = 'CH';
				break;
			case 2118:				// Belgique
				$id_pays = 'BE';
				break;
			case 2181:
				$ville = "Le Kremlin Bicetre";
				break;
			case 2211:				// Belgique
				$id_pays = 'BE';
				break;
			case 2219:
				$cp = '72000';
				break;
			case 2221:				// Belgique
				$id_pays = 'BE';
				break;
			case 2252:				// Belgique
				$id_pays = 'BE';
				break;
			case 2255:				// Belgique
				$id_pays = 'BE';
				break;
			case 2279:
				$ville = "LA FARE LES OLIVIERS";
				break;
			case 2299:
				$cp = 62153;
				break;
			case 2304:				// Belgique
				$id_pays = 'BE';
				break;
			case 2315:				// Belgique
				$id_pays = 'BE';
				break;
			case 2316:				// Belgique
				$id_pays = 'BE';
				break;
			case 2323:				// Suisse
				$id_pays = 'CH';
				break;
			case 2342:				// Suisse
				$id_pays = 'CH';
				break;
			case 2343:				// Suisse
				$id_pays = 'CH';
				break;
			case 2355:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2397:
				$ville = "L'ISLE ADAM";
				break;
			case 2399:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2400:				// Belgique
				$id_pays = 'BE';
				break;
			case 2403:				// Suisse
				$id_pays = 'CH';
				break;
			case 2418:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2421:				// Belgique
				$id_pays = 'BE';
				break;
			case 2423:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2425:				// Suisse
				$id_pays = 'CH';
				break;
			case 2434:
				$cp = "92170";
				break;
			case 2442:
				$cp = "13100";
				break;
			case 2444:
				$id_pays = 'BE';
				break;
			case 2453:				// Suisse
				$id_pays = 'CH';
				break;
			case 2456:				// Belgique
				$id_pays = 'BE';
				break;
			case 2469:				// Belgique
				$id_pays = 'BE';
				break;
			case 2573:
				$cp = '27000';
				$ville = 'evreux';
				break;
			case 2478:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2488:				//Suisse
				$id_pays = 'CH';
				break;
			case 2491:
				$id_pays = 'BE';
				break;
			case 2495:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2517:				// Suisse
				$id_pays = 'CH';
				break;
			case 2521:
				$id_pays = 'BE';
				break;
			case 2524:				// Belgique
				$id_pays = 'BE';
				break;
			case 2531:
				$id_pays = 'BE';
				break;
			case 2534:
				$id_pays = 'BE';
				break;
			case 2539:
				$id_pays = 'BE';
				break;
			case 2544:				// Belgique
				$id_pays = 'BE';
				break;
			case 2554:
				$cp = "77500";
				break;
			case 2569:				// Suisse
				$id_pays = 'CH';
				break;
			case 2574:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2584:				// Belgique
				$id_pays = 'BE';
				break;
			case 2590:
				$id_pays = 'CH';
				break;
			case 2612:				// Belgique
				$id_pays = 'BE';
				break;
			case 2625:
				$ville = "l'isle saint denis";
				break;
			case 2633:
				$id_pays = 'BE';
				break;
			case 2635:
				$id_pays = 'BE';
				break;
			case 2642:				// Belgique
				$id_pays = 'BE';
				break;
			case 2651:
				$id_pays = 'BE';
				break;
			case 2666:				// Abrutis
				$flag = FALSE;
				break;
			case 2677:				// Belgique
				$id_pays = 'BE';
				break;
			case 2680:
				$geoname = 209084;
				break;
			case 2689:				// Suisse
				$ville = "petit lancy";
				$cp = 1213;
				$id_pays = 'CH';
				break;
			case 2693:				// Belgique
				$id_pays = 'BE';
				break;
			case 2698:
				$id_pays = 'BE';
				break;
			case 2703:				// Abrutis
				$flag = FALSE;
				break;
			case 2720:
				$ville = "TALENCE";
				break;
			case 2728:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2729:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2736:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2740:				// Suisse
				$ville = "Auvernier";
				$id_pays = 'CH';
				break;
			case 2742:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2750:				// Suisse
				$id_pays = 'CH';
				break;
			case 2756:
				$id_pays = 'BE';
				break;
			case 2761:				// Suisse
				$id_pays = 'CH';
				break;
			case 2767:
				$id_pays = 'BE';
				$ville = "liege";
				break;
			case 2768:				// Belgique
				$id_pays = 'BE';
				break;
			case 2787:				// Suisse
				$id_pays = 'CH';
				$ville = "Chêne-Bougeries";
				break;
			case 2789:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2790:				// Belgique
				$id_pays = 'BE';
				break;
			case 2793:				// Suisse
				$geoname = 77237;
				break;
			case 2795:				// Belgique
				$id_pays = 'BE';
				break;
			case 2797:				// Suisse
				$id_pays = 'CH';
				break;
			case 2808;				// Belgique
				$id_pays = 'BE';
				break;
			case 2813;				// Luxembourg
				$id_pays = 'LU';
				break;
			case 2822:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2823:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2831:				// Belgique
				$id_pays = 'BE';
				break;  
			case 2853:				// Belgique
				$id_pays = 'BE';
				break;
			case 2866:				// Suisse
				$id_pays = 'CH';
				break;
			case 2880:				// Suisse
				$id_pays = 'CH';
				break;
			case 2930:				// Suisse
				$id_pays = 'CH';
				break;
			case 2941:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2944:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2957:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2958:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2959:				// Belgique
				$id_pays = 'BE';
				break;
			case 2970:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2974:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2983:				// Belgique
				$id_pays = 'BE';
				break;
			case 2984:				// Belgique
				$id_pays = 'BE';
				break;
			case 2989:
				$ville = 'Trooz Nessonvaux';
				$id_pays = 'BE';
				break;
			case 2990:
				$cp = 42600;
				break;
			case 3001:				// Belgique
				$id_pays = 'BE';
				break;  
			case 3030:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3039:
				$ville = "LUNERY";
				break;
			case 3041:				// Suisse
				$id_pays = 'CH';
				break;
			case 3045:				// Belgique
				$id_pays = 'BE';
				break;
			case 3047:
				$geoname = 216660;
				break;
			case 3051:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3055:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3070:				// Belgique
				$id_pays = 'BE';
				break;
			case 3073:				// Belgique
				$id_pays = 'BE';
				break;  
			case 3077:				// Belgique
				$id_pays = 'BE';
				break;
			case 3078:				// Belgique
				$id_pays = 'BE';
				break;  
			case 3079:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3089:				// Belgique
				$id_pays = 'BE';
				break;
			case 3091:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3099:				// Belgique
				$id_pays = 'BE';
				break;
			case 3117:
				$geoname = 220299;
				break;
			case 3118:
				$geoname = 69000;
				break;
			case 3127:				// Belgique
				$id_pays = 'BE';
				break;
			case 3133:				// Suisse
				$id_pays = 'CH';
				break;
			case 3146:				// Suisse
				$ville = "L'HAY LES ROSES";
				break; 
			case 3156:				// Suisse
				$id_pays = 'CH';
				break;
			case 3168:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3173:
				$cp = 75000;
				break;
			case 3174:				// Belgique
				$id_pays = 'BE';
				break;
			case 3184:				// Belgique
				$id_pays = 'BE';
				break;
			case 3188:
				$ville = "Noailles";
				break;
			case 3196:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3206:
				$ville = "CHATEAU D\'OLONNE";
				break;
			case 3216:				// Champs bidons dans ancienne version du LORD
				$flag = FALSE;
				break;
			case 3221:				// Belgique
				$geoname = 60056;
				break; 
			case 3224:				// Belgique
				$geoname = 60056;
				break; 
			case 3225:				// Belgique
				$id_pays = 'BE';
				break;
			case 3226:				// Belgique
				$geoname = 60056;
				break; 
			case 3227:				// Belgique
				$geoname = 60056;
				break; 
			case 3228:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3229:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3232:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3234:
				$geoname = 59996;
				break;
			case 3245:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3285:				// Belgique
				$id_pays = 'BE';
				$ville = "Dilbeek";
				break; 
			case 3293:
				$ville = "FRETTE SUR SEINE";
				break;
			case 3317:				// Belgique
				$id_pays = 'BE';
				break;
			case 3322:
				$geoname = 180741;
				break;
			case 3333:
				$ville = "SAINT LUCIEN";
				break;
			case 3337:
				$ville = "PARIS";
				break;
			case 3349:				// Belgique
				$id_pays = 'BE';
				break;
			case 3350:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3353:
				$ville = 'Jurbise';
				$id_pays = 'BE';
				break;
			case 3356:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3357:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3367:				// Belgique
				$id_pays = 'BE';
				break;
			case 3391:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3398:
				$ville = "Rurange-lès-Thionville";
				break;
			case 3399:
				$geoname = 155023;
				break;
			case 3406:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3408:				// Belgique
				$geoname = 57589;
				break; 
			case 3414:				// Belgique
				$id_pays = 'BE';
				break;
			case 3418:				// Belgique
				$id_pays = 'BE';
				$ville = "FLEMALLE";
				break;
			case 3419:				// Belgique
				$id_pays = 'BE';
				break;
			case 3428:
				$ville = "Houetteville";
				break;
			case 3453:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3454:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3456:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3478:				// Abrutis
				$flag = FALSE;
				break;
			case 3492:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3501:				// Belgique
				$id_pays = 'BE';
				break;
			case 3502:				// Suisse
				$id_pays = 'CH';
				break;
			case 3515:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3540:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3558:				// Belgique
				$id_pays = 'BE';
				break;
			case 3563:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3564:				// Belgique
				$id_pays = 'BE';
				break;
			case 3570:
				$ville = "Saint-Genis-Laval";
				break;
			case 3573:				// Suisse
				$id_pays = 'CH';
				break; 
			case 3584:				// Belgique
				$id_pays = 'BE';
				break;
			case 3585:
				$ville = "VIGNEUX SUR SEINE";
				break;
			case 3587:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3595:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3600:				// Belgique
				$id_pays = 'BE';
				$cp = 1140;
				break;
			case 3606:				// Belgique
				$id_pays = 'BE';
				break;
			case 3613:				// Luxembourg
				$id_pays = 'LU';
				break;
			case 3615:				// Belgique
				$id_pays = 'BE';
				break;
			case 3616:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3619:				// Belgique
				$geoname = 59884;
				break;
			case 3658:				// Belgique
				$id_pays = 'BE';
				break;
			case 3660:				// Belgique
				$id_pays = 'BE';
				break;
			case 3674:
				$geoname = 200623;
				break;
			case 3680:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3683:				// Belgique
				$id_pays = 'BE';
				break;
			case 3694:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3701:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3702:				// Belgique
				$id_pays = 'BE';
				break;
			case 3703:				// Belgique
				$id_pays = 'BE';
				break;
			case 3712: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3716:				// Belgique
				$id_pays = 'BE';
				break;
			case 3717: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3721: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3743: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3744: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3747:				// Suisse
				$id_pays = 'CH';
				break; 
			case 3761: 				// Belgique
				$geoname = 60588;
				break;
			case 3765: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3767:
				$geoname = 557004;
				break;
			case 3825: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3835:
				$geoname = 75339;
				break;
			case 3851: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3875:
				$cp = 75016;
				break;
			case 3884: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3894:				// Abrutis
				$flag = FALSE;
				break;
			case 3900: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3904: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3940: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3944:
				$id_pays = 'BE';
				$ville = 'liege';
				break;
			case 3950:
				$geoname = 1027825;
				break;
			case 3974: 				// Suisse
				$id_pays = 'CH';
				break;
			case 4013:				// Belgique
				$id_pays = 'BE';
				break;
			case 4023: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4031:
				$geoname = 215443;
				break;
			case 4045:
				$cp = 60430;
				break;
			case 4046:				// Suisse
				$id_pays = 'CH';
				break;
			case 4055: 				// Belgique
				$id_pays = 'CH';
				break;
			case 4059: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4061:
				$geoname = 956492;
				break;
			case 4084:
				$ville = "DUNKERKE";
				break;
			case 4099:				// Suisse
				$id_pays = 'CH';
				break;
			case 4108:				// Suisse
				$geoname = 77038;
				break;
			case 4141: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4167:
				$geoname = 207067;
				break;
			case 4185: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4189:				// Suisse
				$id_pays = 'CH';
				break;
			case 4196:
				$geoname = 956500;
				break;
			case 4213:				// Suisse
				$id_pays = 'CH';
				break;
			case 4217:
				$geoname = 956498;
				break;
			case 4218:
				$id_pays = 'FR';
				break;
			case 4231:
				$id_pays = 'FR';
				break;
			case 4273:
				$id_pays = 'FR';
				break;
			case 4288:
				$id_pays = 'FR';
				$ville = "Chateau D'olonne";
				break;
			case 4289:
				$id_pays = 'FR';
				break;
			case 4293:				// Suisse
				$id_pays = 'CH';
				break;
			case 4310:				// Suisse
				$id_pays = 'CH';
				break;
			case 4314:
				$id_pays = 'FR';
				break;
			case 4322:
				$id_pays = 'FR';
				break;
			case 4342:
				$geoname = 59155;
				break;
			case 4362:
				$ville = "ALBI";
				break;
			case 4363:
				$id_pays = 'FR';
				break;
			case 4379:
				$id_pays = 'FR';
				break;
			case 4396:
				$id_pays = 'FR';
				break;
			case 4404:
				$id_pays = 'FR';
				break;
			case 4407:
				$id_pays = 'FR';
				break;
			case 4419:
				$id_pays = 'FR';
				break;
			case 4422:
				$cp = 56390;
				break;
			case 4434:
				$id_pays = 'FR';
				break;
			case 4435:
				$id_pays = 'FR';
				break;
			case 4439:
				$id_pays = 'FR';
				break;
			case 4471:
				$geoname = 59131;
				break;
			case 4473:
				$id_pays = 'FR';
				break;
			case 4487:
				$id_pays = 'FR';
				break;
			case 4498:
				$id_pays = 'FR';
				break;
			case 4508:
				$id_pays = 'FR';
				break;
			case 4547:
				$id_pays = 'FR';
				break;
			case 4557:
				$id_pays = 'FR';
				break;
			case 4558:
				$id_pays = 'FR';
				break;
			case 4572:
				$id_pays = 'FR';
				break;
			case 4574:
				$id_pays = 'FR';
				break;
			case 4575:
				$id_pays = 'FR';
				break;
			case 4586:
				$id_pays = 'FR';
				break;
			case 4587:
				$id_pays = 'FR';
				break;
			case 4607:
				$id_pays = 'FR';
				break;
			case 4609:
				$id_pays = 'FR';
				break;
			case 4615:
				$id_pays = 'FR';
				break;
			case 4619:
				$id_pays = 'FR';
				break;
			case 4621:				// Belgique
				$geoname = 1119574;
				break;
			case 4639:
				$id_pays = 'FR';
				$cp = 13120;
				break;
			case 4645:
				$id_pays = 'FR';
				break;
			case 4663:				// Suisse
				$id_pays = 'CH';
				break;
			case 4665:
				$geoname = 1119579;
				break;
			case 4666:
				$id_pays = 'FR';
				break;
			case 4669:				// Suisse
				$id_pays = 'CH';
				break;
			case 4679:
				$id_pays = 'FR';
				$ville = "L'ISLE D'ABEAU";
				break;
			case 4680:
				$id_pays = 'FR';
				break;
			case 4706:
				$id_pays = 'FR';
				break;
			case 4710:
				$geoname = 1119580;
				break;
			case 4719:
				$id_pays = 'FR';
				break;
			case 4728:
				$id_pays = 'FR';
				break;
			case 4736:
				$id_pays = 'FR';
				break;
			case 4741:
				$id_pays = 'FR';
				break;
			case 4851:
				$geoname = 181793;
				break;
			case 4890:
				$geoname = 1119582;
				break;
			case 4944:
				$id_pays = 'FR';
				break;
			case 4956:
				$id_pays = 'FR';
				break;
			case 4964:
				$id_pays = 'FR';
				break;
			case 4965:
				$id_pays = 'FR';
				break;
			case 4966:
				$id_pays = 'FR';
				break;
			case 4971:
				$id_pays = 'FR';
				break;
			case 4972:
				$id_pays = 'FR';
				break;
			case 4975:
				$id_pays = 'FR';
				break;
			case 4978:
				$id_pays = 'FR';
				break;
			case 5004:
				$id_pays = 'FR';
				break;
			case 5014:
				$id_pays = 'FR';
				break;
			case 5020:
				$id_pays = 'FR';
				break;
			case 5039:
				$id_pays = 'FR';
				break;
			case 5040:
				$id_pays = 'FR';
				break;
			case 5043:
				$id_pays = 'FR';
				break;
			case 5044:
				$id_pays = 'FR';
				break;
			case 5046:
				$id_pays = 'FR';
				break;
			case 5048:
				$id_pays = 'FR';
				break;
			case 5050:
				$id_pays = 'FR';
				break;
			case 5059:
				$id_pays = 'FR';
				break;
			case 5065:
				$id_pays = 'FR';
				break;
			case 5185: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3959: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4113: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4132:				// Belgique
				$id_pays = 'BE';
				break;
			case 4243:
				$ville = "CHATEAUROUX";
				break;
			case 4639:
				$cp = 13120;
				break;
			case 5328:
				$geoname = 216989;
				break;
			case 5332:
				$id_pays = 'FR';
				break;
			case 5333:
				$id_pays = 'FR';
				break;
			case 5342:
				$id_pays = 'FR';
				break;
			case 5347:
				$id_pays = 'FR';
				break;
			case 5354:
				$id_pays = 'FR';
				break;
			case 5355:
				$id_pays = 'FR';
				break;
			case 5392:
				$id_pays = 'FR';
				break;
			case 5398:
				$id_pays = 'FR';
				break;
			case 5411:
				$id_pays = 'FR';
				break;
			case 5415:
				$id_pays = 'FR';
				break;
			case 5420:
				$id_pays = 'FR';
				break;
			case 5423:
				$id_pays = 'FR';
				break;
			case 5426:
				$id_pays = 'FR';
				break;
			case 5430:
				$geoname = 705957;
				break;
		}
		
		if($flag == FALSE)
		{
			$return = FALSE;
		}
		else
		{
			$return = array(
				"geoname"	=> $geoname,
				"ville"		=> $ville,
				"cp"		=> $cp,
				"pays"		=> $id_pays
			);
		}
		
		return $return;
	}
	
	private function validatePeelUtilisateursEmail($email,$old_id)
	{
		$email_sortie = NULL;
		
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			switch($old_id)
			{
				case 4:case 11: case 15: case 20: case 21: case 22: case 54: case 219: case 442: case 517: case 545: case 589:
				case 595: case 633: case 802: case 841: case 872: case 873: case 1096: case 1136: case 1209: case 1257:
				case 1317: case 1388: case 1988: case 1399: case 1438: case 1453: case 1463: case 1506: case 1533: case 1539:
				case 1597: case 1623: case 1663: case 1787: case 1884: case 1890: case 1892: case 1929: case 2034: case 2286:
				case 3366:
					// Ignorer les erreurs d'email pour les numéros ci dessus
					$email_sortie = $email;
					break;
				case 596:
					$email_sortie = "marinette313@hotmail.fr";
					break;
				case 1274:
					$email_sortie = "claudejul@aol.com";
					break;
				case 2133:
					$email_sortie = "somma.line@gmail.com";
					break;
				case 2212:
					$email_sortie = "harmonie_fila@orange";
					break;
				case 2255:
					$email_sortie = "anne_surkijn@voo.be";
					break;
				case 3944:
					$email_sortie = "pirontalexia@hotmail.com";
					break;
				case 3953:
					$email_sortie = "bandie62@hotmail.fr";
					break;
				default:
					$email_sortie = 1;
					break;
			}
		}
		else
		{
			$email_sortie = $email;
		}

		$req = $this->_db_v1->prepare("SELECT `email` FROM `peel_utilisateurs` WHERE `email` = :email");
		$req->execute(array("email" => $email));

		if($req->rowCount() > 1)
		{
			$email_sortie = 2;
		}

		$req->closeCursor();
		
		switch($email)
		{
			case 1:
				$this->_events[] = array(
					'id'		=> $old_id,
					'type'		=> "error",
					'details'	=> "Adresse mail invalide"
				);
				$this->_flag = FALSE;
				break;
			case 2:
				$this->_events[] = array(
					'id'		=> $old_id,
					'type'		=> "error",
					'details'	=> "Adresse mail en double dans `peel_utilisateurs`"
				);
				$this->_flag = FALSE;
				break;
			case 3:
				$this->_events[] = array(
					'id'		=> $old_id,
					'type'		=> "error",
					'details'	=> "Adresse mail deja présente dans 'users'"
				);
				$this->_flag = FALSE;
				break;
		}

		return $email_sortie;
	}
	
	private function validatePeelUtilisateursPseudo($pseudo,$old_id = NULL)
	{
		$level = 0;
	
		switch($pseudo)
		{
			case "Babbou":
				$level = "staff";
				break;
			case "Limë":
				$level = "staff";
				break;
			default:
				$req = $this->_db_v1->prepare("SELECT `pseudo` FROM `peel_utilisateurs` WHERE `pseudo` = :pseudo");
				$req->execute(array("pseudo" => $pseudo));

				if($req->rowCount() == 1)
				{
					$level = "membre";
				}
				else
				{
					$donnees = $req->fetch();

					if($pseudo === $donnees['pseudo'])
					{
						$level = 1;
					}
				}

				$req->closeCursor();

				$result = $this->_api_v2->getUtilisateur("base",array("pseudo" => $pseudo));

				if(is_array($result->response->datas))
				{
					if(is_null($old_id))
					{
						if($pseudo === $result->response->datas[0]->pseudo)
						{
							$level = 2;
						}
					}
					else
					{
						// On ignore le fait que le pseudo est identique s'il s'agit d'une syncrho du membre
						if($pseudo === $result->response->datas[0]->pseudo AND $old_id != $result->response->datas[0]->id_membre)
						{
							echo "plop ".$old_id." ".$result->response->datas[0]->id_membre;
							$level = 2;
						}
					}
				}
				break;
		}
		
		switch($level)
		{
			case 1:
				$events[] = array(
					'id'		=> $old_id,
					'type'		=> "error",
					'details'	=> "Pseudo en double"
				);
				$this->_flag = FALSE;
				break;
			case 2:
				$events[] = array(
					'id'		=> $old_id,
					'type'		=> "error",
					'details'	=> "Pseudo deja présent dans 'users'"
				);
				$this->_flag = FALSE;
				break;
		}

		return $level;
	}
	
	  /////////////////////////////////////////////////////////////////////////////
	 //	Gestion des Rateries													//
	/////////////////////////////////////////////////////////////////////////////
	
	// Gère la synchronisation des rateries
	public function syncRateries()
	{
		// Récréation de la Raterie l'Ile aux rats
		$datas = $this->_api_v2->getUtilisateur("base",array('pseudo' => 'ariane'));
		
		$id_ariane = $datas->response->datas[0]->id_membre;
		
		echo "Recréation Raterie l'Ile Aux Rats pour user Ariane id ".$id_ariane." : ";
		
		if(is_array($this->_api_v2->getRaterie("base",array("affixe" => "IAR"))->response->datas))
		{
			echo "IAR existe deja\n";
		}
		else
		{
			$params = array(
				"id_membre"			=> $id_ariane,
				"affixe"			=> 'IAR',
				"nom"				=> "L île aux rats",
				"presentation"		=> "",
				"status"			=> TRUE,
				"on_map"			=> TRUE,
				"date_ajout"		=> 0,
				"date_last_edit"	=> 0
			);

			if($this->_api_v2->addRaterie("base",$params)->response->datas == "success")
			{
				echo "Done";
			}
			else
			{
				echo "Failed";
				
				$this->_flag = FALSE;
			}
			
			echo "\n";
		}
		
		echo "\n";
		
		$req = $this->_db_v1->query("SELECT * FROM `peel_marques` "/*WHERE `affixe` LIKE 'LRE'"/*LIMIT 1000 OFFSET 2180"*/);
		
		while($donnees = $req->fetch())
		{
			if($this->_flag)
			{
				$affixe = $donnees['affixe'];
				
				echo "Raterie ".$affixe." ";
				
				switch($donnees['affixe'])
				{
					case "AAS":
						$id_membre = 0;
						break;
					case "AC.":
						$id_membre = 0;
						break;
					case "CRP":
						$id_membre = 0;
						break;
					case "ETR":
						$id_membre = 0;
						break;
					case "FLS":
						$id_membre = 0;
						break;
					case "FRR":
						$id_membre = 0;
						break;
					case "FT.":
						$id_membre = 0;
						break;
					case "INC":
						$id_membre = 0;
						break;
					case "IND":
						$id_membre = 0;
						break;
					case "FDO":
						$id_membre = 0;
						break;
					case "LAB":
						$id_membre = 0;
						break;
					case "MLI":
						$id_membre = 0;
						break;
					case "PER":
						$id_membre = 0;
						break;
					case "RB.":
						$id_membre = 0;
						break;
					case "REP":
						$id_membre = 0;
						break;
					case "RGK":
						$id_membre = 0;
						break;
					case "RKB":
						$id_membre = 0;
						break;
					case "ROA":
						$id_membre = 0;
						break;
					case "RTX":
						$id_membre = 0;
						break;
					case "SCP":
						$id_membre = 0;
						break;
					case "SLT":
						$id_membre = 0;
						break;
					case "SML":
						$id_membre = 0;
						break;
					case "SVG":
						$id_membre = 0;
						break;
					case "SVT":
						$id_membre = 0;
						break;
					default:
						$user = $this->_api_v2->getUtilisateur("base",array('pseudo' => $donnees['proprio']))->response->datas;
						if(is_array($user))
						{
							$id_membre = $user[0]->id_membre;
						}
						else
						{
							$this->_events[] = array(
								'id'		=> $donnees['affixe'],
								'type'		=> "error",
								'details'	=> "Raterie ".$donnees['affixe']." a l'utilisateur ".$donnees['proprio']." défini qui n'existe pas"
							);
							$id_membre = 0;
						}
						break;
				}
				
				if($id_membre == 0)
				{
					$proprio = "Système";
				}
				else
				{
					$proprio = $donnees['proprio'];
				}
				
				echo "pour User ".$proprio." id ".$id_membre." : ";
				
				if(!is_array($this->_api_v2->getRaterie("base",array("affixe" => $donnees['affixe']))->response->datas))
				{
					echo "Can Be Inserted : ";
					
					if($donnees['date_crea'] == "0000")
					{
						$date_crea = 0;
					}
					else
					{
						$date_crea = strtotime($donnees['date_crea']."-01-01");
					}
					
					if($donnees['date_maj'] == "0000-00-00")
					{
						$date_maj = 0;
					}
					else
					{
						$date_maj = strtotime($donnees['date_maj']);
					}
					
					if($id_membre == 0)
					{
						$on_map = FALSE;
					}
					else
					{
						$on_map = $donnees['etat'];
					}
					
					$params = array(
						"id_membre"			=> $id_membre,
						"affixe"			=> $donnees['affixe'],
						"nom"				=> htmlspecialchars_decode($donnees['nom_fr'],ENT_QUOTES),
						"presentation"		=> htmlspecialchars_decode($donnees['description_fr'],ENT_QUOTES),
						"logo"				=> $donnees['image'],
						"status"			=> $donnees['etat'],
						"on_map"			=> $on_map,
						"date_ajout"		=> $date_crea,
						"date_last_edit"	=> $date_maj
					);

					if($this->_api_v2->addRaterie("base",$params)->response->datas == "success")
					{
						echo "Done";
					}
					else
					{
						echo "Failed";
						
						$this->_flag = FALSE;
					}

					echo "\n";
				}
				else
				{
					echo "To Sync : ";
					
					echo "no sync process operationnal";
				}
				
				echo "\n";
			}
		}
	}
	
	  /////////////////////////////////////////////////////////////////////////
	 //	Gestion des criteres et tables références diverses					//
	/////////////////////////////////////////////////////////////////////////
	
	public function syncCriteres()
	{
		$this->migrateRatsCausesDeces();
		$this->migrateRatsCouleurs(); 
		$this->migrateRatsDilutions();
		$this->migrateRatsMarquages();
		$this->migrateRatsOreilles();
		$this->migrateRatsPbSantes();
		$this->migrateRatsPoils();
		$this->migrateRatsUniques();
		$this->migrateRatsYeux();
	}

	// Fonction de conversion de la table peel_couleurs en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsCausesDeces()									// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom` FROM `peel_deces` ORDER BY `nom`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom']))
					{
						if($this->_verbose)
						{
							echo "Cause de deces : ".$donnees['nom']." : ";
						}
						
						$result = $this->_api_v2->addCriteres("causesdeces",$donnees['nom'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}
	
	// Fonction de conversion de la table peel_couleurs en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsCouleurs()										// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_couleurs` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Couleur : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("couleurs",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsDilutions()										// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_dilutions` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Dilution : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("dilutions",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsMarquages()										// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_marquage` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Marquage : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("marquages",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsOreilles()										// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_oreilles` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Oreille : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("oreilles",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsPbSantes()										// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id_sante`,`texte_sante` FROM `sante` ORDER BY `texte_sante`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['texte_sante']))
					{
						if($this->_verbose)
						{
							echo "Problèmes de santés : ".$donnees['texte_sante']." : ";
						}
						
						$result = $this->_api_v2->addCriteres("pbsantes",$donnees['texte_sante'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsPoils()											// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_poils` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Poils : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("poils",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsUniques()										// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_unique` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Unique : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("uniques",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}

	// Fonction de conversion de la table peel_dilutions en rats_couleurs
	// Output :
	// 0 => Succes
	// 1 => Echec
	private function migrateRatsYeux()											// OK
	{
		if($this->_flag)
		{
			$req = $this->_db_v1->query("SELECT `id`,`nom_fr` FROM `peel_yeux` ORDER BY `nom_fr`");

			while($donnees = $req->fetch())
			{
				if($this->_flag)
				{
					if(!empty($donnees['nom_fr']))
					{
						if($this->_verbose)
						{
							echo "Yeux : ".$donnees['nom_fr']." : ";
						}

						$result = $this->_api_v2->addCriteres("yeux",$donnees['nom_fr'])->response->datas;
						
						if($this->_verbose)
						{
							echo json_encode($result)."\n";
						}
					}
				}
			}

			$req->closeCursor();
		}
	}
	
	  /////////////////////////////////////////////////////////////////////////////
	 //	Gestion des Rats														//
	/////////////////////////////////////////////////////////////////////////////
	
	// Gère la synchronisation des rats
	public function syncRats()
	{
		// Phase 1 - Insertion des rats
		$req = $this->_db_v1->query("SELECT * FROM `peel_rats` ORDER BY `id`");
		
		while($donnees = $req->fetch())
		{
			if($this->_verbose)
			{
				echo "Rat ".$donnees['numero']." : ";
			}
			
			// Réccupération des données de rateries
			// Exception pour INC *Sauvetage* qui passe en SVT *Sauvetage* en V2
			if($donnees['affixe'] == "INC" AND $donnees['origine'] == "*Sauvetage*")
			{
				$donnees['affixe'] = 'SVT';
			}
			
			$raterie = $this->_api_v2->getRaterie("base",array("affixe" => htmlspecialchars_decode($donnees['affixe'])))->response->datas;

			if(is_array($raterie) AND count($raterie) > 0)
			{
				if(trim($raterie[0]->nom) == trim(htmlspecialchars_decode($donnees['origine'])) OR htmlspecialchars_decode($donnees['origine']) == "")
				{
					if($this->_verbose)
					{
						echo "Raterie trouvée  - ";
					}

					$id_raterie = $raterie[0]->id_raterie;
				}
				else
				{
					if($this->_verbose)
					{
						echo "Couple ".$donnees['affixe']." ".$donnees['origine']." n'existe pas";
					}

					$this->_events[] = array(
						'id'		=> $donnees['numero'],
						'type'		=> "warning",
						'details'	=> "Couple ".$donnees['affixe']." ".$donnees['origine']." n'existe pas => Origine par affixe est ".$raterie[0]->nom
					);

					$id_raterie = 0;
				}
			}
			else
			{
				if($this->_verbose)
				{
					print_r($raterie);

					echo "Raterie ".$donnees['affixe']." ".$donnees['origine']." n'existe pas";
				}

				$this->_events[] = array(
					'id'		=> $donnees['numero'],
					'type'		=> "error",
					'details'	=> "Raterie ".$donnees['affixe']." ".$donnees['origine']." n'existe pas"
				);

				$id_raterie = 0;
			}

			// Réccupération des données du propriétaire
			switch($donnees['proprietaire'])
			{
				case "Registre":
					$id_proprio = 0;

					if($this->_verbose)
					{
						echo " ID Proprio : ".$id_proprio." - ";
					}
					break;
				default:
					$user = $this->_api_v2->getUtilisateur("base",array("pseudo" => htmlspecialchars_decode($donnees['proprietaire'])))->response->datas;

					if(is_array($user))
					{
						$id_proprio = $user[0]->id_membre;

						if($this->_verbose)
						{
							echo " ID Proprio : ".$id_proprio." - ";
						}
					}
					else
					{
						if($this->_verbose)
						{
							print_r($user);

							echo "Utilisateur ".$donnees['proprietaire']." introuvable";
						}
						$this->_events[] = array(
							'id'		=> $donnees['numero'],
							'type'		=> "error",
							'details'	=> "Utilisateur ".$donnees['proprietaire']." introuvable"
						);

						$id_proprio = 0;
					}
					break;
			}

			// Réccupérations des dates
			$dates = array(
				"date_naissance"	=> 0,
				"date_deces"		=> 0,
				"repro_date"		=> 0,
				"date_ajout"		=> 0,
				"date_last_edit"	=> 0
			);

			if($donnees['ddn'] != "0000-00-00")
			{
				$dates['date_naissance'] = strtotime($donnees['ddn']); 
			}

			if($donnees['ddd'] != "0000-00-00")
			{
				$dates['date_deces'] = strtotime($donnees['ddd']); 
			}

			if($donnees['repro_date'] != "0000-00-00")
			{
				$dates['repro_date'] = strtotime($donnees['repro_date']); 
			}

			if($donnees['date_insere'] != "0000-00-00")
			{
				$dates['date_ajout'] = strtotime($donnees['date_insere']); 
			}

			if($donnees['date_maj'] != "0000-00-00")
			{
				$dates['date_last_edit'] = strtotime($donnees['date_maj']); 
			}
			
			// Réccupération des données de critères
			$criteres = array(
				"couleur"		=> $this->getCriteres($donnees['numero'],"couleurs",htmlspecialchars_decode($donnees['couleur'])),
				"dilution"		=> $this->getCriteres($donnees['numero'],"dilutions",htmlspecialchars_decode($donnees['dilution'])),
				"marquage"		=> $this->getCriteres($donnees['numero'],"marquages",htmlspecialchars_decode($donnees['marquage'])),
				"oreilles"		=> $this->getCriteres($donnees['numero'],"oreilles",htmlspecialchars_decode($donnees['oreilles'])),
				"poils"			=> $this->getCriteres($donnees['numero'],"poils",htmlspecialchars_decode($donnees['poils'])),
				"uniques"		=> $this->getCriteres($donnees['numero'],"uniques",array(
						htmlspecialchars_decode($donnees['unique_1']),
						htmlspecialchars_decode($donnees['unique_2']),
						htmlspecialchars_decode($donnees['unique_3']),
						htmlspecialchars_decode($donnees['unique_4'])
					)),
				"yeux"			=> $this->getCriteres($donnees['numero'],"yeux",htmlspecialchars_decode($donnees['yeux'])),
				"causes_deces"	=> $this->getCriteres($donnees['numero'],"causesdeces",htmlspecialchars_decode($donnees['cause_ddd'])),
				"pb_santes"		=> $this->getCriteres($donnees['numero'],"pbsantes",htmlspecialchars_decode($donnees['pb_sante']))
			);

			if($donnees['repro'])
			{
				$repro = 'Oui';
			}
			else
			{
				$repro = 'Non';
			}
			
			if($dates['date_deces'] == 0)
			{
				// On marque comme mort les rats étants nés depuis plus de 5 ans ou ayant une cause de décès renseignée
				if(!empty($donnees['cause_ddd']))
				{
					$vivant = 'Non';
				}
				else if ($dates['date_naissance'] < (time() - (3600 * 24 * 365 * 5)))
				{
					$criteres['causes_deces'] = $this->getCriteres($donnees['numero'],"causesdeces","Non Renseigné, renvoyé SAV car né il y a plus de 5 ans");
				}
				else
				{
					$vivant = 'Oui';
				}
			}
			else
			{
				$vivant = 'Non';
			}
			
			// Liaison avec les parents
			$datas_pere = $this->_api_v2->getRat("base",array("numero" => htmlspecialchars_decode($donnees['num_pere'])))->response->datas;
			
			if(is_array($datas_pere))
			{
				$id_pere = $datas_pere[0]->id_rat;
			}
			else
			{
				$id_pere = NULL;
			}
			
			$datas_mere = $this->_api_v2->getRat("base",array("numero" => htmlspecialchars_decode($donnees['num_mere'])))->response->datas;
			
			if(is_array($datas_mere))
			{
				$id_mere = $datas_mere[0]->id_rat;
			}
			else
			{
				$id_mere = NULL;
			}
			
			// Préparation des paramètres pour base
			$params = array(
				"raterie"			=> $id_raterie,
				"nom_courant"		=> htmlspecialchars_decode($donnees['alias'],ENT_QUOTES),
				"nom_naissance"		=> htmlspecialchars_decode($donnees['nom'],ENT_QUOTES),
				"sexe"				=> htmlspecialchars_decode($donnees['sexe']),
				"numero"			=> htmlspecialchars_decode($donnees['numero']),
				"pere"				=> $id_pere,
				"mere"				=> $id_mere,
				"vivant"			=> $vivant,
				"pb_santes"			=> $criteres['pb_santes'],
				"date_naissance"	=> $dates['date_naissance'],
				"date_deces"		=> $dates['date_deces'],
				"cause_deces"		=> $criteres['causes_deces'],
				"user"				=> $id_proprio,
				"couleur"			=> $criteres['couleur'],
				"dilution"			=> $criteres['dilution'],
				"marquage"			=> $criteres['marquage'],
				"oreilles"			=> $criteres['oreilles'],
				"poils"				=> $criteres['poils'],
				"uniques"			=> $criteres['uniques'],
				"yeux"				=> $criteres['yeux'],
				"portee"			=> 0,
				"repro"				=> $repro,
				"repro_date"		=> $dates['repro_date'],
				"commentaires"		=> htmlspecialchars_decode($donnees['comment'],ENT_QUOTES),
				"date_ajout"		=> $dates['date_ajout'],
				"date_user_view"	=> 0,
				"date_last_edit"	=> $dates['date_last_edit'],
				"sav_check"			=> htmlspecialchars_decode($donnees['sav'],ENT_QUOTES),
				"etat"				=> $donnees['etat'],
			);
			
			if($this->_flag)
			{
				$datas_rat = $this->_api_v2->getRat("base",array("numero" => $donnees['numero']))->response->datas;
				
				if(is_array($datas_rat))
				{
					$id_rat = $datas_rat[0]->id_rat;
					
					// Ajout de l'identifiant du rat dans les paramètres
					$params['id_rat'] = $id_rat;
					
					if($this->_verbose)
					{
						echo "Id ".$id_rat." To Sync : ";
					}
					
					// Sync Infos Rats
					
					echo "Mise à jour : ";
					
					$datas = $this->_api_v2->saveRat("base",$params)->response->datas;
					
					if($datas == "success")
					{
						if($this->_verbose)
						{
							echo "OK - ";
						}
					}
					else if($datas == "already")
					{
						if($this->_verbose)
						{
							echo "Already - ";
						}
					}
					else
					{
						if($this->_verbose)
						{
							echo "Failed - ";
							
							print_r($datas);
						}
						
						$this->_events[] = array(
							'id'		=> $donnees['numero'],
							'type'		=> "error",
							'details'	=> "Mise à jour rat échouée"
						);
					}
					
					// Sync Images Rats
					if(!empty($donnees['image']))
					{
						echo "Sync Image : ";
						
						$datas_image = $this->_api_v2->getRat("image",array("id_rat" => $id_rat))->response->datas;

						if(is_array($datas_image))
						{
							// Une image existe deja, MAJ à faire

							// TODO
						}
						else
						{
							// Image à insérer
							
							echo "Insertion Image : ";
							
							$params = array(
								"id_rat"			=> $id_rat,
								"fichier"			=> $donnees['image'],
								"status"			=> $donnees['etat'],
								"date_ajout"		=> $dates['date_ajout'],
								"date_user_view"	=> 0,
								"date_last_edit"	=> $dates['date_last_edit']
							);

							$datas = $this->_api_v2->addRat("image",$params)->response->datas;
							
							if($datas == "success")
							{
								echo "OK";
							}
							else
							{
								echo "Failed";
							}
						}
					}
				}
				else
				{
					if($this->_verbose)
					{
						echo "Can be inserted : ";
					}

					// Insertion du rat
					echo "Insertion : ";
					
					$datas = $this->_api_v2->addRat("base",$params)->response->datas;
					
					if($datas == "success")
					{
						if($this->_verbose)
						{
							echo "OK";
						}
					}
					else
					{
						if($this->_verbose)
						{
							echo "Failed";
							
							print_r($datas);
						}
						
						$this->_events[] = array(
							'id'		=> $donnees['numero'],
							'type'		=> "error",
							'details'	=> "Insertion rat échouée"
						);
					}
					
					// Réccupération de l'id du rat
					
				}

				echo "\n";
			}
		}
		
		$req->closeCursor();
		
		// Phase 2 - Reconstruction de la généalogie
	}
	
	private function getCriteres($numero,$critere,$params)
	{
		if(!empty($params))
		{
			switch($critere)
			{
				case "causesdeces":
					$datas = $this->_api_v2->getCriteres("causesdeces",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "couleurs":
					$datas = $this->_api_v2->getCriteres("couleurs",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "dilutions":
					$datas = $this->_api_v2->getCriteres("dilutions",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "marquages":
					$datas = $this->_api_v2->getCriteres("marquages",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "oreilles":
					$datas = $this->_api_v2->getCriteres("oreilles",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "pbsantes":
					$datas = $this->_api_v2->getCriteres("pbsantes",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "poils":
					$datas = $this->_api_v2->getCriteres("poils",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				case "uniques":
					$ids = array();

					foreach($params as $nom)
					{
						$datas = $this->_api_v2->getCriteres("uniques",array('nom' => $nom))->response->datas;

						if(is_array($datas))
						{
							$ids[] = $datas[0]->id;
						}
					}

					if(count($ids))
					{
						$id = $ids;
					}
					else
					{
						$id = 0;
					}
					break;
				case "yeux":
					$datas = $this->_api_v2->getCriteres("yeux",array('nom' => $params))->response->datas;

					if(is_array($datas))
					{
						$id = $datas[0]->id;
					}
					else
					{
						$id = 0;
					}
					break;
				default:
					$this->_events[] = array(
						'id'		=> $numero,
						'type'		=> "error",
						'details'	=> "Critere ".$critere." ".$params." n'existe pas"
					);
					$id = 0;
					break;
			}
		}
		else
		{
			$id = 0;
		}
		
		return $id;
	}
	
	  /////////////////////////////////////////////////////////////////////////////
	 //	Gestion des portées														//
	/////////////////////////////////////////////////////////////////////////////
	
	public function syncPortees()
	{
		$req = $this->_db_v1->query("SELECT * FROM `portee` ORDER BY `num_portee`");
		
		while($donnees = $req->fetch())
		{
			if(!empty($donnees['numero_pere']))
			{
				$pere = $this->_api_v2->getRat("base", array('numero' => $donnees['numero_pere']))->response->datas;
				
				if(is_array($pere))
				{
					$id_pere = $pere[0]->id_rat;
				}
				else
				{
					$this->_events[] = array(
						'id'		=> "Portee ".$donnees['num_portee'],
						'type'		=> "error",
						'details'	=> "Rat ".$donnees['numero_pere']." : ".$pere->error
					);
					
					$id_pere = 0;
				}
			}
			else
			{
				$id_pere = 0;
			}
			
			if(!empty($donnees['numero_mere']))
			{
				$mere = $this->_api_v2->getRat("base", array('numero' => $donnees['numero_mere']))->response->datas;
				
				if(is_array($mere))
				{
					$id_mere = $mere[0]->id_rat;
				}
				else
				{
					$this->_events[] = array(
						'id'		=> "Portee ".$donnees['num_portee'],
						'type'		=> "error",
						'details'	=> "Rat ".$donnees['numero_mere']." : ".$mere->error
					);
					
					$id_mere = 0;
				}
			}
			else
			{
				$id_mere = 0;
			}
			
			if($donnees['num_util'] != 0)
			{
				$user = $this->_api_v2->getUtilisateur("base",array('old_id' => $donnees['num_util']))->response->datas;
				
				if(is_array($user))
				{
					$id_membre = $user[0]->id_membre;
				}
				else
				{
					$this->_events[] = array(
						'id'		=> "Portee ".$donnees['num_portee'],
						'type'		=> "error",
						'details'	=> "Utilisateur ".$donnees['num_util']." : ".$user->error
					);
					
					$id_membre = 0;
				}
			}
			else
			{
				$id_membre = 0;
			}
			
			echo "Portee ".$donnees['num_portee']." - {Pere:".$donnees['numero_pere']."=>".$id_pere."}{Mere:".$donnees['numero_mere']."=>".$id_mere."}{Utlisateur:".$donnees['num_util']."=>".$id_membre."} : ";
			
			// Vérification si entrée existe deja
			$portee = $this->_api_v2->getPortee(array('old_id' => $donnees['num_portee']))->response->datas;
			
			if(is_array($portee))
			{
				// Mettre à jour
				echo "A mettre à jour => \n";
			}
			else
			{
				echo "Absent => ";
				
				$result = $this->_api_v2->addPortee(array(
					'old_id'			=> $donnees['num_portee'],
					'id_pere'			=> $id_pere,
					'id_mere'			=> $id_mere,
					'user'				=> $id_membre,
					'date_accouchement'	=> strtotime($donnees['date_accouchement']),
					'nombres_petits'	=> $donnees['nb_petits'],
					'commentaires'		=> $donnees['info_portee']
				))->response->datas;
				
				if(property_exists($result,'error'))
				{
					echo $result->error."\n";
					
					$this->_events[] = array(
						'id'		=> "Portee ".$donnees['num_portee'],
						'type'		=> "error",
						'details'	=> $result->error
					);
				}
				else
				{
					echo $result."\n";
				}
			}
		}
		
		$req->closeCursor();
	}
	
	  /////////////////////////////////////////////////////////////////////////////
	 //	Fonctions génériques													//
	/////////////////////////////////////////////////////////////////////////////
	
	// Affichage des evenements résultants
	public function printEvents()
	{
		$count = array(
			'error'		=> 0,
			'warning'	=> 0,
			'info'		=> 0
		);

		$return = "";

		$nbr_events = count($this->_events);

		if($nbr_events)
		{
			foreach($this->_events as $event)
			{
				switch($event['type'])
				{
					case "error":
						$count['error']++;
						break;
					case "warning":
						$count['warning']++;
						break;
					case "info":
						$count['info']++;
						break;
				}
			}

			$return = "Le script de conversion viens de se terminer en rencontrant ".$count['error']." erreurs, ".$count['warning']." avertissements et ".$count['info']." evenements informatifs.\n";

			foreach($this->_events as $event)
			{
				switch($event['type'])
				{
					case "error":
						$color = "red";
						break;
					case "warning":
						$color = "orange";
						break;
					case "info":
						$color = "white";
						break;
				}
				$return .= $event['id']." - ".$event['type']." - ".$event['details']."\n";
			}
		}
		else
		{
			$return = "La conversion viens de se terminer sans erreurs ni avertissements.\n\n";
		}
		
		return $return;
	}
}

