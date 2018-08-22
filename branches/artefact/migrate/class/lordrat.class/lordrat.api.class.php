<?php

class LORDRAT_API{
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
	
	// Gestion des sections
	
	public function getSection($id)
	{
		$params = array(
			"id"		=> $id
		);
		
		$datas = $this->query("sections/get",$params);
		
		return $datas;
	}
	
	public function listSections($content = "full")
	{
		$params = array(
			"content"	=> $content
		);
		
		$datas = $this->query("sections/list",$params);
		
		return $datas;
	}
	
	// Gestion des articles
	
	public function getArticle($id)
	{
		$params = array(
			"id"		=> $id
		);
		
		$datas = $this->query("articles/get",$params);
		
		return $datas;
	}
	
	public function listArticles($order = NULL, $content = "full", $auteur = NULL, $section = NULL)
	{
		$params = array(
			"order"		=> $order,
			"content"	=> $content,
			"auteur"	=> $auteur,
			"section"	=> $section
		);
		
		$datas = $this->query("articles/list",$params);
		
		return $datas;
	}
	
	// Gestion des Medias
	
	public function addMedia($params)
	{
		$datas = $this->query("medias/add",$params);
		
		return $datas;
	}
	
	public function deleteCriteres($critere,$params)
	{
		$datas = $this->query("criteres/delete/".$critere,$params);
		
		return $datas;
	}
	
	public function deleteMedia($params)
	{
		$datas = $this->query("medias/delete",$params);
		
		return $datas;
	}
	
	public function getMedia($params)
	{
		$datas = $this->query("medias/get",$params);
		
		return $datas;
	}
	
	public function listMedias($params = array())
	{
		$datas = $this->query("medias/list",$params);
		
		return $datas;
	}
	
	public function saveCriteres($critere,$params)
	{
		$datas = $this->query("criteres/save/".$critere,$params);
		
		return $datas;
	}
	
	public function saveMedia($params)
	{
		$datas = $this->query("medias/save",$params);
		
		return $datas;
	}
	
	public function searchMedias($params)
	{
		$datas = $this->query("medias/search",$params);
		
		return $datas;
	}
	
	// Gestion des utilisateurs
	
	public function addUser($section,$params)
	{
		switch($section)
		{
			case "adresse":
				$datas = $this->query("utilisateurs/add/adresse",$params);
				break;
			case "base":
				$datas = $this->query("utilisateurs/add/base",$params);
				break;
			case "nom":
				$datas = $this->query("utilisateurs/add/nom",$params);
				break;
			case "site":
				$datas = $this->query("utilisateurs/add/site",$params);
				break;
			case "default":
				$datas = array("error" => "Missing Section");
				break;
		}
		
		return $datas;
	}
	
	public function getUtilisateur($section,$params,$debug = FALSE)
	{
		$datas = $this->query("utilisateurs/get/".$section,$params,"POST",$debug);
		
		return $datas;
	}
	
	public function listUsers($order = "!id",$content = "list",$start = 0,$quantity = 25)
	{
		$params = array(
			"order"		=> $order,
			"content"	=> $content,
			"start"		=> $start,
			"quantity"	=> $quantity
		);
		
		$datas = $this->query("utilisateurs/list",$params);
		
		return $datas;
	}
	
	public function saveUser($section,$params = array())
	{
		$datas = $this->query("utilisateurs/save/".$section,$params);
		
		return $datas;
	}
	
	// Gestion des rateries
	
	public function addRaterie($section,$params)
	{
		$datas = $this->query("rateries/add/".$section,$params);
		
		return $datas;
	}
	
	public function countRateries()
	{
		$datas = $this->query("rateries/count");
		
		return $datas;
	}
	
	public function getRaterie($section,$params)
	{	
		$datas = $this->query("rateries/get/".$section,$params);
		
		return $datas;
	}
	
	public function listRateries($order,$content,$start,$quantity)
	{
		$params = array(
			"order"		=> $order,
			"content"	=> $content,
			"start"		=> $start,
			"quantity"	=> $quantity
		);
		
		$datas = $this->query("rateries/list",$params);
		
		return $datas;
	}
	
	// Gestion des criteres
	
	public function addCriteres($critere,$params)
	{
		$datas = $this->query("criteres/add/".$critere,$params);
		
		return $datas;
	}
	
	// Gestion des portées
	
	public function addPortee($params)
	{
		$datas = $this->query("portees/add",$params);
		
		return $datas;
	}
	
	public function getPortee($params)
	{
		$datas = $this->query("portees/get",$params);
		
		return $datas;
	}
	
	// Gestion des rats
	
	public function addRat($section,$params)
	{
		$datas = $this->query("rats/add/".$section,$params);
		
		return $datas;
	}
	
	public function getRat($section,$params)
	{
		$datas = $this->query("rats/get/".$section,$params);
		
		return $datas;
	}
	
	public function listRats($order = "!id",$content = "list",$start = 0,$quantity = 25)
	{
		$params = array(
			"order"		=> $order,
			"content"	=> $content,
			"start"		=> $start,
			"quantity"	=> $quantity
		);
		
		$datas = $this->query("rats/list",$params);
		
		return $datas;
	}
	
	public function saveRat($section,$params)
	{
		$datas = $this->query("rats/save/".$section,$params);
		
		return $datas;
	}
	
	// Gestion des criteres
	
	public function getCriteres($critere,$param)
	{
		if(array_key_exists('id',$param))
		{
			$params = array(
				"id"		=> $param['id']
			);
		}
		else if(array_key_exists('nom',$param))
		{
			$params = array(
				"nom"		=> $param['nom']
			);
		}
		else
		{
			$params = NULL;
		}
		
		$datas = $this->query("criteres/get/".$critere,$params);
		
		return $datas;
	}
	
	public function listCriteres($critere,$order,$content,$start,$quantity)
	{
		$params = array(
			"order"		=> $order,
			"content"	=> $content,
			"start"		=> $start,
			"quantity"	=> $quantity
		);
		
		$datas = $this->query("criteres/list/".$critere,$params);
		
		return $datas;
	}
	
	public function moveCriteres($critere,$params)
	{
		$datas = $this->query("criteres/move/".$critere,$params);
		
		return $datas;
	}
	
	// Statistiques
	public function getStats($section,$params = array())
	{
		$datas = $this->query("stats/get/".$section,$params)->response->datas;
		
		if(is_array($datas))
		{
			$result = $datas[0];
		}
		else
		{
			$result = $datas;
		}
		
		return $result;
	}
	
	// Execution des requètes
	private function query($request,$params = array(),$method = "POST",$debug = FALSE)
	{
		// Création de l'uri de requête
		$query_url = $this->_api['url'].$request;
		
		// Insertion des indentifiant de l'API
		$params['app']	= $this->_api['app'];
		$params['key']	= $this->_api['key'];
		
		// Préparation des paramètres pour transfer
		$params_string = http_build_query($params);
		
		// Si method GET envoi des paramètres
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
		curl_setopt($ch, CURLOPT_ENCODING, "UTF-8" );

		if($method == "POST")
		{
			curl_setopt($ch,CURLOPT_POST, count($params));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $params_string);
		}

		$response = curl_exec($ch);
		curl_close($ch);

		if($debug)
		{
			echo "Query (".$method.") : ".$query_url." | Params : ".$params_string." | Response : ".$response."\n";
		}

		return json_decode($response);
	}
	
	public function searchRat($params)
	{
		$datas = $this->query("rats/list",$params)->response->datas;
		
		$result = $datas;
		
		return $result;
	}
}

