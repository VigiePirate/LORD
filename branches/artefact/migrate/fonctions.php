<?php

// Fonction requete Curl sur API
function curlQuery($query_url, $method = NULL, $params = NULL,$debug = FALSE)
{
	$ch = curl_init($query_url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Premium Base V2');
	$response = curl_exec($ch);
	curl_close($ch);

	if($debug)
	{
		echo "Query : ".$query_url."<br />Response : <br />".$response;
	}

	return $response;
}

// Fonction permettant de vérifier si une table est vide
// Output :
// 0 => La table n'est pas vide
// 1 => La table est vide
function table_empty($nom_table)															// OK le 26/12/2016
{
	global $db_v2;
	
	$flag = 0;
	
	$req = $db_v2->query("SELECT * FROM $nom_table");
	
	if($req->rowCount() == 0)
	{
		$flag = 1;
	}
	
	return $flag;
}

// Fonction permettant de vérifier l'existence d'une table 
// Output :
// 0 => La table n'existe pas
// 1 => La table existe
function table_exists($nom_table)															// OK le 26/12/2016
{
    global $db_v2,$db_v2_infos;

    $req = $db_v2->prepare("SHOW TABLES FROM `".$db_v2_infos['db_name']."` LIKE :nom_table");
    $req->execute(array("nom_table" => $nom_table));

    return $req->rowCount();
}

// Cette fonction permet d'ajouter les premiere lignes d'une table
// Output
// 0 => Succes
// 1 => Echec
// 2 => Table non vide
// 3 => La Table n'existe pas
function insert($table,$rows)																// OK le 26/12/2016
{
	global $RUN_METHOD,$db_v2;
	
	$flag = 0;
	
	if(table_exists($table))
	{
		if(table_empty($table))
		{
			if($RUN_METHOD === "debug" OR $RUN_METHOD === "run")
			{
				$ins = $db_v2->query($rows);
				$ins->closeCursor();

				$flag = table_empty($table);
			}
		}
		else
		{
			$flag = 2;
		}
	}
	else
	{
		$flag = 3;
	}
	
	return $flag;
}

// Fonction de création d'une table
// Output
// 0 => Succes de la création
// 1 => Echec de la création
// 2 => Table existe deja
// 3 => Mode Test
function create_table($table,$sql)															// OK le 26/12/2016
{
	global $RUN_METHOD,$db_v2;
	
	$flag = 0;
	
	if(table_exists($table))
	{
		$flag = 2;
	}
	else
	{
		if($RUN_METHOD == "debug" OR $RUN_METHOD == "run")
		{
			$cre = $db_v2->query($sql);
		
			$cre->closeCursor();
		
			if(!table_exists($table))
			{
				$flag = 1;
			}
		}
		else
		{
			$flag = 3;
		}
	}
	
	return $flag;
}

// Fonction regroupant la création des tables et l'insertion des données d'administration
// Output :
// 0 => Succes
// 1 => Echec
function create_tables()																	// OK le 26/12/2016
{
	$flag = 0;
	
	switch(create_tables_generales())
	{
		case 1:
			$flag = 1;
			break;
	}
	
	switch(create_tables_users())
	{
		case 1:
			$flag = 1;
			break;
	}
	
	switch(create_tables_rateries())
	{
		case 1:
			$flag = 1;
			break;
	}
	
	switch(create_tables_rats())
	{
		case 1:
			$flag = 1;
			break;
	}
	
	return $flag;
}

// Fonction regroupant la création des tables générale et de l'insertion des données d'administration
// Output :
// 0 => Succes
// 1 => Echec
function create_tables_generales()															// OK le 26/12/2016
{
	global $events,$nbr_erreurs;
	global $sql_antispam,$sql_langues;
	global $sql_mails,$sql_chat,$sql_log_edit;
	global $rows_antispam,$rows_langues;
	global $rows_mails;
	
	$flag = 0;
	
	switch(create_table('antispam',$sql_antispam))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'antispam'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'antispam' existe deja"
			);
			
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "warning",
				'details'	=> "Impossible de créer la Table 'antispam' : Mode Test actif"
			);
			
			break;
	}
	
	switch(insert('antispam',$rows_antispam))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "Impossible de remplir la table 'antispam'"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "info",
				'details'	=> "La table 'antispam' à deja du contenu"
			);
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "La table 'antispam' n'existe pas"
			);
			$flag = 1;
			break;
	}
	
	switch(create_table('langues',$sql_langues))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'langues'"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'langues' existe deja"
			);
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "warning",
				'details'	=> "Impossible de créer la Table 'langues' : Mode Test actif"
			);
			break;
	}
	
	switch(insert('langues',$rows_langues))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "Impossible de remplir la table 'langues'"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "info",
				'details'	=> "La table 'langues' à deja du contenu"
			);
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "La table 'langues' n'existe pas"
			);
			$flag = 1;
			break;
	}
	
	switch(create_table('mails',$sql_mails))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'mails'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'mails' existe deja"
			);
			
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "warning",
				'details'	=> "Impossible de créer la Table 'mails' : Mode Test actif"
			);
			
			break;
	}
	
	switch(insert('mails',$rows_mails))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "Impossible de remplir la table 'mails'"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "info",
				'details'	=> "La table 'mails' à deja du contenu"
			);
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "La table 'mails' n'existe pas"
			);
			$flag = 1;
			break;
	}
	
	switch(create_table('chat',$sql_chat))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'chat'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'chat' existe deja"
			);
			
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "warning",
				'details'	=> "Impossible de créer la Table 'chat' : Mode Test actif"
			);
			
			break;
	}
	
	switch(create_table('log_edit',$sql_log_edit))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'log_edit'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'log_edit' existe deja"
			);
			
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "warning",
				'details'	=> "Impossible de créer la Table 'log_edit' : Mode Test actif"
			);
			
			break;
	}
	
	return $flag;
}

// Fonction de création des tables contenant les infos utilisateurs
// Output :
// 0 => Succes
// 1 => Echec
function create_tables_users()																// OK le 26/12/2016
{
	global $events,$nbr_erreurs;
	global $sql_users,$sql_users_adresses,$sql_users_civilites,$sql_users_date_naissance;
	global $sql_users_messagerie,$sql_users_noms,$sql_users_presentations,$sql_users_sites;
	global $sql_users_tokens;
	global $rows_users,$rows_users_civilites;
	
	$flag = 0;
	
	switch(create_table('users',$sql_users))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users' existe deja"
			);
			
			break;
	}
	
	switch(insert('users',$rows_users))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "Impossible de remplir la table 'users'"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "info",
				'details'	=> "La table 'users' à deja du contenu"
			);
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "La table 'users' n'existe pas"
			);
			$flag = 1;
			break;
	}
	
	switch(create_table('users_noms',$sql_users_noms))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_noms'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_noms' existe deja"
			);
			
			break;
	}
	
	switch(create_table('users_civilites',$sql_users_civilites))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_civilites'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_civilites' existe deja"
			);
			
			break;
	}
	
	switch(insert('users_civilites',$rows_users_civilites))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "Impossible de remplir la table 'users_civilites'"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "info",
				'details'	=> "La table 'users_civilites' à deja du contenu"
			);
			break;
		case 3:
			$events[] = array( 
				'id'		=> "Insert Table",
				'type'		=> "error",
				'details'	=> "La table 'users_civilites' n'existe pas"
			);
			$flag = 1;
			break;
	}
	
	switch(create_table('users_date_naissance',$sql_users_date_naissance))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_date_naissance'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_date_naissance' existe deja"
			);
			
			break;
	}
	
	switch(create_table('users_adresses',$sql_users_adresses))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_adresses'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_adresses' existe deja"
			);
			
			break;
	}
	
	switch(create_table('users_sites',$sql_users_sites))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_sites'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_sites' existe deja"
			);
			
			break;
	}
	
	switch(create_table('users_presentations',$sql_users_presentations))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_presentations'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_presentations' existe deja"
			);
			
			break;
	}
	
	switch(create_table('users_messagerie',$sql_users_messagerie))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_messagerie'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_messagerie' existe deja"
			);
			
			break;
	}
	
	switch(create_table('users_tokens',$sql_users_tokens))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'users_tokens'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'users_tokens' existe deja"
			);
			
			break;
	}
	
	return $flag;
}

