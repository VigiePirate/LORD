<?php

// Réccupération du type de recherche
if(!empty(filter_input(INPUT_GET,'extendedsearch')))
{
	$searchtype = "extendedsearch";
}
else
{
	$searchtype = "fastsearch";
}

$fastsearch = filter_input(INPUT_POST,'fastsearch',FILTER_SANITIZE_STRING);

$params = array(
	"fastsearch"	=> filter_input(INPUT_POST,'fastsearch',FILTER_SANITIZE_STRING),
	"nom"			=> filter_input(INPUT_POST,'nom',FILTER_SANITIZE_STRING),
	"origine"		=> filter_input(INPUT_POST,'origine',FILTER_SANITIZE_NUMBER_INT),
	"proprio"		=> filter_input(INPUT_POST,'proprio',FILTER_SANITIZE_NUMBER_INT),
	"sexe"			=> filter_input(INPUT_POST,'sexe',FILTER_SANITIZE_STRING),
	"vivant"		=> filter_input(INPUT_POST,'vivant',FILTER_SANITIZE_STRING),
	"couleur"		=> filter_input(INPUT_POST,'couleur',FILTER_SANITIZE_NUMBER_INT),
	"yeux"			=> filter_input(INPUT_POST,'yeux',FILTER_SANITIZE_NUMBER_INT),
	"poils"			=> filter_input(INPUT_POST,'poils',FILTER_SANITIZE_NUMBER_INT),
	"oreilles"		=> filter_input(INPUT_POST,'oreilles',FILTER_SANITIZE_NUMBER_INT),
	"marquage"		=> filter_input(INPUT_POST,'marquage',FILTER_SANITIZE_NUMBER_INT),
	"dilution"		=> filter_input(INPUT_POST,'dilution',FILTER_SANITIZE_NUMBER_INT),
	"particularite"	=> filter_input(INPUT_POST,'particularite',FILTER_SANITIZE_NUMBER_INT),
	"repro"			=> filter_input(INPUT_POST,'repro',FILTER_SANITIZE_STRING)
);

// Réccupérations des données POST si présentes et execution de la requète
if(!empty(filter_input(INPUT_POST,'fastsearch',FILTER_SANITIZE_STRING)))
{
	$datas = $lordrat->searchRat(array("fastsearch" => $params['fastsearch']));
}
else if(!empty(filter_input(INPUT_POST,'extendedsearch')))
{
	$datas = $lordrat->searchRat($params);
}

// Réccupération des données pour menus déroulants des formulaires
$origines = $lordrat->listRateries("affixe","menu")->response->datas;

$select_origines = "<option value='0'>Toutes</option>";

foreach($origines as $origine)
{
	if($origine->id_raterie == $params['origine'])
	{
		$select_origines .= "<option value='".$origine->id_raterie."' selected>".$origine->affixe." - ".$origine->nom."</option>";
	}
	else
	{
		$select_origines .= "<option value='".$origine->id_raterie."'>".$origine->affixe." - ".$origine->nom."</option>";
	}
}

$proprios = $lordrat->listUsers("nom","menu")->response->datas;

$select_proprios = "<option value='0'>Tous</option>";

foreach($proprios as $proprio)
{
	if($proprio->id == $params['proprio'])
	{
		$select_proprios .= "<option value='".$proprio->id."' selected>".$proprio->pseudo."</option>";
	}
	else
	{
		$select_proprios .= "<option value='".$proprio->id."'>".$proprio->pseudo."</option>";
	}
}

