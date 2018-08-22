<?php

// Configuration connexion Base de données
define('LORDRAT_DB_HOST'	,'localhost');
define('LORDRAT_DB_DATABASE','lordrat_v2');
define('LORDRAT_DB_USER'	,'lordrat_api');
define('LORDRAT_DB_PASSWORD','PXG0KyAILMa40pWF');

// Configuration des valeurs de fonctionnement
define('LORDRAT_MAX_QUERY_RESULTS',		500);

// Configuration des messages d'erreurs
define('LORDRAT_ERROR_DELETE_TABLE_FAILED',		"La suppression des données a échoué");
define('LORDRAT_ERROR_INEXISTENT_ITEM',			"Cette entrée dans la base de données n'existe pas.");
define('LORDRAT_ERROR_INSERT_TABLE_FAILED',		"L'ajout des données a échoué.");
define('LORDRAT_ERROR_MISSING_PARAMS',			"La requête n'a pas les paramètres requis.");
define('LORDRAT_ERROR_NO_RESULTS',				"Il n'y a aucun résultat pour cette recherche.");
define('LORDRAT_ERROR_TO_MANY_RESULTS',			"Merci d'affiner le champ de votre requête. Plus de ".LORDRAT_MAX_QUERY_RESULTS." résultats.");
define('LORDRAT_ERROR_UPDATE_TABLE_FAILED',		"La mise à jour des données a échoué.");
define('LORDRAT_ERROR_UPDATE_NO_CHANGE',		"Aucune modification n'a été apportée aux données.");
define('LORDRAT_ERROR_WRONG_CONTENT_SELECTION',	"Cette méthode de sélection de contenue n'est pas définie.");