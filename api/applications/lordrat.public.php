<?php

switch($query['module'])
{
	case "rateries":
		switch($query['method'])
		{
			case "map":
				if(!empty(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)))
				{
					$query['params'] = array(
						'id'	=> filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT)
					);
					
					$datas = $lord->toggleMapRaterie(filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT));
				}
				else
				{
					$datas = $lord->mapRateries();
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

