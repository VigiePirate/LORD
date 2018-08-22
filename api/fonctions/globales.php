<?php

// Permet de transformer les bytes utf8 sous format string en caratères utf8
function replace_code($string)
{
    $pattern = '/\\\\(x)?([0-9a-f]{2,3})/';
    return html_entity_decode(preg_replace_callback(
    $pattern,function($m){
        return chr($m[1]?hexdec($m[2]):octdec($m[2]));
    },
    $string),ENT_QUOTES);
}

function bindArrayValue($req, $array, $typeArray = array())
{
	$validType = array(PDO::PARAM_INT,PDO::PARAM_BOOL,PDO::PARAM_NULL,PDO::PARAM_STR);
	
    if(is_object($req) && ($req instanceof PDOStatement))
    {
        foreach($array as $key => $value)
        {
			// Rechere dans le tableau
			if(array_key_exists($key,$typeArray))
			{
				if(in_array($typeArray[$key],$validType))
				{
					$param = $typeArray[$key];
				}
				else
				{
					$param = FALSE;
				}
			}
			else
			{
				$param = FALSE;
			}
			
			// Recherche paramètre si non défini dans le tableau
			if(!$param)
			{
				if(is_numeric($value))
				{
                    $param = PDO::PARAM_INT;
				}
                elseif(is_bool($value))
				{
                    $param = PDO::PARAM_BOOL;
				}
                elseif(is_null($value))
				{
                    $param = PDO::PARAM_NULL;
				}
                elseif(is_string($value))
				{
                    $param = PDO::PARAM_STR;
				}
                else
				{
                    $param = FALSE;
				}
			}
			
			// Convertion des entiers contenue dans des chaines de textes
			switch($param)
			{
				case PDO::PARAM_INT:
					$value = (int) $value;
					break;
			}
			
			if($param)
			{
				$req->bindValue($key,$value,$param);
			}
        }
    }
	
	return $req;
}
