<?php
try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host='.$db_infos['db_host'].';dbname='.$db_infos['db_name'].';charset=utf8', ''.$db_infos['db_user'].'', ''.$db_infos['db_password'].'');
	
	$bdd->query("SET NAMES UTF8");
}
catch (Exception $e)
{
	die('Erreur : ' . $e->getMessage());
}
