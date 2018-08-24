<?php

// Classe pour la gestion de l'authentification utilisateur
class LORDRAT_MYSQL_AUTH{
	private $_bdd;
	
	public function __construct($bdd)
	{
		if($bdd instanceof PDO)
		{
			$this->_bdd = $bdd;
		}
		else
		{
			throw new Exception("This is not a PDO Object !\n");
		}
	}
	
	
}