// Fonction de création des tables contenant les infos des rateries
// Output :
// 0 => Succes
// 1 => Echec
function create_tables_rateries()															// OK le 26/12/2016
{
	global $events,$nbr_erreurs;
	global $sql_rateries,$sql_rateries_presentations,$sql_rateries_actions;
	global $sql_rateries_messages,$sql_rateries_images,$sql_rateries_sites;
	$flag = 0;
	
	switch(create_table('rateries',$sql_rateries))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rateries'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rateries' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rateries_presentations',$sql_rateries_presentations))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rateries_presentations'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rateries_presentations' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rateries_actions',$sql_rateries_actions))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rateries_actions'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rateries_actions' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rateries_messages',$sql_rateries_messages))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rateries_messages'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rateries_messages' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rateries_images',$sql_rateries_images))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rateries_images'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rateries_images' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rateries_sites',$sql_rateries_sites))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rateries_sites'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rateries_sites' existe deja"
			);
			
			break;
	}
	
	
	return $flag;
}

// Fonction de création des tables contenant les infos des rats
// Output :
// 0 => Succes
// 1 => Echec
function create_tables_rats()																// OK le 26/12/2016
{
	global $events,$nbr_erreurs;
	global $sql_rats,$sql_rats_edit,$sql_rats_link_pb_santes,$sql_rats_link_uniques;
	global $sql_rats_actions,$sql_rats_images,$sql_rats_causes_deces,$sql_rats_couleurs;
	global $sql_rats_dilutions,$sql_rats_oreilles,$sql_rats_marquages,$sql_rats_marquages;
	global $sql_rats_parents,$sql_rats_pb_santes,$sql_rats_poils,$sql_rats_uniques,$sql_rats_yeux;
	global $sql_rats_portees,$sql_rats_poids;
	$flag = 0;
	
	switch(create_table('rats',$sql_rats))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_edit',$sql_rats_edit))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_edit'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_edit' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_link_pb_santes',$sql_rats_link_pb_santes))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_link_pb_santes'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_link_pb_santes' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_link_uniques',$sql_rats_link_uniques))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_link_uniques'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_link_uniques' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_actions',$sql_rats_actions))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_actions'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_actions' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_images',$sql_rats_images))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_images'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_images' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_causes_deces',$sql_rats_causes_deces))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_causes_deces'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_causes_deces' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_couleurs',$sql_rats_couleurs))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_couleurs'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_couleurs' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_dilutions',$sql_rats_dilutions))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_dilutions'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_dilutions' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_oreilles',$sql_rats_oreilles))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_oreilles'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_oreilles' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_marquages',$sql_rats_marquages))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_marquages'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_marquages' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_parents',$sql_rats_parents))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_parents'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_parents' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_pb_santes',$sql_rats_pb_santes))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_pb_santes'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_pb_santes' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_poils',$sql_rats_poils))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_poils'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_poils' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_uniques',$sql_rats_uniques))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_uniques'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_uniques' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_yeux',$sql_rats_yeux))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_yeux'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_yeux' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_portees',$sql_rats_portees))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_portees'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_portees' existe deja"
			);
			
			break;
	}
	
	switch(create_table('rats_poids',$sql_rats_poids))
	{
		case 1:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "error",
				'details'	=> "Impossible de créer la Table 'rats_poids'"
			);
			
			$flag = 1;
			break;
		case 2:
			$events[] = array( 
				'id'		=> "Create Table",
				'type'		=> "info",
				'details'	=> "La table 'rats_poids' existe deja"
			);
			
			break;
	}
	
	return $flag;
}

// Fonction affichant les erreurs rencontré lors de la convertion
// Output => Texte a afficher
function print_events()																	// OK le 26/12/2016
{
	global $events;
	
	$count = array(
		'error'		=> 0,
		'warning'	=> 0,
		'info'		=> 0
	);
	
	$return = "";
	
	$nbr_events = count($events);
	
	if($nbr_events)
	{
		foreach($events as $event)
		{
			switch($event['type'])
			{
				case "error":
					$count['error']++;
					break;
				case "warning":
					$count['warning']++;
					break;
				case "info":
					$count['info']++;
					break;
			}
		}
		
		$return = "Le script de conversion viens de se terminer en rencontrant ".$count['error']." erreurs et ".$count['warning']." avertissements.\n";
		
		foreach($events as $event)
		{
			switch($event['type'])
			{
				case "error":
					$color = "red";
					break;
				case "warning":
					$color = "orange";
					break;
				case "info":
					$color = "white";
					break;
			}
			$return .= $event['id']." - ".$event['type']." - ".$event['details'];
		}
	}
	else
	{
		$return = print_success();
	}
	
	return $return;
}

// Fonction affichang le message de validation pour la conversion réussie
function print_success()																	// OK le 26/12/2016
{
	$return = "La conversion viens de se terminer avec succès.\n\n";
	
	return $return;
}

// Fonction de Synchronisation des tables
function sync_tables()
{
	$flag = 0;
	
	switch(sync_tables_users())
	{
		case 1:
			$flag = 1;
			break;
	}
	
	return $flag;
}

// Synchronisation de la table utilisateurs
// 0 => Aucune erreur d'execution
// 1 => Une erreur à été rencontrée
function sync_tables_users()
{
	global $db_v1,$events,$nbr_erreurs;
	
	$flag = 1;
	
	$req = $db_v1->query("SELECT * FROM `peel_utilisateurs` ORDER BY `id_utilisateur` LIMIT 10000 OFFSET 4080");
	
	while($donnees = $req->fetch())
	{
		// Réccupréation de l'id utilisateur dans l'ancienne table
		$id_utilisateur =  $donnees['id_utilisateur'];
		
		// On vérifie si l'utilisateur existe dans la nouvelle table
		$id_membre = check_user($id_utilisateur);
		
		
		switch($id_membre)
		{
			case 0:		// Nouvel utilisateur
				echo $id_utilisateur." is a new user : ";
				$flag = migrate_peel_utilisateurs_to_users($id_utilisateur);
				echo "\n";
				break;
			default:	// Utilisateur deja présent
				echo $id_utilisateur." is now ".$id_membre."\n";
				//$flag = sync_peel_utilisateurs_to_users($id_utilisateur,$id_membre);
				break;
		}
	}
	
	echo "\n\n";
	
	return $flag;
}

