<?php

class API_MYSQL {
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
	
	public function checkAuth($app,$key,$ip)
	{
		$req = $this->_bdd->prepare("
		SELECT k.ips
		FROM `api_apps` a
		LEFT JOIN `api_keys` k ON k.application = a.uid
		WHERE a.uid = :app AND k.cle = :cle");
		$req->execute(array(
			"app"	=> $app,
			"cle"	=> $key
		));
		
		if($req->rowCount() == 1)
		{
			$donnees = $req->fetch();
			
			$ips = json_decode($donnees['ips']);
			
			if($ips[0] == '*')
			{
				$datas = "public";
			}
			else
			{
				if(in_array($ip,$ips))
				{
					$datas = "success";
				}
				else
				{
					// ***** $datas = array("error" => API_ERROR_IP_NOT_IN_LIST);
					$datas = "success";
				}
			}
		}
		else
		{
			$datas = array("error" => API_ERROR_AUTH);
		}
		
		return $datas;
	}
}

