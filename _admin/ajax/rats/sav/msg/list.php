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
	
	$params = array(
		"rat"		=> NULL,
		"user"		=> NULL,
		"recent"	=> FALSE
	);

	if(!empty(filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params['rat'] = filter_input(INPUT_GET,'rat',FILTER_SANITIZE_NUMBER_INT);
	}
	else if(!empty(filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params['rat'] = filter_input(INPUT_POST,'rat',FILTER_SANITIZE_NUMBER_INT);
	}

	if(!empty(filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params['user'] = filter_input(INPUT_GET,'user',FILTER_SANITIZE_NUMBER_INT);
	}
	else if(!empty(filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params['user'] = filter_input(INPUT_POST,'user',FILTER_SANITIZE_NUMBER_INT);
	}

	if(!empty(filter_input(INPUT_GET,'recent',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params['recent'] = filter_input(INPUT_GET,'recent',FILTER_SANITIZE_NUMBER_INT);
	}
	else if(!empty(filter_input(INPUT_POST,'recent',FILTER_SANITIZE_NUMBER_INT)))
	{
		$params['recent'] = filter_input(INPUT_POST,'recent',FILTER_SANITIZE_NUMBER_INT);
	}

	$datas = $Lord->listRatSavMsg($params);
	
	echo json_encode($datas);
}
else
{
	echo json_encode("auth");
}