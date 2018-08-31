<?php

// Classe pour la gestion de la messagerie SAV
class LORDRAT_MYSQL_SAV{
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
	
	public function addMsg($section,$params)
	{
		switch($section)
		{
			case "rat":
				$datas = $this->addRatMsg($params);
				break;
			default:
				$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function addRatMsg($params)
	{
		$ins = $this->_bdd->prepare("INSERT INTO `sav_messagerie_rat` (`rat`,`user`,`message`,`date_sent`) VALUE(:rat,:user,:message,:date_sent)");
		$ins->execute(array(
			'rat'		=> $params['rat'],
			'user'		=> $params['user'],
			'message'	=> $params['message'],
			'date_sent'	=> time()
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
	
	public function searchMsg($section,$params)
	{
		switch($section)
		{
			case "rat":
				$datas = $this->searchRatMsg($params);
				break;
			default:
				$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function searchRatMsg($params)
	{
		$base = "
		SELECT smr.id id, smr.rat rat, smr.user id_membre, u.pseudo pseudo, u.level level, smr.message message, smr.date_sent date_sent, smr.date_read date_read
		FROM `sav_messagerie_rat` smr
		LEFT JOIN `users` u ON u.id_membre = smr.user";
		
		$select = "";
		
		$query_params = NULL;
		
		if(!is_null($params['rat']))
		{
			if(empty($select))
			{
				$query_params = array();
				$select = " WHERE smr.rat = :rat";
			}
			else
			{
				$select .= " AND smr.rat > :rat";
			}
			
			$query_params['rat'] = $params['rat'];
		}
		
		if(!is_null($params['user']))
		{
			if(empty($select))
			{
				$query_params = array();
				$select = " WHERE smr.user = :user";
			}
			else
			{
				$select .= " AND smr.user > :user";
			}
			
			$query_params['user'] = $params['user'];
		}
		
		if($params['recent'])
		{
			if(empty($select))
			{
				$query_params = array();
				$select = " WHERE smr.date_sent > :date_start";
			}
			else
			{
				$select .= " AND smr.date_sent > :date_start";
			}
			
			$query_params['date_start'] = time() - (3600 * 24 * 15);
		}
		
		$order = " ORDER BY smr.date_sent DESC";
		
		$query = $base.$select.$order;
		
		error_log("params : ".print_r($query_params,TRUE)." - query : ".print_r($query,TRUE));
		
		$req = $this->_bdd->prepare($query);
		$req->execute($query_params);
		
		if($req->rowCount())
		{
			$datas = array();
			
			while($donnees = $req->fetch())
			{
				$datas[] = array(
					'id'		=> $donnees['id'],
					'rat'		=> $donnees['rat'],
					'user'		=> array(
						'id_membre'	=> $donnees['id_membre'],
						'level'		=> $donnees['level'],
						'pseudo'	=> $donnees['pseudo']
					),
					'message'	=> nl2br($donnees['message']),
					'date_sent'	=> array(
						'raw'		=> $donnees['date_sent'],
						'string'	=> date('d/m/Y à H:i',$donnees['date_sent'])
					),
					'date_read'	=> array(
						'raw'		=> $donnees['date_read'],
						'string'	=> date('d/m/Y à H:i',$donnees['date_read'])
					)
				);
			}
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_NO_RESULTS);
		}
		
		return $datas;
	}
	
	public function status($section,$params)
	{
		switch($section)
		{
			case "rat":
				$datas = $this->statusRat($params);
				break;
			default:
				$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				break;
		}
		
		return $datas;
	}
	
	private function statusRat($params)
	{
		if($params['status'])
		{
			$upt = $this->_bdd->prepare("UPDATE `rats` SET `etat` = 1 WHERE `id` = :rat");
		}
		else
		{
			$upt = $this->_bdd->prepare("UPDATE `rats` SET `etat` = 2 WHERE `id` = :rat");
		}
		
		$upt->execute(array('rat' => $params['rat']));
		
		if($upt->rowCount())
		{
			$datas = "success";
		}
		else
		{
			$datas = array('error' => LORDRAT_ERROR_UPDATE_NO_CHANGE);
		}
		
		return $datas;
	}
}