switch($params['sexe'])
{
	case "M":
		$radio_sexe = "
		<td style='width:15%;'>
			<input type='radio' name='sexe' id='sexem' value='M' checked><label for='sexem'>Mâle</label>
		</td>
		<td style='width:15%;'>
			<input type='radio' name='sexe' id='sexef' value='F'><label for='sexef'>Femelle</label>
		</td>
		<td>
			<input type='radio' name='sexe' id='sexei' value='0'><label for='sexei'>Indifférent</label>
		</td>";
		break;
	case "F":
		$radio_sexe = "
		<td style='width:15%;'>
			<input type='radio' name='sexe' id='sexem' value='M'><label for='sexem'>Mâle</label>
		</td>
		<td style='width:15%;'>
			<input type='radio' name='sexe' id='sexef' value='F' checked><label for='sexef'>Femelle</label>
		</td>
		<td>
			<input type='radio' name='sexe' id='sexei' value='0'><label for='sexei'>Indifférent</label>
		</td>";
		break;
	default:
		$radio_sexe = "
		<td style='width:15%;'>
			<input type='radio' name='sexe' id='sexem' value='M'><label for='sexem'>Mâle</label>
		</td>
		<td style='width:15%;'>
			<input type='radio' name='sexe' id='sexef' value='F'><label for='sexef'>Femelle</label>
		</td>
		<td>
			<input type='radio' name='sexe' id='sexei' value='0' checked><label for='sexei'>Indifférent</label>
		</td>";
		break;
}

switch($params['vivant'])
{
	case "Oui":
		$radio_etat = "
		<td>
			<input type='radio' name='vivant' id='vivanto' value='Oui' checked><label for='vivanto'>Vivant</label>
		</td>
		<td>
			<input type='radio' name='vivant' id='vivantn' value='Non'><label for='vivantn'>Décédé</label>
		</td>
		<td>
			<input type='radio' name='vivant' id='vivanti' value='0'><label for='vivanti'>Indifférent
		</td>";
		break;
	case "Non":
		$radio_etat = "
		<td>
			<input type='radio' name='vivant' id='vivanto' value='Oui'><label for='vivanto'>Vivant</label>
		</td>
		<td>
			<input type='radio' name='vivant' id='vivantn' value='Non' checked><label for='vivantn'>Décédé</label>
		</td>
		<td>
			<input type='radio' name='vivant' id='vivanti' value='0'><label for='vivanti'>Indifférent
		</td>";
		break;
	default:
		$radio_etat = "
		<td>
			<input type='radio' name='vivant' id='vivanto' value='Oui'><label for='vivanto'>Vivant</label>
		</td>
		<td>
			<input type='radio' name='vivant' id='vivantn' value='Non'><label for='vivantn'>Décédé</label>
		</td>
		<td>
			<input type='radio' name='vivant' id='vivanti' value='0' checked><label for='vivanti'>Indifférent
		</td>";
		break;
}

$couleurs = $lordrat->listCriteres("couleurs","nom","menu")->response->datas;

$select_couleurs = "<option value='0'>Indifférent</option>";

foreach($couleurs as $couleur)
{
	if($couleur->id == $params['couleur'])
	{
		$select_couleurs .= "<option value='".$couleur->id."' selected>".$couleur->nom->FR."</option>";
	}
	else
	{
		$select_couleurs .= "<option value='".$couleur->id."'>".$couleur->nom->FR."</option>";
	}
}

$yeux = $lordrat->listCriteres("yeux","nom","menu")->response->datas;

$select_yeux = "<option value='0'>Indifférent</option>";

foreach($yeux as $oeil)
{
	if($oeil->id == $params['yeux'])
	{
		$select_yeux .= "<option value='".$oeil->id."' selected>".$oeil->nom->FR."</option>";
	}
	else
	{
		$select_yeux .= "<option value='".$oeil->id."'>".$oeil->nom->FR."</option>";
	}
}

$poils = $lordrat->listCriteres("poils","nom","menu")->response->datas;

$select_poils = "<option value='0'>Indifférent</option>";

foreach($poils as $poil)
{
	if($poil->id == $params['poils'])
	{
		$select_poils .= "<option value='".$poil->id."' selected>".$poil->nom->FR."</option>";
	}
	else
	{
		$select_poils .= "<option value='".$poil->id."'>".$poil->nom->FR."</option>";
	}
}

$oreilles = $lordrat->listCriteres("oreilles","nom","menu")->response->datas;

$select_oreilles = "<option value='0'>Indifférent</option>";

foreach($oreilles as $oreille)
{
	if($oreille->id == $params['oreilles'])
	{
		$select_oreilles .= "<option value='".$oreille->id."' selected>".$oreille->nom->FR."</option>";
	}
	else
	{
		$select_oreilles .= "<option value='".$oreille->id."'>".$oreille->nom->FR."</option>";
	}
}

$marquages = $lordrat->listCriteres("marquages","nom","menu")->response->datas;

