<?php

class GEONAMES_MYSQL{
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
	
	public function getCity($id)
	{
		$req = $this->_bdd->prepare("
		SELECT v.id id, p.alpha alpha, v.cp cp, v.nom ville, v.lat lat, v.lng lng
		FROM `villes` v
		LEFT JOIN `pays` p ON p.id = v.pays
		WHERE v.id = :id");
		$req->execute(array("id" => $id));

		if($req->rowCount())
		{
			$datas = array();
			
			$donnees = $req->fetch();
					
			$datas[] = array(
				"id"	=> $donnees['id'],
				"pays"	=> $donnees['alpha'],
				"cp"	=> $donnees['cp'],
				"ville"	=> $donnees['ville'],
				"lat"	=> $donnees['lat'],
				"lng"	=> $donnees['lng']
			);
		}
		else
		{
			$datas = array("error" => "No Results");
		}
		
		return $datas;
	}
	
	public function searchCity($cp = NULL,$pays = NULL, $ville = NULL,$retry = FALSE)
	{
		$params = array(
			"cp"	=> "%",
			"pays"	=> "%",
			"ville"	=> "%"
		);
		
		$count = 0;
		
		if(!empty($cp))
		{
			if($retry)
			{
				$params['cp'] = "%".$cp."%";
			}
			else
			{
				$params['cp'] = $cp;
			}
			$count++;
		}
		
		if(!empty($pays))
		{
			$params['pays'] = $pays;
			$count++;
		}
		
		if(!empty($ville))
		{
			if($retry)
			{
				$params['ville'] = $ville."%";
			}
			else
			{
				$params['ville'] = $ville;
			}
			$count++;
		}
		
		if($count)
		{
			$req = $this->_bdd->prepare("
			SELECT v.id id, p.alpha alpha, v.cp cp, v.nom ville, v.lat lat, v.lng lng
			FROM `villes` v
			LEFT JOIN `pays` p ON p.id = v.pays
			WHERE v.cp LIKE :cp AND p.alpha LIKE :pays AND v.nom LIKE :ville
			LIMIT 10");
			$req->execute($params);

			if($req->rowCount())
			{
				$datas = array();

				while($donnees = $req->fetch())
				{
					$datas[] = array(
						"id"	=> $donnees['id'],
						"pays"	=> $donnees['alpha'],
						"cp"	=> $donnees['cp'],
						"ville"	=> $donnees['ville'],
						"lat"	=> $donnees['lat'],
						"lng"	=> $donnees['lng']
					);
				}
			}
			else
			{
				if($retry)
				{
					$datas = array("error" => "No Results");
				}
				else
				{
					$datas = $this->searchCity($cp,$pays,$ville,TRUE);
				}
			}
		}
		else
		{
			$datas = array("error" => "Empty Search");
		}
		
		return $datas;
	}
}

