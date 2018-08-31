<?php

// Execution de la requête
switch($query['module'])
{
	case "city":
		switch($query['method'])
		{
			case "get":
				if(!empty(filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						"id"	=> filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $geonames->getCity($query['params']['id']);
				}
				else if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						"id"	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $geonames->getCity($query['params']['id']);
				}
				else
				{
					$datas = array("error" => API_ERROR_WRONG_METHOD);
				}
				break;
			case "search":
				if(!empty(filter_input(INPUT_GET,'cp',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_GET,'pays',FILTER_SANITIZE_STRING)) OR !empty(filter_input(INPUT_GET,'ville',FILTER_SANITIZE_STRING)))
				{
					$query['params'] = array(
						"cp"	=> filter_input(INPUT_GET,'cp',FILTER_SANITIZE_STRING),
						"pays"	=> htmlspecialchars_decode(filter_input(INPUT_GET,'pays',FILTER_SANITIZE_STRING),ENT_QUOTES),
						"ville"	=> htmlspecialchars_decode(filter_input(INPUT_GET,'ville',FILTER_SANITIZE_STRING),ENT_QUOTES)
					);
				}
				else
				{
					$query['params'] = array(
						"cp"	=> filter_input(INPUT_POST,'cp',FILTER_SANITIZE_STRING),
						"pays"	=> htmlspecialchars_decode(filter_input(INPUT_POST,'pays',FILTER_SANITIZE_STRING),ENT_QUOTES),
						"ville"	=> htmlspecialchars_decode(filter_input(INPUT_POST,'ville',FILTER_SANITIZE_STRING),ENT_QUOTES)
					);
				}

				$datas = $geonames->searchCity($query['params']['cp'],$query['params']['pays'],$query['params']['ville']);
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