$select_marquages = "<option value='0'>Indifférent</option>";

foreach($marquages as $marquage)
{
	if($marquage->id == $params['marquage'])
	{
		$select_marquages .= "<option value='".$marquage->id."' selected>".$marquage->nom->FR."</option>";
	}
	else
	{
		$select_marquages .= "<option value='".$marquage->id."'>".$marquage->nom->FR."</option>";
	}
}

$dilutions = $lordrat->listCriteres("dilutions","nom","menu")->response->datas;

$select_dilutions = "<option value='0'>Indifférent</option>";

foreach($dilutions as $dilution)
{
	if($dilution->id == $params['dilution'])
	{
		$select_dilutions .= "<option value='".$dilution->id."' selected>".$dilution->nom->FR."</option>";
	}
	else
	{
		$select_dilutions .= "<option value='".$dilution->id."'>".$dilution->nom->FR."</option>";
	}
}

$particularites = $lordrat->listCriteres("uniques","nom","menu")->response->datas;

$select_particularites = "<option value='0'>Indifférent</option>";

foreach($particularites as $particularite)
{
	if($particularite->id == $params['particularite'])
	{
		$select_particularites .= "<option value='".$particularite->id."' selected>".$particularite->nom->FR."</option>";
	}
	else
	{
		$select_particularites .= "<option value='".$particularite->id."'>".$particularite->nom->FR."</option>";
	}
}

switch($params['repro'])
{
	case "Oui";
		$radio_repro = "
		<input type='radio' name='repro' value='Oui' checked><label for='reproo'>Oui</label><br />
		<input type='radio' name='repro' value='Non' ><label for='repron'>Non</label><br />
		<input type='radio' name='repro' value='0' ><label for='reproi'>Indifférent</label>";
		break;
	case "Non";
		$radio_repro = "
		<input type='radio' name='repro' value='Oui' ><label for='reproo'>Oui</label><br />
		<input type='radio' name='repro' value='Non' checked><label for='repron'>Non</label><br />
		<input type='radio' name='repro' value='0' ><label for='reproi'>Indifférent</label>";
		break;
	default;
		$radio_repro = "
		<input type='radio' name='repro' value='Oui' ><label for='reproo'>Oui</label><br />
		<input type='radio' name='repro' value='Non' ><label for='repron'>Non</label><br />
		<input type='radio' name='repro' value='0' checked><label for='reproi'>Indifférent</label>";
		break;
}

// Construction des formulaires
$formulaire_simple = "
<form method='post' action='#'>
	<label for='fastsearch'>Recherche rapide : </label><input type='text' id='fastsearch' name='fastsearch' value='".$params['fastsearch']."' /><input type='submit' value='Valider' />
</form>";
		
