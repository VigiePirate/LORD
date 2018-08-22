<?php


class GEONAMES_API {
	private $_agent	= NULL;
	private $_api	= array(
		"app"	=> NULL,
		"key"	=> NULL,
		"url"	=> NULL
	);
	
	public function __construct($api_app,$api_key,$api_url,$agent)
	{
		$this->_api['app']	= $api_app;
		$this->_api['key']	= $api_key;
		$this->_api['url']	= $api_url;
		$this->_agent		= $agent;
	}
	
	public function get($id)
	{
		$params = array(
			"id"	=> $id
		);
		
		$datas = $this->query("city/get",$params);
		
		return $datas;
	}
	
	public function search($params)
	{
		// Si on ne fournis pas un Array (Code postal fournis) on ne regarde que pour la france
		if(is_array($params))
		{
			$datas = $this->query("city/search",$params);
		}
		else
		{
			$datas = $this->query("city/search",array('pays' => 'FR', 'cp' => $params));
		}
		
		return $datas;
	}

	// Execution des requètes
	private function query($request,$params = array(),$method = "POST",$debug = FALSE)
	{
		// Création de l'uri de requête
		$query_url = $this->_api['url'].$request;
		
		// Insertion des indentifiant de l'API
		$params['app']	= $this->_api['app'];
		$params['key']	= $this->_api['key'];
		
		// On transforme le tableau des paramètres en string
		$params_string = "";

		foreach($params as $key => $value)
		{
			$params_string .= $key.'='.htmlspecialchars($value).'&';
		}

		rtrim($params_string,'&');
		
		if($method == "GET")
		{
			// Si des paramètres sont déja définis on ajoute a la fin
			if(preg_match('/\?/',$query_url))
			{
				$query_url .= "&".$params_string;
			}
			else
			{
				$query_url .= "?".$params_string;
			}
		}
		
		// Requête CURL
		$ch = curl_init($query_url);
		
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, $this->_agent);

		switch($method)
		{
			case "GET":
				break;
			case "POST":
				$params_string = "";

				foreach($params as $key => $value)
				{
					$params_string .= $key.'='.$value.'&';
				}

				rtrim($params_string,'&');

				curl_setopt($ch,CURLOPT_POST, count($params));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
				break;
		}

		$response = curl_exec($ch);
		curl_close($ch);

		if($debug)
		{
			echo "Query (".$method.") : ".$query_url." | Params : ".$params_string." | Response : ".$response."\n";
		}

		return json_decode($response);
	}
}
