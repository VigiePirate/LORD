<?php

// Execution de la requète
switch($query['module'])
{
	case "articles":
		switch($query['method'])
		{
			case "add":
				$datas = "Comming Soon ;)";
				break;
			case "get":
				if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array('id' => filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT));
				}
				else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array('id' => filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT));
				}
				else if(!empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array('nom' => filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING));
				}
				else if(!empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array('nom' => filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING));
				}

				if(!empty($query['params']))
				{
					$datas = $lord->getArticle($query['params']);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "delete":
				$datas = "Comming Soon ;)";
				break;
			case "list":
				if(!empty(filter_input(INPUT_GET,'auteur',FILTER_SANITIZE_STRING)))
				{
					$auteur = filter_input(INPUT_GET,'auteur',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'auteur',FILTER_SANITIZE_STRING)))
				{
					$auteur = filter_input(INPUT_POST,'auteur',FILTER_SANITIZE_STRING);
				}
				else
				{
					$auteur = NULL;
				}
				
				if(!empty(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING)))
				{
					$content = filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)))
				{
					$content = filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING);
				}
				else
				{
					$content = "list";
				}
				
				if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)))
				{
					$order = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING)))
				{
					$order = filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING);
				}
				else
				{
					$order = "ordre";
				}
				
				if(!empty(filter_input(INPUT_GET,'section',FILTER_SANITIZE_STRING)))
				{
					$section = filter_input(INPUT_GET,'section',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'section',FILTER_SANITIZE_STRING)))
				{
					$section = filter_input(INPUT_POST,'section',FILTER_SANITIZE_STRING);
				}
				else
				{
					$section = NULL;
				}
				
				$query['params'] = array(
					"auteur"	=> $auteur,
					"content"	=> $content,
					"order"		=> $order,
					"section"	=> $section
				);
				$datas = $lord->listArticles($query['params']);
				break;
			case "save":
				$datas = "Comming Soon ;)";
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "criteres":
		$criteres_valides = array("causesdeces","couleurs","dilutions","marquages","oreilles","pbsantes","poils","uniques","yeux");
		switch($query['method'])
		{
			case "add":
				if(in_array($query['section'],$criteres_valides))
				{
					if(!empty(filter_input(INPUT_GET,'nom')))
					{
						$query['params'] = array(
							"nom"	=> replace_code(filter_input(INPUT_GET,'nom'))
						);
						
						$datas = $lord->addCriteres($query['section'],$query['params']);
					}
					else if(!empty(filter_input(INPUT_POST,'nom')))
					{
						$query['params'] = array(
							"nom"	=> replace_code(filter_input(INPUT_POST,'nom'))
						);
						
						$datas = $lord->addCriteres($query['section'],$query['params']);
					}
					else
					{
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
					}
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "delete":
				if(in_array($query['section'],$criteres_valides))
				{
					if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
					{
						$query['params'] = array(
							"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
						);
						
						$datas = $lord->deleteCriteres($query['section'],$query['params']);
					}
					else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
					{
						$query['params'] = array(
							"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
						);
						
						$datas = $lord->deleteCriteres($query['section'],$query['params']);
					}
					else
					{
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
					}
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "get":
				if(in_array($query['section'],$criteres_valides))
				{
					if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
					{
						$query['params'] = array(
							"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
						);
						
						$datas = $lord->getCriteres($query['section'],$query['params']);
					}
					else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
					{
						$query['params'] = array(
							"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
						);
						
						$datas = $lord->getCriteres($query['section'],$query['params']);
					}
					else if(!empty(filter_input(INPUT_GET,'nom')))
					{
						$query['params'] = array(
							"nom"	=> replace_code(filter_input(INPUT_GET,'nom'))
						);
						
						$datas = $lord->getCriteres($query['section'],$query['params']);
					}
					else if(!empty(filter_input(INPUT_POST,'nom')))
					{
						$query['params'] = array(
							"nom"	=> replace_code(filter_input(INPUT_POST,'nom'))
						);
						
						$datas = $lord->getCriteres($query['section'],$query['params']);
					}
					else
					{
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
					}
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "list":
				if(in_array($query['section'],$criteres_valides))
				{
					$query['params'] = array(
						"order"		=> 'nom',
						"content"	=> 'full',
						"start"		=> 0,
						"quantity"	=> 50000
					);
					
					// Réccupération de l'ordre d'affichage si spécifié
					if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)))
					{
						$query['params']['order'] = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
					}
					else if(!empty(filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING)))
					{
						$query['params']['order'] = filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING);
					}

					// Réccupération du type de contenu si spécifié
					if(!empty(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING)))
					{
						$query['params']['content'] = filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING);
					}
					else if(!empty(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)))
					{
						$query['params']['content'] = filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING);
					}

					// Réccupération du début si spécifié
					if(!empty(filter_input(INPUT_GET,'start',FILTER_SANITIZE_STRING)))
					{
						$query['params']['start'] = filter_input(INPUT_GET,'start',FILTER_SANITIZE_STRING);
					}
					else if(!empty(filter_input(INPUT_POST,'start',FILTER_SANITIZE_STRING)))
					{
						$query['params']['start'] = filter_input(INPUT_POST,'start',FILTER_SANITIZE_STRING);
					}

					// Réccupération du nombre d'éléments si spécifié
					if(!empty(filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_STRING)))
					{
						$query['params']['quantity'] = filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_STRING);
					}
					else if(!empty(filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING)))
					{
						$query['params']['quantity'] = filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING);
					}
					
					$datas = $lord->searchCriteres($query['section'],$query['params']);
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "move":
				if(!empty(filter_input(INPUT_POST,'source',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'cible',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'source'	=> filter_input(INPUT_POST,'source',FILTER_SANITIZE_NUMBER_INT),
						'cible'		=> filter_input(INPUT_POST,'cible',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->moveCriteres($query['section'],$query['params']);
				}
				else if(!empty(filter_input(INPUT_GET,'source',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'cible',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'source'	=> filter_input(INPUT_GET,'source',FILTER_SANITIZE_NUMBER_INT),
						'cible'		=> filter_input(INPUT_GET,'cible',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->moveCriteres($query['section'],$query['params']);
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "save":
				if(in_array($query['section'],$criteres_valides))
				{
					if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
					{
						$query['params'] = array(
							'id'		=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT),
							'nom'		=> filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)
						);
						
						$datas = $lord->saveCriteres($query['section'],$query['params']);
					}
					else if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
					{
						$query['params'] = array(
							'id'		=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT),
							'nom'		=> filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)
						);
						
						$datas = $lord->saveCriteres($query['section'],$query['params']);
					}
					else
					{
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
					}
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "medias":
		switch($query['method'])
		{
			case "add":
				if(!empty(filter_input(INPUT_POST,'fichier',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'auteur',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'fichier'	=> filter_input(INPUT_POST,'fichier',FILTER_SANITIZE_STRING),
						'nom'		=> filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING),
						'desc'		=> filter_input(INPUT_POST,'desc'),									// Peut être vide
						'auteur'	=> filter_input(INPUT_POST,'auteur',FILTER_SANITIZE_NUMBER_INT),
						'meta'		=> filter_input(INPUT_POST,'meta')									// Peut être vide
					);
					
					$datas = $lord->addMedia($query['params']);
				}
				else if(!empty(filter_input(INPUT_GET,'fichier',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'auteur',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'fichier'	=> filter_input(INPUT_GET,'fichier',FILTER_SANITIZE_STRING),
						'nom'		=> filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING),
						'desc'		=> filter_input(INPUT_GET,'desc'),									// Peut être vide
						'auteur'	=> filter_input(INPUT_GET,'auteur',FILTER_SANITIZE_NUMBER_INT),
						'meta'		=> filter_input(INPUT_GET,'meta')									// Peut être vide
					);
					
					$datas = $lord->addMedia($query['params']);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "delete":
				if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'id'	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
					);
				
					$datas = $lord->deleteMedia($query['params']);
				}
				else if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'id'	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
					);
				
					$datas = $lord->deleteMedia($query['params']);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "get":
				if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'id'	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
					);
				
					$datas = $lord->getMedia($query['params']);
				}
				else if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'id'	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
					);
				
					$datas = $lord->getMedia($query['params']);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "list":
				$query['params'] = array(
					"order"		=> 'affixe',
					"content"	=> 'full',
					"start"		=> 0,
					"quantity"	=> 50000
				);
				
				// Réccupération de l'ordre d'affichage si spécifié
				if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)))
				{
					$query['params']['order'] = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING)))
				{
					$query['params']['order'] = filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING);
				}
				
				// Réccupération du type de contenu si spécifié
				if(!empty(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING)))
				{
					$query['params']['content'] = filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)))
				{
					$query['params']['content'] = filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING);
				}
				
				// Réccupération du début si spécifié
				if(!empty(filter_input(INPUT_GET,'start',FILTER_SANITIZE_STRING)))
				{
					$query['params']['start'] = filter_input(INPUT_GET,'start',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'start',FILTER_SANITIZE_STRING)))
				{
					$query['params']['start'] = filter_input(INPUT_POST,'start',FILTER_SANITIZE_STRING);
				}
				
				// Réccupération du nombre d'éléments si spécifié
				if(!empty(filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_STRING)))
				{
					$query['params']['quantity'] = filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING)))
				{
					$query['params']['quantity'] = filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING);
				}
				
				$datas = $lord->searchMedias($query['params']);
				break;
			case "save":
				$query['params'] = NULL;
				
				$datas = $lord->saveMedia($query['params']);
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "portees":
		switch($query['method'])
		{
			case "add":
				if(!empty(filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT)) OR (!empty(filter_input(INPUT_GET,'id_pere',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'id_mere',FILTER_SANITIZE_NUMBER_INT))))
				{
					$params = array(
						'old_id'			=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT),				// Peut être vide
						'id_pere'			=> filter_input(INPUT_GET,'id_pere',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide si mère déclarée
						'id_mere'			=> filter_input(INPUT_GET,'id_mere',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide si père déclaré
						'user'				=> filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT),
						'date_accouchement'	=> filter_input(INPUT_GET,'date_accouchement',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
						'nombres_petits'	=> filter_input(INPUT_GET,'nombres_petits',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
						'commentaires'		=> filter_input(INPUT_GET,'commentaires',FILTER_SANITIZE_STRING)		// Peut être vide
					);
					
					$datas = $lord->addPortee($params);
				}
				else if(!empty(filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT)) OR (!empty(filter_input(INPUT_POST,'id_pere',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'id_mere',FILTER_SANITIZE_NUMBER_INT))))
				{
					$params = array(
						'old_id'			=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
						'id_pere'			=> filter_input(INPUT_POST,'id_pere',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide si mère déclarée
						'id_mere'			=> filter_input(INPUT_POST,'id_mere',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide si père déclaré
						'user'				=> filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT),
						'date_accouchement'	=> filter_input(INPUT_POST,'date_accouchement',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
						'nombres_petits'	=> filter_input(INPUT_POST,'nombres_petits',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
						'commentaires'		=> filter_input(INPUT_POST,'commentaires',FILTER_SANITIZE_STRING)		// Peut être vide
					);
					
					$datas = $lord->addPortee($params);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "get":
				if(!empty(filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$params = array(
						'old_id'	=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->getPortee($params);
				}
				else if(!empty(filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$params = array(
						'old_id'	=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->getPortee($params);
				}
				else if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$params = array(
						'id'	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->getPortee($params);
				}
				else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$params = array(
						'id'	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->getPortee($params);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "delete":
				$datas = "Comming Soon ;)";
				break;
			case "list":
				$datas = "Comming Soon ;)";
				break;
			case "save":
				$datas = "Comming Soon ;)";
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "rateries":
		switch($query['method'])
		{
			case "add":
				//$datas = "success";
				switch($query['section'])
				{
					case "base":
						if(!empty(filter_input(INPUT_GET,'affixe',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide si raterie gérée Système
								"affixe"			=> replace_code(filter_input(INPUT_GET,'affixe',FILTER_SANITIZE_STRING)),
								"nom"				=> replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)),
								"presentation"		=> replace_code(filter_input(INPUT_GET,'presentation',FILTER_SANITIZE_STRING)),		// Peut être vide
								"logo"				=> filter_input(INPUT_GET,'logo',FILTER_SANITIZE_STRING),				// Peut être vide
								"status"			=> filter_input(INPUT_GET,'status',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
								"on_map"			=> filter_input(INPUT_GET,'on_map',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
								"date_ajout"		=> filter_input(INPUT_GET,'date_ajout',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"date_last_edit"	=> filter_input(INPUT_GET,'date_last_edit',FILTER_SANITIZE_NUMBER_INT)	// Peut être vide
							);
							$datas = $lord->addRaterie("base",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'affixe',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide si raterie gérée Système
								"affixe"			=> replace_code(filter_input(INPUT_POST,'affixe',FILTER_SANITIZE_STRING)),
								"nom"				=> replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)),
								"presentation"		=> replace_code(filter_input(INPUT_POST,'presentation',FILTER_SANITIZE_STRING)),		// Peut être vide
								"logo"				=> filter_input(INPUT_POST,'logo',FILTER_SANITIZE_STRING),				// Peut être vide
								"status"			=> filter_input(INPUT_POST,'status',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"on_map"			=> filter_input(INPUT_POST,'on_map',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"date_ajout"		=> filter_input(INPUT_POST,'date_ajout',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"date_last_edit"	=> filter_input(INPUT_POST,'date_last_edit',FILTER_SANITIZE_NUMBER_INT)	// Peut être vide
							);
							$datas = $lord->addRaterie("base",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
				break;
			case "count":
				$datas = $lord->countRateries();
				break;
			case "delete":
				$datas = "Comming Soon ;)";
				break;
			case "get":
				switch($query['section'])
				{
					case "base":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'affixe',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_GET,'proprio',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT),
								"affixe"	=> replace_code(filter_input(INPUT_GET,'affixe',FILTER_SANITIZE_STRING)),
								"proprio"	=> filter_input(INPUT_GET,'proprio',FILTER_SANITIZE_NUMBER_INT)
							);

							$datas = $lord->getRaterie("base",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'affixe',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_POST,'proprio',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT),
								"affixe"	=> replace_code(filter_input(INPUT_POST,'affixe',FILTER_SANITIZE_STRING)),
								"proprio"	=> filter_input(INPUT_POST,'proprio',FILTER_SANITIZE_NUMBER_INT)
							);

							$datas = $lord->getRaterie("base",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
				break;
			case "list":
				$query['params'] = array(
					"order"		=> 'affixe',
					"content"	=> 'full',
					"start"		=> 0,
					"quantity"	=> 50000
				);
				
				// Réccupération de l'ordre d'affichage si spécifié
				if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)))
				{
					$query['params']['order'] = replace_code(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING));
				}
				else if(!empty(filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING)))
				{
					$query['params']['order'] = replace_code(filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING));
				}
				
				// Réccupération du type de contenu si spécifié
				if(!empty(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING)))
				{
					$query['params']['content'] = replace_code(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING));
				}
				else if(!empty(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)))
				{
					$query['params']['content'] = replace_code(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING));
				}
				
				// Réccupération du début si spécifié
				if(!empty(filter_input(INPUT_GET,'start',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params']['start'] = filter_input(INPUT_GET,'start',FILTER_SANITIZE_NUMBER_INT);
				}
				else if(!empty(filter_input(INPUT_POST,'start',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params']['start'] = filter_input(INPUT_POST,'start',FILTER_SANITIZE_NUMBER_INT);
				}
				
				// Réccupération du nombre d'éléments si spécifié
				if(!empty(filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params']['quantity'] = filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_NUMBER_INT);
				}
				else if(!empty(filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params']['quantity'] = filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_NUMBER_INT);
				}
				
				
				$datas = $lord->searchRateries($query['params']);
				break;
			case "map":
				if(!empty(filter_input(INPUT_POST,'toggle',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_STRING)))
				{
					$datas = $lord->toggleMapRaterie(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT));
				}
				else
				{
					$datas = $lord->mapRateries();
				}
				break;
			case "save":
				$datas = "Comming Soon ;)";
				break;
			case "search":
				$datas = "Comming Soon ;)";
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "rats":
		switch($query['method'])
		{
			case "add":
				switch($query['section'])
				{
					case "base":
						if(!empty(filter_input(INPUT_GET,'nom_naissance',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'sexe',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"raterie"			=> filter_input(INPUT_GET,'raterie',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"nom_courant"		=> replace_code(filter_input(INPUT_GET,'nom_courant',FILTER_SANITIZE_STRING)),								// Peut être vide
								"nom_naissance"		=> replace_code(filter_input(INPUT_GET,'nom_naissance',FILTER_SANITIZE_STRING)),
								"sexe"				=> replace_code(filter_input(INPUT_GET,'sexe',FILTER_SANITIZE_STRING)),
								"numero"			=> replace_code(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING)),
								"pere"				=> filter_input(INPUT_GET,'pere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"mere"				=> filter_input(INPUT_GET,'mere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"vivant"			=> replace_code(filter_input(INPUT_GET,'vivant',FILTER_SANITIZE_STRING)),									// Peut être vide
								"pb_santes"			=> filter_input(INPUT_GET,'pb_santes',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"date_naissance"	=> filter_input(INPUT_GET,'date_naissance',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"date_deces"		=> filter_input(INPUT_GET,'date_deces',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"cause_deces"		=> filter_input(INPUT_GET,'cause_deces',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"user"				=> filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"couleur"			=> filter_input(INPUT_GET,'couleur',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"dilution"			=> filter_input(INPUT_GET,'dilution',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"marquage"			=> filter_input(INPUT_GET,'marquage',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"oreilles"			=> filter_input(INPUT_GET,'oreilles',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"poils"				=> filter_input(INPUT_GET,'poils',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"uniques"			=> json_encode(filter_input(INPUT_GET,'uniques',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY)),																		// Peut être vide
								"yeux"				=> filter_input(INPUT_GET,'yeux',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"portee"			=> filter_input(INPUT_GET,'portee',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"repro"				=> replace_code(filter_input(INPUT_GET,'repro',FILTER_SANITIZE_STRING)),									// Peut être vide
								"repro_date"		=> filter_input(INPUT_GET,'repro_date',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"commentaires"		=> replace_code(filter_input(INPUT_GET,'commentaires',FILTER_SANITIZE_STRING)),								// Peut être vide
								"date_ajout"		=> filter_input(INPUT_GET,'date_ajout',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"date_user_view"	=> filter_input(INPUT_GET,'date_user_view',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"date_last_edit"	=> filter_input(INPUT_GET,'date_last_edit',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"sav_check"			=> replace_code(filter_input(INPUT_GET,'sav_check',FILTER_SANITIZE_STRING)),								// Peut être vide
								"etat"				=> filter_input(INPUT_GET,'etat',FILTER_SANITIZE_NUMBER_INT)												// Peut être vide
							);
							$datas = $lord->addRat("base",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'nom_naissance',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"raterie"			=> filter_input(INPUT_POST,'raterie',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"nom_courant"		=> replace_code(filter_input(INPUT_POST,'nom_courant',FILTER_SANITIZE_STRING)),		// Peut être vide
								"nom_naissance"		=> replace_code(filter_input(INPUT_POST,'nom_naissance',FILTER_SANITIZE_STRING)),
								"sexe"				=> replace_code(filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING)),
								"numero"			=> replace_code(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING)),
								"pere"				=> filter_input(INPUT_POST,'pere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"mere"				=> filter_input(INPUT_POST,'mere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"vivant"			=> replace_code(filter_input(INPUT_POST,'vivant',FILTER_SANITIZE_STRING)),												// Peut être vide
								"pb_santes"			=> filter_input(INPUT_POST,'pb_santes',FILTER_SANITIZE_NUMBER_INT),								// Peut être vide
								"date_naissance"	=> filter_input(INPUT_POST,'date_naissance',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"date_deces"		=> filter_input(INPUT_POST,'date_deces',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"cause_deces"		=> filter_input(INPUT_POST,'cause_deces',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"user"				=> filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"couleur"			=> filter_input(INPUT_POST,'couleur',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"dilution"			=> filter_input(INPUT_POST,'dilution',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"marquage"			=> filter_input(INPUT_POST,'marquage',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"oreilles"			=> filter_input(INPUT_POST,'oreilles',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"poils"				=> filter_input(INPUT_POST,'poils',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"uniques"			=> json_encode(filter_input(INPUT_POST,'uniques',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY)),									// Peut être vide
								"yeux"				=> filter_input(INPUT_POST,'yeux',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"portee"			=> filter_input(INPUT_POST,'portee',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"repro"				=> replace_code(filter_input(INPUT_POST,'repro',FILTER_SANITIZE_STRING)),													// Peut être vide
								"repro_date"		=> filter_input(INPUT_POST,'repro_date',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"commentaires"		=> replace_code(filter_input(INPUT_POST,'commentaires',FILTER_SANITIZE_STRING)),		// Peut être vide
								"date_ajout"		=> filter_input(INPUT_POST,'date_ajout',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"date_user_view"	=> filter_input(INPUT_POST,'date_user_view',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"date_last_edit"	=> filter_input(INPUT_POST,'date_last_edit',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"sav_check"			=> replace_code(filter_input(INPUT_POST,'sav_check',FILTER_SANITIZE_STRING)),			// Peut être vide
								"etat"				=> filter_input(INPUT_POST,'etat',FILTER_SANITIZE_NUMBER_INT)												// Peut être vide
							);
							$datas = $lord->addRat("base",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "image":
						if(!empty(filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'fichier',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_rat"			=> filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"fichier"			=> replace_code(filter_input(INPUT_GET,'fichier',FILTER_SANITIZE_STRING)),
								"status"			=> filter_input(INPUT_GET,'status',FILTER_SANITIZE_NUMBER_INT),
								"date_ajout"		=> filter_input(INPUT_GET,'date_ajout',FILTER_SANITIZE_NUMBER_INT),
								"date_user_view"	=> filter_input(INPUT_GET,'date_user_view',FILTER_SANITIZE_NUMBER_INT),
								"date_last_edit"	=> filter_input(INPUT_GET,'date_last_edit',FILTER_SANITIZE_NUMBER_INT)
							);
							
							$datas = $lord->addRat("image",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'fichier',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_rat"			=> filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"fichier"			=> replace_code(filter_input(INPUT_POST,'fichier',FILTER_SANITIZE_STRING)),
								"status"			=> filter_input(INPUT_POST,'status',FILTER_SANITIZE_NUMBER_INT),
								"date_ajout"		=> filter_input(INPUT_POST,'date_ajout',FILTER_SANITIZE_NUMBER_INT),
								"date_user_view"	=> filter_input(INPUT_POST,'date_user_view',FILTER_SANITIZE_NUMBER_INT),
								"date_last_edit"	=> filter_input(INPUT_POST,'date_last_edit',FILTER_SANITIZE_NUMBER_INT)
							);
							
							$datas = $lord->addRat("image",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
				break;
			case "get":
				switch($query['section'])
				{
					case "base":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("base",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("base",$query['params']);
						}
						else if(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING))
						{
							$query['params'] = array(
								"numero"	=> replace_code(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING))
							);
							$datas = $lord->getRat("base",$query['params']);
						}
						else if(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING))
						{
							$query['params'] = array(
								"numero"	=> replace_code(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING))
							);
							$datas = $lord->getRat("base",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "descendance":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("descendance",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("descendance",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "full":
						echo "Comming Soon ;)";
						break;
					case "genealogie":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("genealogie",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("genealogie",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "image":
						if(!empty(filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id_rat"	=> filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("image",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id_rat"	=> filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getRat("image",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
				break;
			case "count":
				if(!empty(filter_input(INPUT_GET,'sav',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						"sav"		=> filter_input(INPUT_GET,'sav',FILTER_SANITIZE_NUMBER_INT)
					);
				}
				else if(!empty(filter_input(INPUT_POST,'sav',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						"sav"		=> filter_input(INPUT_POST,'sav',FILTER_SANITIZE_NUMBER_INT)
					);
				}
				
				$datas = $lord->countRats($query['params']);
				break;
			case "delete":
				$datas = "Comming Soon ;)";
				break;
			case "list": // Fonction de liste et recherches
				// Réccupération des paramètres de filtrages
				if(!empty(filter_input(INPUT_GET,'fastsearch',FILTER_SANITIZE_STRING)))
				{
					$params = array(
						"fastsearch"	=> replace_code(filter_input(INPUT_GET,'fastsearch',FILTER_SANITIZE_STRING))
					);
				}
				else if(!empty(filter_input(INPUT_POST,'fastsearch',FILTER_SANITIZE_STRING)))
				{
					$params = array(
						"fastsearch"	=> replace_code(filter_input(INPUT_POST,'fastsearch',FILTER_SANITIZE_STRING))
					);
				}
				else
				{
					if(!empty(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING)))
					{
						$numero = replace_code(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING));
					}
					else if(!empty(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING)))
					{
						$numero = replace_code(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING));
					}
					else
					{
						$numero = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
					{
						$nom = replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING));
					}
					else if(!empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
					{
						$nom = replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING));
					}
					else
					{
						$nom = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'origine',FILTER_SANITIZE_STRING)))
					{
						$origine = replace_code(filter_input(INPUT_GET,'origine',FILTER_SANITIZE_STRING));
					}
					else if(!empty(filter_input(INPUT_POST,'origine',FILTER_SANITIZE_STRING)))
					{
						$origine = replace_code(filter_input(INPUT_POST,'origine',FILTER_SANITIZE_STRING));
					}
					else
					{
						$origine = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'proprio',FILTER_SANITIZE_STRING)))
					{
						$proprio = replace_code(filter_input(INPUT_GET,'proprio',FILTER_SANITIZE_STRING));
					}
					else if(!empty(filter_input(INPUT_POST,'proprio',FILTER_SANITIZE_STRING)))
					{
						$proprio = replace_code(filter_input(INPUT_POST,'proprio',FILTER_SANITIZE_STRING));
					}
					else
					{
						$proprio = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'sexe',FILTER_SANITIZE_STRING)))
					{
						$sexe = replace_code(filter_input(INPUT_GET,'sexe',FILTER_SANITIZE_STRING));
					}
					else if(!empty(filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING)))
					{
						$sexe = replace_code(filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING));
					}
					else
					{
						$sexe = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'vivant',FILTER_SANITIZE_STRING)))
					{
						$vivant = replace_code(filter_input(INPUT_GET,'vivant',FILTER_SANITIZE_STRING));
					}
					else if(!empty(filter_input(INPUT_POST,'vivant',FILTER_SANITIZE_STRING)))
					{
						$vivant = replace_code(filter_input(INPUT_POST,'vivant',FILTER_SANITIZE_STRING));
					}
					else
					{
						$vivant = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'couleurs',FILTER_SANITIZE_NUMBER_INT)))
					{
						$couleurs = filter_input(INPUT_GET,'couleurs',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'couleurs',FILTER_SANITIZE_NUMBER_INT)))
					{
						$couleurs = filter_input(INPUT_POST,'couleurs',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$couleurs = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'dilutions',FILTER_SANITIZE_NUMBER_INT)))
					{
						$dilutions = filter_input(INPUT_GET,'dilutions',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'dilutions',FILTER_SANITIZE_NUMBER_INT)))
					{
						$dilutions = filter_input(INPUT_POST,'dilutions',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$dilutions = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'marquages',FILTER_SANITIZE_NUMBER_INT)))
					{
						$marquages = filter_input(INPUT_GET,'marquages',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'marquages',FILTER_SANITIZE_NUMBER_INT)))
					{
						$marquages = filter_input(INPUT_POST,'marquages',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$marquages = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'oreilles',FILTER_SANITIZE_NUMBER_INT)))
					{
						$oreilles = filter_input(INPUT_GET,'oreilles',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'oreilles',FILTER_SANITIZE_NUMBER_INT)))
					{
						$oreilles = filter_input(INPUT_POST,'oreilles',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$oreilles = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'poils',FILTER_SANITIZE_NUMBER_INT)))
					{
						$poils = filter_input(INPUT_GET,'poils',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'poils',FILTER_SANITIZE_NUMBER_INT)))
					{
						$poils = filter_input(INPUT_POST,'poils',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$poils = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'uniques',FILTER_SANITIZE_NUMBER_INT)))
					{
						$uniques = filter_input(INPUT_GET,'uniques',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'uniques',FILTER_SANITIZE_NUMBER_INT)))
					{
						$uniques = filter_input(INPUT_POST,'uniques',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$uniques = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'yeux',FILTER_SANITIZE_NUMBER_INT)))
					{
						$yeux = filter_input(INPUT_GET,'yeux',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'yeux',FILTER_SANITIZE_NUMBER_INT)))
					{
						$yeux = filter_input(INPUT_POST,'yeux',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$yeux = NULL;
					}

					if(!empty(filter_input(INPUT_GET,'etat',FILTER_SANITIZE_NUMBER_INT)))
					{
						$etat = filter_input(INPUT_GET,'etat',FILTER_SANITIZE_NUMBER_INT);
					}
					else if(!empty(filter_input(INPUT_POST,'etat',FILTER_SANITIZE_NUMBER_INT)))
					{
						$etat = filter_input(INPUT_POST,'etat',FILTER_SANITIZE_NUMBER_INT);
					}
					else
					{
						$etat = NULL;
					}
					
					$params = array(
						"couleurs"		=> $couleurs,
						"dilutions"		=> $dilutions,
						"marquages"		=> $marquages,
						"nom"			=> $nom,
						"numero"		=> $numero,
						"oreilles"		=> $oreilles,
						"origine"		=> $origine,
						"poils"			=> $poils,
						"proprio"		=> $proprio,
						"etat"			=> $etat,
						"sexe"			=> $sexe,
						"uniques"		=> $uniques,
						"vivant"		=> $vivant,
						"yeux"			=> $yeux
					);
				}
				
				$filters = array(
					"order"			=> "!numero",
					"content"		=> "list",
					"start"			=> 0,
					"quantity"		=> 500
				);
				
				// Réccupération des paramètres d'affichage
				if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)))
				{
					$filters['order'] = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING)))
				{
					$filters['order'] = filter_input(INPUT_POST,'order',FILTER_SANITIZE_STRING);
				}
				
				if(!empty(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING)))
				{
					$filters['content'] = filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)))
				{
					$filters['content'] = filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING);
				}
				
				if(!empty(filter_input(INPUT_GET,'start',FILTER_SANITIZE_STRING)))
				{
					$filters['start'] = filter_input(INPUT_GET,'start',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'start',FILTER_SANITIZE_STRING)))
				{
					$filters['start'] = filter_input(INPUT_POST,'start',FILTER_SANITIZE_STRING);
				}
				
				if(!empty(filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_STRING)))
				{
					$filters['quantity'] = filter_input(INPUT_GET,'quantity',FILTER_SANITIZE_STRING);
				}
				else if(!empty(filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING)))
				{
					$filters['quantity'] = filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_STRING);
				}
				
				$query['params'] = array_merge($params,$filters);
				
				$datas = $lord->searchRats($query['params']);
				break;
			case "sav":
				// Messagerie SAV
				switch($query['section'])
				{
					case "add":
						if(!empty(filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'message',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								'rat'		=> filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT),
								'user'		=> filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT),
								'message'	=> replace_code(filter_input(INPUT_GET,'message',FILTER_SANITIZE_STRING))
							);
							
							$datas = $lord->addSavMsg('rat',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								'rat'		=> filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT),
								'user'		=> filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT),
								'message'	=> replace_code(filter_input(INPUT_POST,'message',FILTER_SANITIZE_STRING))
							);
							
							$datas = $lord->addSavMsg('rat',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "list":
						$query['params'] = array(
							"rat"		=> NULL,
							"user"		=> NULL,
							"recent"	=> FALSE
						);
						
						if(!empty(filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params']['rat'] = filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT);
						}
						else if(!empty(filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params']['rat'] = filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT);
						}
						
						if(!empty(filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params']['user'] = filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT);
						}
						else if(!empty(filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params']['user'] = filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
						}
						
						if(!empty(filter_input(INPUT_GET,'recent',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params']['recent'] = filter_input(INPUT_GET,'recent',FILTER_SANITIZE_NUMBER_INT);
						}
						else if(!empty(filter_input(INPUT_POST,'recent',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params']['recent'] = filter_input(INPUT_POST,'recent',FILTER_SANITIZE_NUMBER_INT);
						}
						
						$datas = $lord->listSavMsg('rat',$query['params']);
						break;
					case "status":
						if(!empty(filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								'rat'		=> filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT),
								'status'	=> filter_input(INPUT_GET,'status',FILTER_SANITIZE_NUMBER_INT)
							);

							$datas = $lord->statusSav('rat',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								'rat'		=> filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT),
								'status'	=> filter_input(INPUT_POST,'status',FILTER_SANITIZE_NUMBER_INT)
							);

							$datas = $lord->statusSav('rat',$query['params']);
						}
						else
						{
							$datas = json_encode("missing");
						}
						break;
					default:
						$datas = array("error" => API_ERROR_WRONG_METHOD);
						break;
				}
				break;
			case "save":
				switch($query['section'])
				{
					case "base":
						if(!empty(filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'nom_naissance',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'sexe',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_rat"			=> filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"raterie"			=> filter_input(INPUT_GET,'raterie',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"nom_courant"		=> replace_code(filter_input(INPUT_GET,'nom_courant',FILTER_SANITIZE_STRING)),		// Peut être vide
								"nom_naissance"		=> replace_code(filter_input(INPUT_GET,'nom_naissance',FILTER_SANITIZE_STRING)),
								"sexe"				=> replace_code(filter_input(INPUT_GET,'sexe',FILTER_SANITIZE_STRING)),
								"numero"			=> replace_code(filter_input(INPUT_GET,'numero',FILTER_SANITIZE_STRING)),
								"pere"				=> filter_input(INPUT_GET,'pere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"mere"				=> filter_input(INPUT_GET,'mere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"vivant"			=> replace_code(filter_input(INPUT_GET,'vivant',FILTER_SANITIZE_STRING)),													// Peut être vide
								"pb_santes"			=> filter_input(INPUT_GET,'pb_santes',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"date_naissance"	=> filter_input(INPUT_GET,'date_naissance',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"date_deces"		=> filter_input(INPUT_GET,'date_deces',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"cause_deces"		=> replace_code(filter_input(INPUT_GET,'cause_deces',FILTER_SANITIZE_NUMBER_INT)),										// Peut être vide
								"user"				=> filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"couleur"			=> filter_input(INPUT_GET,'couleur',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"dilution"			=> filter_input(INPUT_GET,'dilution',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"marquage"			=> filter_input(INPUT_GET,'marquage',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"oreilles"			=> filter_input(INPUT_GET,'oreilles',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"poils"				=> filter_input(INPUT_GET,'poils',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"uniques"			=> json_encode(filter_input(INPUT_GET,'uniques',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY)),									// Peut être vide
								"yeux"				=> filter_input(INPUT_GET,'yeux',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"portee"			=> filter_input(INPUT_GET,'portee',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"repro"				=> replace_code(filter_input(INPUT_GET,'repro',FILTER_SANITIZE_STRING)),													// Peut être vide
								"repro_date"		=> filter_input(INPUT_GET,'repro_date',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"commentaires"		=> replace_code(filter_input(INPUT_GET,'commentaires',FILTER_SANITIZE_STRING)),		// Peut être vide
								"date_ajout"		=> filter_input(INPUT_GET,'date_ajout',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"date_user_view"	=> filter_input(INPUT_GET,'date_user_view',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"date_last_edit"	=> filter_input(INPUT_GET,'date_last_edit',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"sav_check"			=> replace_code(filter_input(INPUT_GET,'sav_check',FILTER_SANITIZE_STRING)),			// Peut être vide
								"etat"				=> filter_input(INPUT_GET,'etat',FILTER_SANITIZE_NUMBER_INT)												// Peut être vide
							);
							$datas = $lord->saveRat("base",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'nom_naissance',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_rat"			=> filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"raterie"			=> filter_input(INPUT_POST,'raterie',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"nom_courant"		=> replace_code(filter_input(INPUT_POST,'nom_courant',FILTER_SANITIZE_STRING)),								// Peut être vide
								"nom_naissance"		=> replace_code(filter_input(INPUT_POST,'nom_naissance',FILTER_SANITIZE_STRING)),
								"sexe"				=> replace_code(filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING)),
								"numero"			=> replace_code(filter_input(INPUT_POST,'numero',FILTER_SANITIZE_STRING)),
								"pere"				=> filter_input(INPUT_POST,'pere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"mere"				=> filter_input(INPUT_POST,'mere',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"vivant"			=> replace_code(filter_input(INPUT_POST,'vivant',FILTER_SANITIZE_STRING)),									// Peut être vide
								"pb_santes"			=> filter_input(INPUT_POST,'pb_santes',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"date_naissance"	=> filter_input(INPUT_POST,'date_naissance',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"date_deces"		=> filter_input(INPUT_POST,'date_deces',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"cause_deces"		=> filter_input(INPUT_POST,'cause_deces',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"user"				=> filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"couleur"			=> filter_input(INPUT_POST,'couleur',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"dilution"			=> filter_input(INPUT_POST,'dilution',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"marquage"			=> filter_input(INPUT_POST,'marquage',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"oreilles"			=> filter_input(INPUT_POST,'oreilles',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"poils"				=> filter_input(INPUT_POST,'poils',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"uniques"			=> json_encode(filter_input(INPUT_POST,'uniques',FILTER_DEFAULT,FILTER_REQUIRE_ARRAY)),						// Peut être vide
								"yeux"				=> filter_input(INPUT_POST,'yeux',FILTER_SANITIZE_NUMBER_INT),												// Peut être vide
								"portee"			=> filter_input(INPUT_POST,'portee',FILTER_SANITIZE_NUMBER_INT),											// Peut être vide
								"repro"				=> replace_code(filter_input(INPUT_POST,'repro',FILTER_SANITIZE_STRING)),									// Peut être vide
								"repro_date"		=> filter_input(INPUT_POST,'repro_date',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"commentaires"		=> replace_code(filter_input(INPUT_POST,'commentaires',FILTER_SANITIZE_STRING)),							// Peut être vide
								"date_ajout"		=> filter_input(INPUT_POST,'date_ajout',FILTER_SANITIZE_NUMBER_INT),										// Peut être vide
								"date_user_view"	=> filter_input(INPUT_POST,'date_user_view',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"date_last_edit"	=> filter_input(INPUT_POST,'date_last_edit',FILTER_SANITIZE_NUMBER_INT),									// Peut être vide
								"sav_check"			=> replace_code(filter_input(INPUT_POST,'sav_check',FILTER_SANITIZE_STRING)),								// Peut être vide
								"etat"				=> filter_input(INPUT_POST,'etat',FILTER_SANITIZE_NUMBER_INT)												// Peut être vide
							);
							
							$datas = $lord->saveRat("base",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "image":
						if(!empty(filter_input(INPUT_GET,'id_photo',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'fichier',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_photo"			=> filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"id_rat"			=> filter_input(INPUT_GET,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"fichier"			=> replace_code(filter_input(INPUT_GET,'fichier',FILTER_SANITIZE_STRING)),
								"status"			=> filter_input(INPUT_GET,'status',FILTER_SANITIZE_NUMBER_INT),
								"date_ajout"		=> filter_input(INPUT_GET,'date_ajout',FILTER_SANITIZE_NUMBER_INT),
								"date_user_view"	=> filter_input(INPUT_GET,'date_user_view',FILTER_SANITIZE_NUMBER_INT),
								"date_last_edit"	=> filter_input(INPUT_GET,'date_last_edit',FILTER_SANITIZE_NUMBER_INT)
							);
							
							$datas = $lord->saveRat("image",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_photo',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'fichier',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_photo"			=> filter_input(INPUT_POST,'id_photo',FILTER_SANITIZE_NUMBER_INT),
								"id_rat"			=> filter_input(INPUT_POST,'id_rat',FILTER_SANITIZE_NUMBER_INT),
								"fichier"			=> replace_code(filter_input(INPUT_POST,'fichier',FILTER_SANITIZE_STRING)),
								"status"			=> filter_input(INPUT_POST,'status',FILTER_SANITIZE_NUMBER_INT),
								"date_ajout"		=> filter_input(INPUT_POST,'date_ajout',FILTER_SANITIZE_NUMBER_INT),
								"date_user_view"	=> filter_input(INPUT_POST,'date_user_view',FILTER_SANITIZE_NUMBER_INT),
								"date_last_edit"	=> filter_input(INPUT_POST,'date_last_edit',FILTER_SANITIZE_NUMBER_INT)
							);
							
							$datas = $lord->saveRat("image",$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "sections":
		switch($query['method'])
		{
			case "get":
				if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array('id' => filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT));
				}
				else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array('id' => filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT));
				}
				else if(!empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array('nom' => replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)));
				}
				else if(!empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array('nom' => replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)));
				}

				if(!empty($query['params']))
				{
					$datas = $lord->getSection($query['params']);
				}
				else
				{
					$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
				}
				break;
			case "list":
				if(!empty(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING)))
				{
					$content = replace_code(filter_input(INPUT_GET,'content',FILTER_SANITIZE_STRING));
				}
				else if(!empty(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING)))
				{
					$content = replace_code(filter_input(INPUT_POST,'content',FILTER_SANITIZE_STRING));
				}
				else
				{
					$content = "list";
				}
				$query['params'] = array(
					"content"	=> $content
				);
				$datas = $lord->listSections($content);
				break;
			case "save":
				$datas = "Comming Soon ;)";
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "stats":
		switch($query['method'])
		{
			case "get":
				switch($query['section'])
				{
					case "base":
						$datas = $lord->getStats("base");
						break;
					default:
						$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						break;
				}
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	case "utilisateurs":
		switch($query['method'])
		{
			case "add":
				switch($query['section'])
				{
					case "adresse":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'cp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'ville',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'pays',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"adresse"			=> replace_code(filter_input(INPUT_GET,'adresse',FILTER_SANITIZE_STRING)),
								"cp"				=> replace_code(filter_input(INPUT_GET,'cp',FILTER_SANITIZE_STRING)),
								"ville"				=> replace_code(filter_input(INPUT_GET,'ville',FILTER_SANITIZE_STRING)),
								"pays"				=> replace_code(filter_input(INPUT_GET,'pays',FILTER_SANITIZE_STRING)),
								"geoname"			=> filter_input(INPUT_GET,'geoname',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"lat"				=> filter_input(INPUT_GET,'lat',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
								"lng"				=> filter_input(INPUT_GET,'lng',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
							);
							$datas = $lord->addUser('adresse',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'cp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'ville',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'pays',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"adresse"			=> replace_code(filter_input(INPUT_POST,'adresse',FILTER_SANITIZE_STRING)),		// Peut être vide
								"cp"				=> replace_code(filter_input(INPUT_POST,'cp',FILTER_SANITIZE_STRING)),
								"ville"				=> replace_code(filter_input(INPUT_POST,'ville',FILTER_SANITIZE_STRING)),
								"pays"				=> replace_code(filter_input(INPUT_POST,'pays',FILTER_SANITIZE_STRING)),
								"geoname"			=> filter_input(INPUT_POST,'geoname',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"lat"				=> filter_input(INPUT_POST,'lat',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
								"lng"				=> filter_input(INPUT_POST,'lng',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
							);
							$datas = $lord->addUser('adresse',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "base":
						if(!empty(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'mdp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'level',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"old_id"			=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT),				// Peut être vide
								"email"				=> replace_code(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)),
								"mdp"				=> replace_code(filter_input(INPUT_GET,'mdp',FILTER_SANITIZE_STRING)),
								"pseudo"			=> replace_code(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)),
								"level"				=> replace_code(filter_input(INPUT_GET,'level',FILTER_SANITIZE_STRING)),
								"date_naissance"	=> filter_input(INPUT_GET,'date_naissance',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"date_inscription"	=> filter_input(INPUT_GET,'date_inscription',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"date_maj"			=> filter_input(INPUT_GET,'date_maj',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
							);
							$datas = $lord->addUser('base',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'mdp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'level',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"old_id"			=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
								"email"				=> replace_code(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)),
								"mdp"				=> replace_code(filter_input(INPUT_POST,'mdp',FILTER_SANITIZE_STRING)),
								"pseudo"			=> replace_code(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)),
								"level"				=> replace_code(filter_input(INPUT_POST,'level',FILTER_SANITIZE_STRING)),
								"date_naissance"	=> filter_input(INPUT_GET,'date_naissance',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"date_inscription"	=> filter_input(INPUT_POST,'date_inscription',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"date_maj"			=> filter_input(INPUT_POST,'date_maj',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
							);
							$datas = $lord->addUser('base',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "nom":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'prenom',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"civilite"	=> filter_input(INPUT_GET,'civilite',FILTER_SANITIZE_NUMBER_INT),
								"prenom"	=> replace_code(filter_input(INPUT_GET,'prenom',FILTER_SANITIZE_STRING)),
								"nom"		=> replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING))
							);
							$datas = $lord->addUser('nom',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'prenom',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"civilite"	=> filter_input(INPUT_POST,'civilite',FILTER_SANITIZE_NUMBER_INT),
								"prenom"	=> replace_code(filter_input(INPUT_POST,'prenom',FILTER_SANITIZE_STRING)),
								"nom"		=> replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING))
							);
							$datas = $lord->addUser('nom',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "site":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"nom"		=> replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)),			// Peut être vide
								"url"		=> filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)
							);
							$datas = $lord->addUser('site',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"nom"		=> replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)),			// Peut être vide
								"url"		=> filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL)
							);
							$datas = $lord->addUser('site',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => API_ERROR_WRONG_METHOD);
						break;
				}
				break;
			case "auth":
				if(!empty(filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL)) AND !empty(filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array(
						"email"		=> replace_code(filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL)),
						"password"	=> replace_code(filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING))
					);
				}
				else if(!empty(filter_input(INPUT_POST,'token',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'client_ip',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array(
						"token"		=> replace_code(filter_input(INPUT_POST,'token',FILTER_SANITIZE_STRING)),
						"client_ip"	=> replace_code(filter_input(INPUT_POST,'client_ip',FILTER_SANITIZE_STRING))
					);
				}
				else
				{
					$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
				}
				
				if(!array_key_exists('error', $datas))
				{
					$datas = $lord->authUser($query['params']);
				}
				break;
			case "get":
				switch($query['section'])
				{
					case "adresse":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getUser("adresse",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getUser("adresse",$query['params']);
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "base":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT),
								"old_id"	=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT),
								"pseudo"	=> replace_code(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)),
								"email"		=> replace_code(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)),
							);
							$datas = $lord->getUser("base",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT),
								"old_id"	=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT),
								"pseudo"	=> replace_code(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)),
								"email"		=> replace_code(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)),
							);
							$datas = $lord->getUser("base",$query['params']);
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "fiche":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getUser("fiche",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getUser("fiche",$query['params']);
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "site":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getUser("site",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
						{
							$query['params'] = array(
								"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
							);
							$datas = $lord->getUser("site",$query['params']);
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "full":
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT),
								"old_id"	=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT),
								"pseudo"	=> replace_code(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)),
								"email"		=> replace_code(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)),
							);
							$datas = $lord->getUser("full",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT),
								"old_id"	=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT),
								"pseudo"	=> replace_code(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)),
								"email"		=> replace_code(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)),
							);
							$datas = $lord->getUser("full",$query['params']);
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT),
								"old_id"	=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT),
								"pseudo"	=> replace_code(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)),
								"email"		=> replace_code(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)),
							);
							$datas = $lord->getUser("full",$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT)) OR !empty(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id"		=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT),
								"old_id"	=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT),
								"pseudo"	=> replace_code(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)),
								"email"		=> replace_code(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)),
							);
							$datas = $lord->getUser("full",$query['params']);
						}
						else
						{
							$datas = array('error' => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
				}
				break;
			case "delete":
				$datas = "Comming Soon ;)";
				break;
			case "list":
				$datas = $lord->searchUsers(NULL);
				break;
			case "save":
				switch($query['section'])
				{
					case "adresse":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'cp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'ville',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'pays',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"adresse"			=> replace_code(filter_input(INPUT_GET,'adresse',FILTER_SANITIZE_STRING)),
								"cp"				=> replace_code(filter_input(INPUT_GET,'cp',FILTER_SANITIZE_STRING)),
								"ville"				=> replace_code(filter_input(INPUT_GET,'ville',FILTER_SANITIZE_STRING)),
								"pays"				=> replace_code(filter_input(INPUT_GET,'pays',FILTER_SANITIZE_STRING)),
								"geoname"			=> filter_input(INPUT_GET,'geoname',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"lat"				=> filter_input(INPUT_GET,'lat',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
								"lng"				=> filter_input(INPUT_GET,'lng',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
							);
							$datas = $lord->saveUser('adresse',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'cp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'ville',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'pays',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"adresse"			=> replace_code(filter_input(INPUT_POST,'adresse',FILTER_SANITIZE_STRING)),		// Peut être vide
								"cp"				=> replace_code(filter_input(INPUT_POST,'cp',FILTER_SANITIZE_STRING)),
								"ville"				=> replace_code(filter_input(INPUT_POST,'ville',FILTER_SANITIZE_STRING)),
								"pays"				=> replace_code(filter_input(INPUT_POST,'pays',FILTER_SANITIZE_STRING)),
								"geoname"			=> filter_input(INPUT_POST,'geoname',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"lat"				=> filter_input(INPUT_POST,'lat',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
								"lng"				=> filter_input(INPUT_POST,'lng',FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION),		// Peut être vide
							);
							$datas = $lord->saveUser('adresse',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "base":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'mdp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'level',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"old_id"			=> filter_input(INPUT_GET,'old_id',FILTER_SANITIZE_NUMBER_INT),				// Peut être vide
								"email"				=> replace_code(filter_input(INPUT_GET,'email',FILTER_SANITIZE_STRING)),
								"mdp"				=> replace_code(filter_input(INPUT_GET,'mdp',FILTER_SANITIZE_STRING)),
								"pseudo"			=> replace_code(filter_input(INPUT_GET,'pseudo',FILTER_SANITIZE_STRING)),
								"level"				=> replace_code(filter_input(INPUT_GET,'level',FILTER_SANITIZE_STRING)),
								"date_naissance"	=> filter_input(INPUT_GET,'date_naissance',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"date_inscription"	=> filter_input(INPUT_GET,'date_inscription',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"date_maj"			=> filter_input(INPUT_GET,'date_maj',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
							);
							$datas = $lord->saveUser('base',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'mdp',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'level',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"			=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"old_id"			=> filter_input(INPUT_POST,'old_id',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
								"email"				=> replace_code(filter_input(INPUT_POST,'email',FILTER_SANITIZE_STRING)),
								"mdp"				=> replace_code(filter_input(INPUT_POST,'mdp',FILTER_SANITIZE_STRING)),
								"pseudo"			=> replace_code(filter_input(INPUT_POST,'pseudo',FILTER_SANITIZE_STRING)),
								"level"				=> replace_code(filter_input(INPUT_POST,'level',FILTER_SANITIZE_STRING)),
								"date_naissance"	=> filter_input(INPUT_GET,'date_naissance',FILTER_SANITIZE_NUMBER_INT),		// Peut être vide
								"date_inscription"	=> filter_input(INPUT_POST,'date_inscription',FILTER_SANITIZE_NUMBER_INT),	// Peut être vide
								"date_maj"			=> filter_input(INPUT_POST,'date_maj',FILTER_SANITIZE_NUMBER_INT),			// Peut être vide
							);
							$datas = $lord->saveUser('base',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "nom":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'prenom',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"civilite"	=> filter_input(INPUT_GET,'civilite',FILTER_SANITIZE_NUMBER_INT),
								"prenom"	=> replace_code(filter_input(INPUT_GET,'prenom',FILTER_SANITIZE_STRING)),
								"nom"		=> replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING))
							);
							$datas = $lord->saveUser('nom',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'prenom',FILTER_SANITIZE_STRING)) AND !empty(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"civilite"	=> filter_input(INPUT_POST,'civilite',FILTER_SANITIZE_NUMBER_INT),
								"prenom"	=> replace_code(filter_input(INPUT_POST,'prenom',FILTER_SANITIZE_STRING)),
								"nom"		=> replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING))
							);
							$datas = $lord->saveUser('nom',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					case "site":
						if(!empty(filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_GET,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"nom"		=> replace_code(filter_input(INPUT_GET,'nom',FILTER_SANITIZE_STRING)),			// Peut être vide
								"url"		=> filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL)
							);
							$datas = $lord->saveUser('site',$query['params']);
						}
						else if(!empty(filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT)) AND !empty(filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL)))
						{
							$query['params'] = array(
								"id_membre"	=> filter_input(INPUT_POST,'id_membre',FILTER_SANITIZE_NUMBER_INT),
								"nom"		=> replace_code(filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING)),			// Peut être vide
								"url"		=> filter_input(INPUT_POST,'url',FILTER_SANITIZE_URL)
							);
							$datas = $lord->saveUser('site',$query['params']);
						}
						else
						{
							$datas = array("error" => LORDRAT_ERROR_MISSING_PARAMS);
						}
						break;
					default:
						$datas = array("error" => API_ERROR_WRONG_METHOD);
						break;
				}
				break;
			default:
				$datas = array("error" => API_ERROR_WRONG_METHOD);
				break;
		}
		break;
	default:
		$datas = array("error" => API_ERROR_WRONG_METHOD);
		break;
}
