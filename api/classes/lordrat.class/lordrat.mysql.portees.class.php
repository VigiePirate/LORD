<?php

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