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
