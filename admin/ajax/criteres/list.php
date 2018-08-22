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
	
	if(!empty(filter_input(INPUT_POST,'critere',FILTER_SANITIZE_STRING)))
	{
		$critere = filter_input(INPUT_POST,'critere',FILTER_SANITIZE_STRING);
	}
	else if(!empty(filter_input(INPUT_GET,'critere',FILTER_SANITIZE_STRING)))
	{
		$critere = filter_input(INPUT_GET,'critere',FILTER_SANITIZE_STRING);
	}
	else
	{
		$critere = NULL;
	}
	
	if(!is_null($critere))
	{
		$critere = $Lord->listCriteres($critere,"nom","menu")->response->datas;
		
		echo json_encode($critere);
	}
}
else
{
	echo json_encode("auth");
}