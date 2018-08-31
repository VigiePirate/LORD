<?php
// Démarrage du moteur de session
session_start();

header('Content-Type: application/json');

require_once($_SESSION['root_path']."core/classes/lordrat.class/lordrat.api.config.php");
require_once($_SESSION['root_path']."core/classes/lordrat.class/lordrat.api.class.php");
require_once($_SESSION['root_path']."core/classes/user.class/user.class.php");

$User = unserialize($_SESSION['login']);
$Lord = new LORDRAT_API(LORDRAT_API_APP,LORDRAT_API_KEY,LORDRAT_API_URL,LORDRAT_AGENT);

if(isset($User->connect) AND $User->connect)
{
	$index = TRUE;

	require_once($_SESSION['root_path'].'core/config.php');
	require_once($_SESSION['root_path'].'core/co_db.php');
	
	if(!empty(filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params = array(
			'rat'		=> filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT),
			'status'	=> filter_input(INPUT_GET,'status',FILTER_SANITIZE_NUMBER_INT)
		);
		
		//$datas = $params;

		$datas = $Lord->statusRatSav($params);
	}
	else if(!empty(filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params = array(
			'rat'		=> filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT),
			'status'	=> filter_input(INPUT_POST,'status',FILTER_SANITIZE_NUMBER_INT)
		);
		
		//$datas = $params;

		$datas = $Lord->statusRatSav($params);
	}
	else
	{
		$datas = json_encode("missing");
	}
	
	error_log("params : ".print_r($params,TRUE)." - datas : ".print_r($datas,TRUE));
	
	echo json_encode($datas);
}
else
{
	echo json_encode("auth");
}