function migrate_peel_utilisateurs_to_users($id_utilisateur)
{
	global $events,$db_v1;
	
	$flag = 0;
	
	$req = $db_v1->prepare("SELECT * FROM `peel_utilisateurs` WHERE `id_utilisateur` = :id_utilisateur");
	$req->execute(array("id_utilisateur" => $id_utilisateur));
	
	$donnees = $req->fetch();

	$email = validate_peel_utilisateurs_email($donnees['email'],$id_utilisateur);

	switch($email)
	{
		case 1:
			$events[] = array(
				'id'		=> $id_utilisateur,
				'type'		=> "error",
				'details'	=> "Adresse mail invalide"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array(
				'id'		=> $id_utilisateur,
				'type'		=> "error",
				'details'	=> "Adresse mail en double"
			);
			$flag = 1;
			break;
		case 3:
			$events[] = array(
				'id'		=> $id_utilisateur,
				'type'		=> "error",
				'details'	=> "Adresse mail deja présente dans 'users'"
			);
			$flag = 1;
			break;
	}

	$level = validate_peel_utilisateurs_pseudo($donnees['pseudo']);

	switch($level)
	{
		case 1:
			$events[] = array(
				'id'		=> $id_utilisateur,
				'type'		=> "error",
				'details'	=> "Pseudo en double"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array(
				'id'		=> $id_utilisateur,
				'type'		=> "error",
				'details'	=> "Pseudo deja présent dans 'users'"
			);
			$flag = 1;
			break;
	}

	if(strtotime($donnees['date_insert']) < 0)
	{
		$date_inscription = 0;
	}
	else
	{
		$date_inscription = strtotime($donnees['date_insert']);
	}

	if(strtotime($donnees['date_update']) < 0)
	{
		$date_maj = 0;
	}
	else
	{
		$date_maj = strtotime($donnees['date_update']);
	}

	if($flag == 0)
	{
		echo "User can be inserted ...";
		/*switch(insert_users($id_utilisateur,$donnees['email'], $donnees['mot_passe'], $donnees['pseudo'], $level, $date_inscription, 0, $date_maj))
		{
			case 0:
				$id_membre = validate_new_id($donnees['email']);

				switch($id_membre)
				{
					case -1:
						$events[] = array(
							'id'		=> $id_utilisateur,
							'type'		=> "error",
							'details'	=> "Echec de la réccupération du nouvel id"
						);
						$flag = 1;
						break;
				}
				break;
			case 1:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Echec d'insertion 'users'"
				);
				$flag = 1;
				break;
			case 2:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Adresse mail deja utilisée"
				);
				$flag = 1;
				break;
			case 3:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Pseudo deja utilisé"
				);
				$flag = 1;
				break;
			case 4:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Adresse mail et pseudo deja utilisé"
				);
				$flag = 1;
				break;
		}*/
	}
	/*
	if($flag == 0 AND ($donnees['prenom'] != "" OR $donnees['nom_famille'] != ""))
	{
		switch(convertion_peel_utilisateurs_to_users_noms($id_membre,$donnees['civilite'],$donnees['prenom'],$donnees['nom_famille']))
		{
			case 1:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Echec d'insertion 'users_noms'"
				);
				$flag = 1;
				break;
			case 2:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "L'utilisateur à deja un nom renseigné dans 'users_noms'"
				);
				$flag = 1;
				break;
		}
	}

	if($flag == 0 AND $donnees['naissance'] != "0000-00-00")
	{
		switch(convertion_peel_utilisateurs_to_users_date_naissance($id_membre,strtotime($donnees['naissance'])))
		{
			case 1:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Echec d'insertion 'users_date_naissance'"
				);
				$flag = 1;
				break;
			case 2:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "L'utilisateur à deja une date de naissance renseignée dans 'users_sites'"
				);
				$flag = 1;
				break;
		}
	}

	if($flag == 0 AND $donnees['url'] != "")
	{
		switch(convertion_peel_utilisateurs_to_users_sites($id_membre,$donnees['url']))
		{
			case 1:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Echec d'insertion 'users_sites'"
				);
				$flag = 1;
				break;
			case 2:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "L'utilisateur à deja ce site renseigné dans 'users_sites'"
				);
				$flag = 1;
				break;
		}
	}

	if($flag == 0 AND $donnees['adresse'] != "" AND $donnees['code_postal'] != "" AND $donnees['ville'] != "") // Convertion des adresses à faire
	{
		$adresse = validate_peel_utilisateurs_adresses($id_utilisateur,$id_membre,$donnees['code_postal'],$donnees['ville'],$donnees['pays']);
		
		switch($adresse['id_ville'])
		{
			case -1:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "La ville renseignée n'existe pas"
				);
				$flag = 1;
				break;
			case -2:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "Plusieures ville avec ces paramètres, filtrage manuel nécésssaire"
				);
				$flag = 1;
				break;
			case -3:
				$events[] = array(
					'id'		=> $id_utilisateur,
					'type'		=> "error",
					'details'	=> "L'utilisateur à deja une adresse renseigné dans 'users_adresses'"
				);
				$flag = 1;
				break;
		}
		if($flag == 0)
		{
			switch(convertion_peel_utilisateurs_to_users_adresses($id_membre,$adresse['id_ville'],$adresse['id_pays'],$donnees['adresse']))
			{
				case 1:
					$events[] = array(
						'id'		=> $id_utilisateur,
						'type'		=> "error",
						'details'	=> "Echec d'insertion 'users_adresses'"
					);
					$flag = 1;
					break;
			}
		}
	}
	
	$req->closeCursor();*/
	
	return $flag;
}

// Fonction d'insertion des utilisateurs
// Output :
// 0 => Succes
// 1 => Echec d'insertion
// 2 => Adresse mail deja utilisée
// 3 => Pseudo deja utilisé
// 4 => Adresse mail et Pseudo deja utilisés
function insert_users($old_id,$email,$password,$pseudo,$level,$date_inscription,$date_visite,$date_maj)	// OK
{
	global $db_v1,$db_v2;
	
	$flag = 0;
	
	$req = $db_v2->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
	$req->execute(array("email" => $email));
	
	if($req->rowCount())
	{
		$donnees = $req->fetch();
		
		if($email === $donnees['email'])
		{
			$flag = 2;
		}
		
		$req->closeCursor();
	}
	
	$req->closeCursor();
	
	$req = $db_v2->prepare("SELECT `pseudo` FROM `users` WHERE `pseudo` = :pseudo");
	$req->execute(array("pseudo" => $pseudo));

	if($req->rowCount())
	{
		$donnees = $req->fetch();
		
		if($pseudo === $donnees['pseudo'])
		{
			if($flag == 2)
			{
				$flag = 4;
			}
			else
			{
				$flag = 3;
			}
		}
		
		$req->closeCursor();
	}

	$req->closeCursor();

	if($flag == 0)
	{
		$ins = $db_v2->prepare("INSERT INTO `users` VALUES('',:old_id,:email,:password,NULL,:pseudo,:level,:date_inscription,:date_visite,:date_maj,'0')");
		$ins->execute(array("old_id"			=> $old_id,
							"email"				=> $email,
							"password"			=> $password,
							"pseudo"			=> $pseudo,
							"level"				=> $level,
							"date_inscription"	=> $date_inscription,
							"date_visite"		=> $date_visite,
							"date_maj"			=> $date_maj));

		if($ins->rowCount() == 0)
		{
			$flag = 1;
		}
		
		$ins->closeCursor();
	}

	$req->closeCursor();
	
	return $flag;
}

function convertion_peel_utilisateurs_to_users_adresses($id_membre,$id_ville,$id_pays,$adresse)	// OK
{
	global $db_v2;
	
	$flag = 0;
	
	$ins = $db_v2->prepare("INSERT INTO `users_adresses` VALUES(:id_membre,:adresse,:pays,:ville)");
	$ins->execute(array("id_membre"	=> $id_membre,
						"adresse"	=> $adresse,
						"pays"		=> $id_pays,
						"ville"		=> $id_ville));

	if($ins->rowCount() != 1)
	{
		$flag = 1;
	}

	$ins->closeCursor();
	
	return $flag;
}

function convertion_peel_utilisateurs_to_users_noms($id_membre,$civilite,$prenom,$nom)		// OK
{
	global $db_v1,$db_v2;
	
	$flag = 0;
	
	switch(strtolower($civilite))
	{
		case "m.":
			$civilite = 1;
			break;
		case "mlle":
			$civilite = 3;
			break;
		case "mme":
			$civilite = 2;
			break;
		default:
			$civilite = 0;
			break;
	}
	
	$ins = $db_v2->prepare("INSERT INTO `users_noms` VALUES (:id_membre,:civilite,:prenom,:nom)");
	$ins->execute(array("id_membre" => $id_membre,
						"civilite" => $civilite,
						"prenom" => $prenom,
						"nom" => $nom));
	
	if($ins->rowCount() != 1)
	{
		echo "Plopyplop";
		$flag = 1;
	}
	
	$ins->closeCursor();
	
	return $flag;
}

function convertion_peel_utilisateurs_to_users_date_naissance($id_membre,$date_naissance)	// OK
{
	global $db_v1,$db_v2;
	
	$flag = 0;
	
	$ins = $db_v2->prepare("INSERT INTO `users_date_naissance` VALUES(:id_membre,:date)");
	$ins->execute(array("id_membre" => $id_membre,
						"date" => $date_naissance));
	
	if($ins->rowCount() != 1)
	{
		$flag = 1;
	}
	
	$ins->closeCursor();
	
	return $flag;
}

function convertion_peel_utilisateurs_to_users_sites($id_membre,$url)						// OK
{
	global $db_v1,$db_v2;
	
	$flag = 0;
	
	$req = $db_v2->prepare("SELECT * FROM `users_sites` WHERE id_membre = :id_membre AND url = :url");
	$req->execute(array("id_membre" => $id_membre,
						"url" => $url));
	
	if($req->rowCount() == 0)
	{
		$ins = $db_v2->prepare("INSERT INTO `users_sites` VALUES('',:id_membre,'',:url)");
		$ins->execute(array("id_membre" => $id_membre,
							"url" => $url));
		
		if($ins->rowCount() != 1)
		{
			$flag = 1;
		}
		
		$ins->closeCursor();
	}
	else
	{
		$flag = 2;
	}
	
	$req->closeCursor();
	
	return $flag;
}

function sync_peel_utilisateurs_to_users($id_v1,$id_v2)
{
	global $events,$db_v1,$db_v2;
	
	$flag = 0;
	
	$req_v1 = $db_v1->prepare("SELECT * FROM `peel_utilisateurs` WHERE `id_utilisateur` = :id_utilisateur");
	$req_v1->execute(array("id_utilisateur" => $id_v1));
	
	$donnees_v1 = $req_v1->fetch();
	
	$req_v1->closeCursor();
	
	$req_v2 = $db_v2->prepare("SELECT * FROM `users` WHERE `id_membre` = :id_membre");
	$req_v2->execute(array("id_membre" => $id_v2));
	
	$donnees_v2 = $req_v2->fetch();
	
	$req_v2->closeCursor();

	$email_v1 = validate_peel_utilisateurs_email($donnees_v1['email'],$id_v1);

	switch($email_v1)
	{
		case 1:
			$events[] = array(
				'id'		=> $id_v1,
				'type'		=> "error",
				'details'	=> "Adresse mail invalide"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array(
				'id'		=> $id_v1,
				'type'		=> "error",
				'details'	=> "Adresse mail en double"
			);
			$flag = 1;
			break;
		default:
			if($donnees_v2['email'] != $email_v1)
			{
				$flag = 2;
			}
			break;
	}
	
	$level = validate_peel_utilisateurs_pseudo($donnees_v1['pseudo'],$id_v2);

	switch($level)
	{
		case 1:
			$events[] = array(
				'id'		=> $id_v1,
				'type'		=> "error",
				'details'	=> "Pseudo en double"
			);
			$flag = 1;
			break;
		case 2:
			$events[] = array(
				'id'		=> $id_v1,
				'type'		=> "error",
				'details'	=> "Pseudo deja présent dans 'users'"
			);
			$flag = 1;
			break;
		default:
			if($donnees_v2['level'] != $level OR $donnees_v2['pseudo'] != $donnees_v1['pseudo'])
			{
				$flag = 2;
			}
			break;
	}
	
	if(strtotime($donnees_v1['date_insert']) < 0)
	{
		$date_inscription = 0;
	}
	else
	{
		$date_inscription = strtotime($donnees_v1['date_insert']);
	}

	if(strtotime($donnees_v1['date_update']) < 0)
	{
		$date_maj = 0;
	}
	else
	{
		$date_maj = strtotime($donnees_v1['date_update']);
	}
	
	switch($flag)
	{
		case 0:
			$events[] = array(
				'id'		=> $id_v1,
				'type'		=> "info",
				'details'	=> "User Up To Date"
			);
			break;
		case 2:
			// Appel de la fonction de syncrho
			break;
	}
	
	if($flag == 0)
	{
		// Appel des autres fonctions de syncrho (site web, adresse etc...)
		
	}
	
	return $flag;
}

// Vérifie si l'utilisateur existe deja dans la nouvelle BDD
// 0 => Absent
// Sinon renvoi l'id de l'utilisateur
function check_user($old_id)
{
	$result = json_decode(curlQuery("https://api.larchiviste.fr/users/get?old_id=".$old_id."&app=NhNWKfsvPJG09wlhT62o&key=LDpkLwmysBVdw1kE9hqH0q5KpPnE3oqO2Q9NmvmO7i1EjmisDJ"));
	
	if(is_array($result->response->datas) AND count($result->response->datas) == 1)
	{
		$id_membre = $result->response->datas[0]->id_membre;
	}
	else
	{
		$id_membre = 0;
	}
	
	return $id_membre;
}

// Réccupère l'id de la ville dans l'API Geonames
// -1 : Pas de résultat
// -2 : Résultats Multiples
function get_ville($pays,$cp,$ville,$retry = FALSE)
{
	global $geoname;
	
	$ville = trim($ville); // Suppression des espace en début et fin de chaine
	$ville = remove_accent($ville); // On enlève les accents
	$ville = remove_abreviations($ville); // On supprimer les abreviations
	$ville = strtoupper($ville); // On passe la chaine de caractère en majuscules
	if($retry)
	{
		$ville = str_replace("-", " ", $ville); // On supprimer les tirets
	}
	
	$return = json_decode($geoname->search(array(
		"cp"	=> $cp,
		"nom"	=> $ville,
		"pays"	=> $pays
	)));
	
	$flag = 0;
	
	foreach($return as $ville)
	{
		if(array_key_exists('id_ville', $ville))
		{
			$flag++;
		}
	}
	
	switch($flag)
	{
		case 0:
			if($retry)
			{
				$flag = -1;
			}
			else
			{
				$flag = get_ville($pays,$cp,substr($ville,0,3),TRUE);
			}
			break;
		case 1:
			$flag = $return[0]->id_ville;
			break;
		default:
			$flag = -2;
			break;
	}
	
	return $flag;
}

// Remplace les abreviations par le mot correct
function remove_abreviations($texte)
{
	$texte = strtolower($texte);
	
	$texte = str_replace(
			array(
				'st ',' st ',' st','st-',' st-',
				'ste ',' ste ',' ste','ste-',' ste-'),
			array(
				'saint ',' saint ',' saint','saint ',' saint ',
				'sainte ',' sainte ',' sainte','sainte ',' sainte ',),
			$texte);
	
	return $texte;
}

// Supprimer les accent d'une chaine de texte
function remove_accent($texte)
{
    $texte = mb_strtolower($texte, 'UTF-8');
    $texte = str_replace(
        array(
            'à', 'â', 'ä', 'á', 'ã', 'å',
            'î', 'ï', 'ì', 'í', 
            'ô', 'ö', 'ò', 'ó', 'õ', 'ø', 
            'ù', 'û', 'ü', 'ú', 
            'é', 'è', 'ê', 'ë', 
            'ç', 'ÿ', 'ñ', 
        ),
        array(
            'a', 'a', 'a', 'a', 'a', 'a', 
            'i', 'i', 'i', 'i', 
            'o', 'o', 'o', 'o', 'o', 'o', 
            'u', 'u', 'u', 'u', 
            'e', 'e', 'e', 'e', 
            'c', 'y', 'n', 
        ),
        $texte
    );
 
    return $texte;        
}

// Vérifie que l'adresse renseignée par l'utilisateur contient une ville et un code postal valide
// Renvoi un tableau contenant l'id de la ville et le code ISO du pays
// -1 : Pas de résultat
// -2 : Résultats Multiples
// -3 : Deja une adresse pour l'utilisateur
function validate_peel_utilisateurs_adresses($id_utilisateur,$id_membre,$cp,$ville,$pays)
{
	global $db_v1,$db_v2;
	
	$flag = 0;
	
	$req = $db_v2->prepare("SELECT * FROM `users_adresses` WHERE `id_membre` = :id_membre");
	$req->execute(array("id_membre" => $id_membre));
	
	if($req->rowCount() == 0)
	{
		switch($pays) // Conversion des id pays (si rensignés)
		{
			case 1: case 127: case 239:
				$id_pays = 'FR';
				break;
			case 240:
				$id_pays = 'BE';
				break;
			case 241:
				$id_pays = 'CH';
				break;
			default:
				$id_pays = 'FR';
				break;
		}

		// Correction manuelle des erreurs de saisie
		switch($id_utilisateur)
		{
			case 11:
				$cp = '59140';
				break;
			case 19:
				$cp = '02330';
				break;
			case 20:				// Champs bidons dans ancienne version du LORD
				return 0;
			case 21:				// Champs bidons dans ancienne version du LORD
				return 0;
			case 54:				// Champs bidons dans ancienne version du LORD
				return 0;
			case 55:
				$ville = "OZOIR LA FERRIERE";
				break;
			case 73:				// Suisse
				$id_pays = 'CH';
				break;
			case 104:				// Belgique
				$id_pays = 'BE';
				break;
			case 132:
				$cp = 57250;
				break;
			case 194:				// Belgique
				$id_pays = 'BE';
				break;
			case 195:
				$cp = 95000;
				break;
			case 204:				// Suisse
				$id_pays = 'CH';
				break;
			case 205:				// Belgique
				$id_pays = 'BE';
				break;
			case 211:				// Belgique
				$id_pays = 'BE';
				break;
			case 235:				// Suisse
				$id_pays = 'CH';
				break;
			case 240:				// Belgique
				$id_pays = 'BE';
				break;
			case 244:				// Belgique
				$id_pays = 'BE';
				break;
			case 245:
				$ville = "TALUYERS";
				break;
			case 247:				// Suisse
				$id_pays = 'CH';
				break;
			case 265:
				$cp = 75016;
				break;
			case 285:				// Suisse
				$id_pays = 'CH';
				break;
			case 293:				// Suisse
				$id_pays = 'CH';
				break;
			case 308:				// Suisse
				$id_pays = 'CH';
				break;
			case 323:				// Champs bidons dans ancienne version du LORD
				return 0;
			case 343:				// Belgique
				$id_pays = 'BE';
				break;
			case 345:				// Belgique
				$id_pays = 'BE';
				break;
			case 361:				// Belgique
				$id_pays = 'BE';
				break;
			case 362: 				// Belgique
				$id_pays = 'BE';
				break;
			case 443:				// Belgique
				$id_pays = 'BE';
				break;
			case 444:
				$ville = "LE PETIT QUEVILLY";
				break;
			case 452:				// Belgique
				$id_pays = 'BE';
				break;
			case 476:				// Belgique
				$id_pays = 'BE';
				break;
			case 489:				// Belgique
				$id_pays = 'BE';
				break;
			case 490: 				// Belgique
				$id_pays = 'BE';
				break;
			case 572: 				// Belgique
				$id_pays = 'BE';
				break;
			case 574:				// Suisse
				$id_pays = 'CH';
				break;
			case 576:				// Suisse
				$id_pays = 'CH';
				break;
			case 577:				// Suisse
				$id_pays = 'CH';
				break;
			case 585: 				// Suisse
				$id_pays = 'CH';
				break;
			case 586: 				// Belgique
				$id_pays = 'BE';
				break;
			case 587:				// Suisse
				$id_pays = 'CH';
				break;
			case 588: 				// Belgique
				$id_pays = 'BE';
				break;
			case 597:				// Suisse
				$id_pays = 'CH';
				break;
			case 609:				// Suisse
				$id_pays = 'CH';
				break;
			case 611:				// Belgique
				$id_pays = 'BE';
				break;
			case 627:				// Suisse
				$id_pays = 'CH';
				break;
			case 702:
				$ville = "CALUIRE ET CUIRE";
				break;
			case 722:				// Suisse
				$id_pays = 'CH';
				break;
			case 729: 				// Belgique
				$id_pays = 'BE';
				break;
			case 730: 				// Belgique
				$id_pays = 'BE';
				break;
			case 738:				// Suisse
				$id_pays = 'CH';
				break;
			case 806:				// Belgique
				$id_pays = 'BE';
				$ville = "Dison";
				break;
			case 849:				// Suisse
				$id_pays = 'CH';
				break;
			case 873:				// Belgique
				$cp = 5030;
				$id_pays = 'BE';
				break;
			case 957:				// Belgique
				$ville = "Koekelberg";
				$id_pays = 'BE';
				break;
			case 980:				// Belgique
				$id_pays = 'BE';
				break;
			case 991:				// Belgique
				$id_pays = 'BE';
				break;
			case 1007:				// Belgique
				$id_pays = 'BE';
				break;
			case 1008:				// Belgique
				$id_pays = 'BE';
				break;
			case 1022:				// Belgique
				$id_pays = 'BE';
				break;
			case 1043:				// Belgique
				$id_pays = 'BE';
				break; 
			case 1045:				// Belgique
				$id_pays = 'BE';
				break;
			case 1054:				// Belgique
				$id_pays = 'BE';
				break;
			case 1055:				// Suisse
				$ville = "genève";
				$id_pays = 'CH';
				break;
			case 1058:				// Belgique
				$id_pays = 'BE';
				break;
			case 1087:				// Belgique
				$id_pays = 'BE';
				break;
			case 1136:				// Belgique
				$id_pays = 'BE';
				break;
			case 1163:				// Suisse
				$id_pays = 'CH';
				break;
			case 1177:
				$ville = "ROQUEFORT LA BEDOULE";
				break;
			case 1210:				// Belgique
				$id_pays = 'BE';
				break;
			case 1254:
				$ville = "Le Perreux-sur-Marne";
				break;
			case 1264:				// Belgique
				$id_pays = 'BE';
				break;
			case 1277:
				$cp = '60690';
				break;
			case 1310:				// Suisse
				$id_pays = 'CH';
				break;
			case 1322:				// Belgique
				$id_pays = 'BE';
				break;
			case 1331:				// France
				$cp = '02100';
				break;
			case 1358:
				$ville = "LE GRAND QUEVILLY";
				break;
			case 1399:				// Belgique
				$id_pays = 'BE';
				break;
			case 1405:				// Suisse
				$id_pays = 'CH';
				break;
			case 1413:				// Belgique
				$id_pays = 'BE';
				break;
			case 1439:
				$ville = "Château-Larcher";
				break;
			case 1465:				// Belgique
				$id_pays = 'BE';
				$ville = "Tilff";
				break;
			case 1498:				// France
				$cp = 51500;
				break;
			case 1503:				// Belgique
				$id_pays = 'BE';
				break; 
			case 1513:				// Suisse
				$id_pays = 'CH';
				break;
			case 1515:				// Suisse
				$id_pays = 'CH';
				break;
			case 1525:				// Belgique
				$id_pays = 'BE';
				break;
			case 1526:				// Belgique
				$id_pays = 'BE';
				break;
			case 1527:				// Belgique
				$id_pays = 'BE';
				break;
			case 1560:				// Champs bidons ancienne version LORD
				return 0;
			case 1562:				// Suisse
				$id_pays = 'CH';
				$ville = "vernier";
				break;
			case 1613:				// Belgique
				$id_pays = 'BE';
				break; 
			case 1614:				// Belgique
				$id_pays = 'BE';
				break;
			case 1619:				// Belgique
				$id_pays = 'BE';
				break;
			case 1622:				// Belgique
				$id_pays = 'BE';
				$ville = "Bellevaux-Ligneuville";
				break;
			case 1624:				// Belgique
				$id_pays = 'BE';
				break;
			case 1626:				// Belgique
				$id_pays = 'BE';
				break;
			case 1634:
				$id_pays = 'BE';
				break;
			case 1638:
				$cp = '01300';
				break;
			case 1644:				// Belgique
				$id_pays = 'BE';
				break;
			case 1702:				// Belgique
				$id_pays = 'BE';
				break;
			case 1709:				// Suisse
				$id_pays = 'CH';
				break;
			case 1719:				// Champs Bidons ancienne version LORD
				return 0;
			case 1741:				// Belgique
				$ville = "Liège";
				$id_pays = 'BE';
				break;
			case 1747:
				$ville = "Saint-Jean-de-la-Motte";
				break;
			case 1763:
				$ville = "Bruz";
				break;
			case 1806:
				$ville = "LE KREMLIN BICETRE";
				break;
			case 1835:				// Belgique
				$id_pays = 'BE';
				break;
			case 1866:
				$cp = 13090;
				break;
			case 1878:
				$cp = '07200';
				break;
			case 1893:				// Suisse
				$id_pays = 'CH';
				break;
			case 1900:
				$ville = "Bressuire";
				break;
			case 1906:				// Belgique
				$id_pays = 'BE';
				break;
			case 1914:				// Belgique
				$id_pays = 'BE';
				break;
			case 1933:				// Belgique
				$id_pays = 'BE';
				$ville = "Koekelberg";
				break;
			case 1935:				// Suisse
				$id_pays = 'CH';
				break;
			case 1944:				// Belgique
				$id_pays = 'BE';
				break;
			case 1947:
				$ville = "BAILLY ROMAINVILLIERS";
				break;
			case 1948:				// Belgique
				$id_pays = 'BE';
				break;
			case 1951:				// Belgique
				$id_pays = 'BE';
				break;
			case 1958:				// Belgique
				$id_pays = 'BE';
				break;
			case 1969:
				$cp = '08000';
				break;
			case 1970:
				$ville = "Saint-Étienne-du-Rouvray";
				break;
			case 1971:				// Belgique
				$id_pays = 'BE';
				break;
			case 1973:
				$ville = "Saint-Crespin-sur-Moine";
				break;
			case 1978:				// Belgique
				$id_pays = 'BE';
				$ville = "Sint-Pieters-Leeuw";
				break;
			case 1997:				// Belgique
				$id_pays = 'BE';
				break;
			case 2027:				// Suisse
				$id_pays = 'CH';
				break; 
			case 2034:				// Belgique
				$id_pays = 'BE';
				break;
			case 2073:				// Belgique
				$id_pays = 'BE';
				break;
			case 2086:				// Belgique
				$id_pays = 'BE';
				break;
			case 2102:				// Belgique
				$id_pays = 'BE';
				break;
			case 2103:				// Suisse
				$id_pays = 'CH';
				break;
			case 2118:				// Belgique
				$id_pays = 'BE';
				break;
			case 2181:
				$ville = "Le Kremlin Bicetre";
				break;
			case 2211:				// Belgique
				$id_pays = 'BE';
				break;
			case 2219:
				$cp = '72000';
				break;
			case 2221:				// Belgique
				$id_pays = 'BE';
				break;
			case 2252:				// Belgique
				$id_pays = 'BE';
				break;
			case 2255:				// Belgique
				$id_pays = 'BE';
				break;
			case 2279:
				$ville = "LA FARE LES OLIVIERS";
				break;
			case 2304:				// Belgique
				$id_pays = 'BE';
				break;
			case 2315:				// Belgique
				$id_pays = 'BE';
				break;
			case 2316:				// Belgique
				$id_pays = 'BE';
				break;
			case 2323:				// Suisse
				$id_pays = 'CH';
				break;
			case 2342:				// Suisse
				$id_pays = 'CH';
				break;
			case 2343:				// Suisse
				$id_pays = 'CH';
				break;
			case 2355:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2397:
				$ville = "L'ISLE ADAM";
				break;
			case 2399:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2400:				// Belgique
				$id_pays = 'BE';
				break;
			case 2403:				// Suisse
				$id_pays = 'CH';
				break;
			case 2418:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2421:				// Belgique
				$id_pays = 'BE';
				break;
			case 2423:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2425:				// Suisse
				$id_pays = 'CH';
				break;
			case 2434:
				$cp = "92170";
				break;
			case 2442:
				$cp = "13100";
				break;
			case 2444:
				$id_pays = 'BE';
				break;
			case 2453:				// Suisse
				$id_pays = 'CH';
				break;
			case 2456:				// Belgique
				$id_pays = 'BE';
				break;
			case 2469:				// Belgique
				$id_pays = 'BE';
				break;
			case 2478:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2488:				//Suisse
				$id_pays = 'CH';
				break;
			case 2491:
				$id_pays = 'BE';
				break;
			case 2495:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2517:				// Suisse
				$id_pays = 'CH';
				break;
			case 2521:
				$id_pays = 'BE';
				break;
			case 2524:				// Belgique
				$id_pays = 'BE';
				break;
			case 2531:
				$id_pays = 'BE';
				break;
			case 2534:
				$id_pays = 'BE';
				break;
			case 2539:
				$id_pays = 'BE';
				break;
			case 2544:				// Belgique
				$id_pays = 'BE';
				break;
			case 2554:
				$cp = "77500";
				break;
			case 2569:				// Suisse
				$id_pays = 'CH';
				break;
			case 2574:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2584:				// Belgique
				$id_pays = 'BE';
				break;
			case 2590:
				$id_pays = 'CH';
				break;
			case 2612:				// Belgique
				$id_pays = 'BE';
				break;
			case 2625:
				$ville = "l'isle saint denis";
				break;
			case 2633:
				$id_pays = 'BE';
				break;
			case 2635:
				$id_pays = 'BE';
				break;
			case 2642:				// Belgique
				$id_pays = 'BE';
				break;
			case 2651:
				$id_pays = 'BE';
				break;
			case 2666:				// Abrutis
				return 0;
			case 2677:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2689:				// Suisse
				$ville = "petit lancy";
				$cp = 1213;
				$id_pays = 'CH';
				break;
			case 2693:				// Belgique
				$id_pays = 'BE';
				break;
			case 2698:
				$id_pays = 'BE';
				break;
			case 2703:				// Abrutis
				return 0;
			case 2720:
				$ville = "TALENCE";
				break;
			case 2728:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2729:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2736:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2740:				// Suisse
				$ville = "Auvernier";
				$id_pays = 'CH';
				break;
			case 2742:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2750:				// Suisse
				$id_pays = 'CH';
				break;
			case 2756:
				$id_pays = 'BE';
				break;
			case 2761:				// Suisse
				$id_pays = 'CH';
				break;
			case 2767:
				$id_pays = 'BE';
				$ville = "liege";
				break;
			case 2768:				// Belgique
				$id_pays = 'BE';
				break;
			case 2787:				// Suisse
				$id_pays = 'CH';
				$ville = "Chêne-Bougeries";
				break;
			case 2789:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2790:				// Belgique
				$id_pays = 'BE';
				break;
			case 2793:				// Suisse
				$id_pays = 'CH';
				break;
			case 2795:				// Belgique
				$id_pays = 'BE';
				break;
			case 2797:				// Suisse
				$id_pays = 'CH';
				break;
			case 2808;				// Belgique
				$id_pays = 'BE';
				break;
			case 2813;				// Luxembourg
				$id_pays = 128;
				break;
			case 2822:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2823:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2831:				// Belgique
				$id_pays = 'BE';
				break;  
			case 2853:				// Belgique
				$id_pays = 'BE';
				break;
			case 2866:				// Suisse
				$id_pays = 'CH';
				break;
			case 2880:				// Suisse
				$id_pays = 'CH';
				break;
			case 2930:				// Suisse
				$id_pays = 'CH';
				break;
			case 2941:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2944:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2957:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2958:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2959:				// Belgique
				$id_pays = 'BE';
				break;
			case 2970:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2974:				// Belgique
				$id_pays = 'BE';
				break; 
			case 2983:				// Belgique
				$id_pays = 'BE';
				break;
			case 2984:				// Belgique
				$id_pays = 'BE';
				break;
			case 2989:				// Belgique
				$id_pays = 'BE';
				break;
			case 3001:				// Belgique
				$id_pays = 'BE';
				break;  
			case 3030:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3039:
				$ville = "LUNERY";
				break;
			case 3041:				// Suisse
				$id_pays = 'CH';
				break;
			case 3045:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3051:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3055:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3070:				// Belgique
				$id_pays = 'BE';
				break;
			case 3073:				// Belgique
				$id_pays = 'BE';
				break;  
			case 3077:				// Belgique
				$id_pays = 'BE';
				break;
			case 3078:				// Belgique
				$id_pays = 'BE';
				break;  
			case 3079:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3089:				// Belgique
				$id_pays = 'BE';
				break;
			case 3091:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3099:				// Belgique
				$id_pays = 'BE';
				break;
			case 3118:
				$cp = 69000;
				break;
			case 3127:				// Belgique
				$id_pays = 'BE';
				break;
			case 3133:				// Suisse
				$id_pays = 'CH';
				break;
			case 3146:				// Suisse
				$ville = "L'HAY LES ROSES";
				break; 
			case 3156:				// Suisse
				$id_pays = 'CH';
				break;
			case 3168:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3173:
				$cp = 75000;
				break;
			case 3174:				// Belgique
				$id_pays = 'BE';
				break;
			case 3184:				// Belgique
				$id_pays = 'BE';
				break;
			case 3188:
				$ville = "Noailles";
				break;
			case 3196:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3206:
				$ville = "CHATEAU D\'OLONNE";
				break;
			case 3216:				// Champs bidons dans ancienne version du LORD
				return 0;
			case 3221:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3224:				// Belgique
				$id_pays = 'BE';
				break;
			case 3225:				// Belgique
				$id_pays = 'BE';
				break;
			case 3226:
				$id_pays = 'BE';
				break;
			case 3227:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3228:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3229:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3232:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3234:
				$id_pays = 'BE';
				break;
			case 3245:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3285:				// Belgique
				$id_pays = 'BE';
				$ville = "Dilbeek";
				break; 
			case 3293:
				$ville = "FRETTE SUR SEINE";
				break;
			case 3317:				// Belgique
				$id_pays = 'BE';
				break;
			case 3333:
				$ville = "SAINT LUCIEN";
				break;
			case 3337:
				$ville = "PARIS";
				break;
			case 3349:				// Belgique
				$id_pays = 'BE';
				break;
			case 3350:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3356:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3357:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3367:				// Belgique
				$id_pays = 'BE';
				break;
			case 3391:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3398:
				$ville = "Rurange-lès-Thionville";
				break;
			case 3406:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3408:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3414:				// Belgique
				$id_pays = 'BE';
				break;
			case 3418:				// Belgique
				$id_pays = 'BE';
				$ville = "FLEMALLE";
				break;
			case 3419:				// Belgique
				$id_pays = 'BE';
				break;
			case 3428:
				$ville = "Houetteville";
				break;
			case 3453:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3454:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3456:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3478:				// Abrutis
				return 0;
			case 3492:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3501:				// Belgique
				$id_pays = 'BE';
				break;
			case 3502:				// Suisse
				$id_pays = 'CH';
				break;
			case 3515:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3540:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3558:				// Belgique
				$id_pays = 'BE';
				break;
			case 3563:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3564:				// Belgique
				$id_pays = 'BE';
				break;
			case 3570:
				$ville = "Saint-Genis-Laval";
				break;
			case 3573:				// Suisse
				$id_pays = 'CH';
				break; 
			case 3584:				// Belgique
				$id_pays = 'BE';
				break;
			case 3585:
				$ville = "VIGNEUX SUR SEINE";
				break;
			case 3587:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3595:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3600:				// Belgique
				$id_pays = 'BE';
				$cp = 1140;
				break;
			case 3606:				// Belgique
				$id_pays = 'BE';
				break;
			case 3613:				// Luxembourg
				$id_pays = 128;
				break;
			case 3615:				// Belgique
				$id_pays = 'BE';
				break;
			case 3616:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3619:				// Belgique
				$id_pays = 'BE';
				break;
			case 3658:				// Belgique
				$id_pays = 'BE';
				break;
			case 3660:				// Belgique
				$id_pays = 'BE';
				break;
			case 3680:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3683:				// Belgique
				$id_pays = 'BE';
				break;
			case 3694:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3701:				// Belgique
				$id_pays = 'BE';
				break; 
			case 3702:				// Belgique
				$id_pays = 'BE';
				break;
			case 3703:				// Belgique
				$id_pays = 'BE';
				break;
			case 3712: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3716:				// Belgique
				$id_pays = 'BE';
				break;
			case 3717: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3721: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3743: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3744: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3747:				// Suisse
				$id_pays = 'CH';
				break; 
			case 3761: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3765: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3825: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3851: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3875:
				$cp = 75016;
				break;
			case 3884: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3894:				// Abrutis
				return 0;
			case 3900: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3904: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3940: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3944:
				$id_pays = 'BE';
				$ville = 'liege';
				break;
			case 3974: 				// Suisse
				$id_pays = 'CH';
				break;
			case 4013:				// Belgique
				$id_pays = 'BE';
				break;
			case 4023: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4045:
				$cp = 60430;
				break;
			case 4046:				// Suisse
				$id_pays = 'CH';
				break;
			case 4055: 				// Belgique
				$id_pays = 'CH';
				break;
			case 4059: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4061:
				$id_pays = 180;
				$ville = "Le Tampon";
				break;
			case 4084:
				$ville = "DUNKERKE";
				break;
			case 4099:				// Suisse
				$id_pays = 'CH';
				break;
			case 4108:				// Suisse
				$id_pays = 'CH';
				break;
			case 4141: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4185: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4189:				// Suisse
				$id_pays = 'CH';
				break;
			case 4213:				// Suisse
				$id_pays = 'CH';
				break;
			case 4217:
				$ville = "SAINT LEU";
				break;
			case 4218:
				$id_pays = 'FR';
				break;
			case 4231:
				$id_pays = 'FR';
				break;
			case 4273:
				$id_pays = 'FR';
				break;
			case 4288:
				$id_pays = 'FR';
				$ville = "Chateau D'olonne";
				break;
			case 4289:
				$id_pays = 'FR';
				break;
			case 4293:				// Suisse
				$id_pays = 'CH';
				break;
			case 4310:				// Suisse
				$id_pays = 'CH';
				break;
			case 4314:
				$id_pays = 'FR';
				break;
			case 4322:
				$id_pays = 'FR';
				break;
			case 4362:
				$ville = "ALBI";
				break;
			case 4363:
				$id_pays = 'FR';
				break;
			case 4379:
				$id_pays = 'FR';
				break;
			case 4396:
				$id_pays = 'FR';
				break;
			case 4404:
				$id_pays = 'FR';
				break;
			case 4407:
				$id_pays = 'FR';
				break;
			case 4419:
				$id_pays = 'FR';
				break;
			case 4434:
				$id_pays = 'FR';
				break;
			case 4435:
				$id_pays = 'FR';
				break;
			case 4439:
				$id_pays = 'FR';
				break;
			case 4473:
				$id_pays = 'FR';
				break;
			case 4487:
				$id_pays = 'FR';
				break;
			case 4498:
				$id_pays = 'FR';
				break;
			case 4508:
				$id_pays = 'FR';
				break;
			case 4547:
				$id_pays = 'FR';
				break;
			case 4557:
				$id_pays = 'FR';
				break;
			case 4558:
				$id_pays = 'FR';
				break;
			case 4572:
				$id_pays = 'FR';
				break;
			case 4574:
				$id_pays = 'FR';
				break;
			case 4575:
				$id_pays = 'FR';
				break;
			case 4586:
				$id_pays = 'FR';
				break;
			case 4587:
				$id_pays = 'FR';
				break;
			case 4607:
				$id_pays = 'FR';
				break;
			case 4609:
				$id_pays = 'FR';
				break;
			case 4615:
				$id_pays = 'FR';
				break;
			case 4619:
				$id_pays = 'FR';
				break;
			case 4621:				// Belgique
				$id_pays = 'BE';
				break;
			case 4639:
				$id_pays = 'FR';
				$cp = 13120;
				break;
			case 4645:
				$id_pays = 'FR';
				break;
			case 4663:				// Suisse
				$id_pays = 'CH';
				break;
			case 4666:
				$id_pays = 'FR';
				break;
			case 4669:				// Suisse
				$id_pays = 'CH';
				break;
			case 4679:
				$id_pays = 'FR';
				$ville = "L'ISLE D'ABEAU";
				break;
			case 4680:
				$id_pays = 'FR';
				break;
			case 4706:
				$id_pays = 'FR';
				break;
			case 4719:
				$id_pays = 'FR';
				break;
			case 4728:
				$id_pays = 'FR';
				break;
			case 4736:
				$id_pays = 'FR';
				break;
			case 4741:
				$id_pays = 'FR';
				break;
			case 5185: 				// Belgique
				$id_pays = 'BE';
				break;
			case 3959: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4113: 				// Belgique
				$id_pays = 'BE';
				break;
			case 4132:				// Belgique
				$id_pays = 'BE';
				break;
			case 4243:
				$ville = "CHATEAUROUX";
				break;
			case 4639:
				$cp = 13120;
				break;
		}

		// Si ville non définie manuellement
		if(!isset($id_ville))
		{
			$id_ville = get_ville($id_pays,$cp,$ville);
		}
	}
	else
	{
		$id_ville = -3;
	}
	
	return array(
		"id_ville"	=> $id_ville,
		"id_pays"	=> $id_pays
	);
}

// Fonction de validation de l'email, elle va vérifier que l'email est bien 
// dans le bon format et qu'il n'est pas présent en double
// Output :
// 1 => Email pas au bon format
// 2 => Email en double dans peel_utilisateurs
// Sinon renvoi l'email de l'utilisateur
function validate_peel_utilisateurs_email($email,$id_utilisateur)
{
	global $db_v1;
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		switch($id_utilisateur)
		{
			case 4:case 11: case 15: case 20: case 21: case 22: case 54: case 219: case 442: case 517: case 545: case 589:
			case 595: case 633: case 802: case 841: case 872: case 873: case 1096: case 1136: case 1209: case 1257:
			case 1317: case 1388: case 1988: case 1399: case 1438: case 1453: case 1463: case 1506: case 1533: case 1539:
			case 1597: case 1623: case 1663: case 1787: case 1884: case 1890: case 1892: case 1929: case 2034: case 2286:
			case 3366:
				// Ignorer les erreurs pour les numéros ci dessus
				break;
			case 596:
				$email = "marinette313@hotmail.fr";
				break;
			case 1274:
				$email = "claudejul@aol.com";
				break;
			case 2133:
				$email = "somma.line@gmail.com";
				break;
			case 2212:
				$email = "harmonie_fila@orange";
				break;
			case 2255:
				$email = "anne_surkijn@voo.be";
				break;
			case 3944:
				$email = "pirontalexia@hotmail.com";
				break;
			case 3953:
				$email = "bandie62@hotmail.fr";
				break;
			default:
				$email = 1;
				break;
		}
	}
	
	$req = $db_v1->prepare("SELECT `email` FROM `peel_utilisateurs` WHERE `email` = :email");
	$req->execute(array("email" => $email));
	
	if($req->rowCount() > 1)
	{
		$email = 2;
	}
	
	$req->closeCursor();
	
	return $email;
}

// Fonction de validation du pseudo, elle va vérifier que le pseudo est bien 
// unique dans les tables utilisateurs
// Output :
// 1 => Pseudo en double dans peel_utilisateurs
// 2 => Pseudo deja présent dans users
// Sinon renvoi le niveau d'autorisation de l'utilisateur (staff ou membre)
function validate_peel_utilisateurs_pseudo($pseudo,$id_membre = NULL)
{
	global $db_v1,$db_v2;
	
	$level = 0;
	
	switch($pseudo)
	{
		case "Babbou":
			$level = "staff";
			break;
		case "Limë":
			$level = "staff";
			break;
		default:
			$req = $db_v1->prepare("SELECT `pseudo` FROM `peel_utilisateurs` WHERE `pseudo` = :pseudo");
			$req->execute(array("pseudo" => $pseudo));
			
			if($req->rowCount() == 1)
			{
				$level = "membre";
			}
			else
			{
				$donnees = $req->fetch();
				
				if($pseudo === $donnees['pseudo'])
				{
					$level = 1;
				}
			}
			
			$req->closeCursor();
			
			$result = json_decode(curlQuery("https://api.larchiviste.fr/users/get?pseudo=".rawurlencode($pseudo)."&app=NhNWKfsvPJG09wlhT62o&key=LDpkLwmysBVdw1kE9hqH0q5KpPnE3oqO2Q9NmvmO7i1EjmisDJ"));
	
			if(is_array($result->response->datas))
			{
				if(is_null($id_membre))
				{
					if($pseudo === $result->response->datas[0]->pseudo)
					{
						$level = 2;
					}
				}
				else
				{
					// On ignore le fait que le pseudo est identique s'il s'agit d'une syncrho du membre
					if($pseudo === $result->response->datas[0]->pseudo AND $id_membre != $result->response->datas[0]->id_membre)
					{
						echo "plop ".$id_membre." ".$result->response->datas[0]->id_membre;
						$level = 2;
					}
				}
			}
			break;
	}
	
	return $level;
}

// Fonction permettant la recherche du nouvel ID de l'utilisateur
// Output :
// -1 => Utilisateur inconnu
// Sinon renvoi l'ID de l'utilisateur
function validate_new_id($email)
{
	global $db_v2;
	
	$flag = 0;
	
	$req = $db_v2->prepare("SELECT `id_membre` FROM `users` WHERE `email` = :email");
	$req->execute(array("email" => $email));
	
	if($req->rowCount())
	{
		$donnees = $req->fetch();
		
		$flag = $donnees['id_membre'];
	}
	else
	{
		$flag = -1;
	}
	
	$req->closeCursor();
	
	return $flag;
}