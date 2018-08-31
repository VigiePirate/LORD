<?php

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