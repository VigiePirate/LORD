<?php
try
{
	$db_v1 = new PDO('mysql:host='.$db_v1_infos['db_host'].';dbname='.$db_v1_infos['db_name'].';charset=utf8', ''.$db_v1_infos['db_user'].'', ''.$db_v1_infos['db_password'].'');
	$db_v2 = new PDO('mysql:host='.$db_v2_infos['db_host'].';dbname='.$db_v2_infos['db_name'].';charset=utf8', ''.$db_v2_infos['db_user'].'', ''.$db_v2_infos['db_password'].'');
	
	$db_v1->query("SET NAMES 'utf8'");
	$db_v2->query("SET NAMES 'utf8'");
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}