$formulaire_avancé = "
<form method='post' action='#'>
	<input type='hidden' name='extendedsearch' value='1' />
	<fieldset>
		<legend><strong>Informations</strong></legend>
		<table style='width:100%;'>
			<tr>
				<td style='width:20%'>
					<label for='nom'>Nom : </label>
				</td>
				<td colspan='3'>
					<input type='text' id='nom' name='nom' style='width:50%;' value='".$params['nom']."'/>
				</td>
			</tr>
			<tr>
				<td>
					<label for='origine'>Origine : </label>
				</td>
				<td colspan='3'>
					<select id='origine' name='origine' style='width:50%;'>
						".$select_origines."
					</select>	
				</td>
			</tr>
			<tr>
				<td>
					<label for='proprio'>Propriétaire : </label>
				</td>
				<td colspan='3'>
					<select id='proprio' name='proprio' style='width:50%;'>
						".$select_proprios."
					</select>	
				</td>
			</tr>
			<tr>
				<td>
					<label>Sexe : </label>
				</td>
				".$radio_sexe."
			</tr>
			<tr>
				<td>
					<label>Etat : </label>
				</td>
				".$radio_etat."
			</tr>
		</table>
	</fieldset>
	<br />
	<fieldset>
		<legend><strong>Phénotype</strong></legend>
		<table style='width:100%;'>
			<tr>
				<td style='width:20%;'>
					<label for='couleur'>Couleur : </label>
				</td>
				<td style='width:30%;'>
					<select id='couleur' name='couleur' style='width:90%;'>   
						".$select_couleurs."
					</select>
				</td> 
				<td style='width:20%;'>
					<label for='yeux'>Yeux : </label>
				</td>
				<td>
					<select id='yeux' name='yeux' style='width:90%;'>
						".$select_yeux."
					</select>
				</td> 
			</tr>
			<tr>
				<td>
					<label for='poils'>Poils : </label>
				</td>
				<td>
					<select id='poils' name='poils' style='width:90%;'>               
						".$select_poils."
					</select>
				</td>
				<td>
					<label>Oreilles : </label>
				</td>
				<td>
					<select  name='oreilles' style='width:90%;'>              
						".$select_oreilles."
					</select>
				</td> 
			</tr>
			<tr>
				<td>
					<label for='marquage'>Marquage : </label>
				</td>
				<td>
					<select id='marquage' name='marquage' style='width:90%;'>
						".$select_marquages."
					</select>
				</td>
				<td>
					<label>Dilution : </label>
				</td>
				<td>
					<select id='dilution' name='dilution' style='width:90%;'>
						".$select_dilutions."
					</select>
				</td> 						
			</tr>
			<tr>
				<td>
					<label for='particularite'>Particularité : </label>
				</td>
				<td>
					<select id='particularite' name='particularite' style='width:90%;'>
						".$select_particularites."
					</select>
				</td>
			</tr>
		</table>	
	</fieldset>
	<br/>
	<fieldset>
		<legend><strong>Reproductible</strong></legend>
			<p>
				".$radio_repro."
			</p>
	</fieldset>
	<p><input type='submit' value='Rechercher' /></p>
</form>";

// Affichage des formulaires
switch($searchtype)
{
	case "extendedsearch":
		$title = "Recherche Avancée";
	
		$contenu = "
		".$formulaire_avancé."
		<p><a href='index.php?page=recherche&extendedsearch=0'>Recherche simple</a></p>";
		break;
	default:
		$title = "Recherche Rapide";
	
		$contenu = "
		".$formulaire_simple."
		<p><a href='index.php?page=recherche&extendedsearch=1'>Recherche avancée</a></p>";
		break;
}

// Si une recherche à eu lieu on affiche les résultats
if(isset($datas))
{
	if(isset($datas->error))
	{
		$contenu .= "<p>".$datas->error."</p>";
	}
	else
	{
		$contenu .= "<table width='100%' cellpadding='1' border='0'>";

		foreach($datas as $rat)
		{
			if(empty($rat->fichier))
			{
				$rat->fichier = "http://www.lord-rat.org/images/photo-non-disponible.gif";
			}
			else
			{
				$rat->fichier = "http://www.lord-rat.org/upload/".$rat->fichier;
			}

			$nom_rat = $rat->raterie->affixe." ";

			if(!empty($rat->nom_naissance_rat))
			{
				$nom_rat .= $rat->nom_naissance_rat;
			}

			if(!empty($rat->nom_courant_rat))
			{
				if(!empty($nom_rat))
				{
					$nom_rat .= " / ". $rat->nom_courant_rat;
				}
				else
				{
					$nom_rat .= $rat->nom_courant_rat;
				}
			}

			switch($rat->sexe)
			{
			case "M":
				$rat_couleur = "bleu";
				break;
			case "F":
				$rat_couleur = "rose";
				break;
			default:
				$rat_couleur = "gris";
				break;
			}

			$contenu .= "
		<tr>
			<td style='text-align:left;' width='30%'>
				<img src='".$rat->fichier."' width='100' height='75'/>
			</td>
			<td style='text-align:left;' width='40%'>
				<a href='index.php?page=fiche&rat=".$rat->id."'>".$nom_rat."</a>
			</td>
			<td style='text-align:left;' width='10%'>
				<img src='http://www.lord-rat.org/images/rat-".$rat_couleur.".jpg'>
			</td>
			<td>
				<a href='index.php?page=fiche&rat=".$rat->id."'>".$rat->numero."</a>
			</td>
		</tr>";
		}

		$contenu .= "</table>";
	}
}

$special = "";

$datas_page = array(
	"titre"		=> $title,
	"contenu"	=> $contenu,
	"special"	=> $special
);

