<?php
if(!empty(filter_input(INPUT_GET,'rat',FILTER_SANITIZE_STRING)))
{
	$id = filter_input(INPUT_GET,'rat',FILTER_SANITIZE_STRING);

	if(is_numeric($id))
	{
		$rat = $lordrat->getRat("base",array("id" => $id))->response->datas;
	}
	else
	{
		$rat = $lordrat->getRat("base",array("numero" => $id))->response->datas;
	}
	
	if(is_array($rat))
	{
		// Construction de la structure de la page
		
		error_log(print_r($rat,true));
		
		if(isset($rat[0]->image->error))
		{
			$image = "<img src='http://www.lord-rat.org/images/photo-non-disponible.gif' alt='Indisponible'/>";
		}
		else if(isset($rat[0]->image[0]->fichier))
		{
			$image = "<img style='max-width:200px;' src='http://www.lord-rat.org/upload/".$rat[0]->image[0]->fichier."' alt='".$rat[0]->image[0]->fichier."'/>";
		}
		else
		{
			$image = "<img src='http://www.lord-rat.org/images/photo-non-disponible.gif' alt='Indisponible'/>";
		}
		
		$contenu = "<table style='min-width:98%;'><tr>";
		
		// Traitement des informations sur les parents
		if($rat[0]->pere->id != 0)
		{
			$pere = "<a href='index.php?page=fiche&rat=".$rat[0]->pere->id."'>".$rat[0]->pere->affixe." ".$rat[0]->pere->nom_naissance."</a>";
		}
		else
		{
			$pere = "Pas de père déclaré";
		}
		
		if($rat[0]->mere->id != 0)
		{
			$mere = "<a href='index.php?page=fiche&rat=".$rat[0]->mere->id."'>".$rat[0]->mere->affixe." ".$rat[0]->mere->nom_naissance."</a>";
		}
		else
		{
			$mere = "Pas de mère déclarée";
		}
		
		// Gestion des informations si rat est vivant ou décédé
		if($rat[0]->vivant == 'Oui')
		{
			$age_mois = floor((time() - $rat[0]->date_naissance->raw) / (3600 * 24 * 30.44));
			
			$status = "
			<b>Status</b> : Vivant<br />";
		}
		else
		{
			if($rat[0]->date_deces->raw == 0)
			{
				$age_mois = -1;
				
				$status = "
				<b>Status</b> : Décédé<br />
				<b>Date du décès</b> : Non précisée<br />
				<b>Cause du décès</b> : ".$rat[0]->cause_deces->nom->FR."<br />";
			}
			else
			{
				//$age_annees = floor(($rat[0]->date_deces->raw - $rat[0]->date_naissance->raw) / (3600 * 24 * 365));
				
				//$age_mois = floor(((($rat[0]->date_deces->raw - $rat[0]->date_naissance->raw) - ((3600 * 24 * 365) * $age_annees)) / (3600 * 24 * 30.44)));
				
				$age_mois = floor(($rat[0]->date_deces->raw - $rat[0]->date_naissance->raw) / (3600 * 24 * 30.44));
				
				$status = "
				<b>Status</b> : Décédé<br />
				<b>Date du décès</b> : ".date('d/m/Y',$rat[0]->date_deces->raw)."<br />
				<b>Cause du décès</b> : ".$rat[0]->cause_deces->nom->FR."<br />";
			}
		}
			
		/*switch($age_annees)
		{
			case -1:
				$age_string = "Inconnu";
				break;
			case 0:
				$age_string = "Moins de 1 An";
				break;
			case 1:
				$age_string = $age_annees." An";
				break;
			default:
				$age_string = $age_annees." Ans";
				break;
		}
		
		if($age_mois > 0)
		{
			$age_string .= " et ".$age_mois." Mois";
		}*/
		
		switch($age_mois)
		{
			case -1:
				$age_string = "Inconnu";
				break;
			case 0:
				$age_string = "Moins de 1 Mois";
				break;
			default:
				$age_string = $age_mois." Mois";
				break;
		}
		
		$uniques = "";
		
		foreach($rat[0]->uniques as $unique)
		{
			if($uniques == "")
			{
				$uniques = $unique->nom->FR;
			}
			else
			{
				$uniques .= ",".$unique->nom->FR;
			}
		}
		
		$contenu .= "
		<td>
			<h3 style='color:#8795E8;'>Identité</h3>
			<b>Numero</b> : ".$rat[0]->numero."<br />
			<b>Propriétaire</b> : <a href='index.php?page=fiche&utilisateur=".$rat[0]->proprio->id."'>".$rat[0]->proprio->nom."</a><br />
			<b>Nom de naissance</b> : ".$rat[0]->nom_courant."<br />
			<b>Sexe</b> : ".$rat[0]->sexe."<br />
			<b>Naissance</b> : ".$rat[0]->date_naissance->string."<br />
			".$status."
			<b>Age</b> : ".$age_string."
			<br />
			<h3 style='color:#8795E8;'>Généalogie</h3>
			<b>Origine</b> : <a href='index.php?page=fiche&raterie=".$rat[0]->raterie->id."'>".$rat[0]->raterie->nom."</a><br />
			<b>Père</b> : ".$pere."<br />
			<b>Mère</b> : ".$mere."<br />
			<b>Généalogie</b> : Indisponible pour l'instant<br />
			<br /> 
			<h3 style='color:#8795E8;'>Phénotype</h3>
			<b>Couleur</b> : ".$rat[0]->couleur->nom->FR."<br />
			<b>Dilution</b> : ".$rat[0]->dilution->nom->FR."<br />
			<b>Marquage</b> : ".$rat[0]->marquage->nom->FR."<br />
			<b>Particularité(s)</b> : ".$uniques."<br />
			<b>Type d'oreilles</b> : ".$rat[0]->oreilles->nom->FR."<br />
			<b>Type de poil</b> : ".$rat[0]->poils->nom->FR."<br />
			<b>Couleur des yeux</b> : ".$rat[0]->yeux->nom->FR."<br />
		</td>";
		
		// Intégration Image
		$contenu .= "<td valign='middle' style='text-align:center;min-width:200px;'>".$image."</td>";
		
		$contenu .= "</tr><tr><td colspan='2'>";
		
		$contenu .= "<h3 style='color:#8795E8;'>Commentaires</h3><p>".$rat[0]->commentaires."</p>";
		
		$contenu .= "</td></tr></table>";
		
		// Affichage de la descendance
		$contenu .= "
		<h3 style='color:#8795E8;'>Descendance :</h3>
		<table class='table-blue table-centered'>
			<thead>
				<tr>
					<th>Voir la fiche</th>
					<th>Date de Naissance</th>
					<th>Age</th>
					<th>Date de Décès</th>
					<th>Cause de Décès</th>
					<th>X</th>
				</tr>
			</thead>
			<tbody>";
		
		$descendance = $lordrat->getRat("descendance",array("id" => $id))->response->datas;
		
		if(is_array($descendance))
		{
			//print_r($descendance);
			foreach($descendance as $child)
			{
				// Préparation de l'information sur l'autre parent du couple de rat
				if($child->pere->id == $id) // Nous somme sur la fiche du pere, on affiche les informations sur la mère
				{
					if($child->mere->id != 0) // Une mère est bien renseignée
					{
						$child_other_parent = "<a href='index.php?page=fiche&rat=".$child->mere->id."'>".$child->mere->affixe." ".$child->mere->nom_naissance."</a>";
					}
					else
					{
						$child_other_parent = "Mère non déclarée";
					}
				}
				else // Sinon on affiche les informations sur le père
				{
					if($child->pere->id != 0) // Un père est bien renseignée
					{
						$child_other_parent = "<a href='index.php?page=fiche&rat=".$child->pere->id."'>".$child->pere->affixe." ".$child->pere->nom_naissance."</a>";
					}
					else
					{
						$child_other_parent = "Père non déclaré";
					}
				}

				// gestion affichage date de décès
				if($child->vivant == 'Oui')
				{
					$statut = "<td colspan='2'>Actuellement vivant</td>";
				}
				else
				{
					if($child->date_deces->raw != 0)
					{
						$statut = "
						<td>".date('d/m/Y',$child->date_deces->raw)."</td>
						<td>".$child->cause_deces->nom->FR."</td>";
					}
					else
					{
						$statut = "
						<td>Non déclarée</td>
						<td>".$child->cause_deces->nom->FR."</td>";
					}
				}
				
				if($child->date_deces->raw == 0)
				{
					$date_fin = time();
				}
				else
				{
					$date_fin = $child->date_deces->raw;
				}
				
				$age_mois = floor(($date_fin - $child->date_naissance->raw) / (3600 * 24 * 30.44));
				
				switch($age_mois)
				{
					case "0":
						$age_string = "Moins de 1 Mois";
						break;
					default:
						$age_string = $age_mois." Mois";
						break;
				}

				$contenu .= "
				<tr>
					<td><a href='index.php?page=fiche&rat=".$child->id_rat."'>".$child->raterie->affixe." ".$child->nom_naissance."</a></td>
					<td>".$child->date_naissance->string."</td>
					<td>".$age_string."</td>
					".$statut."
					<td>".$child_other_parent."</td>
				</tr>";
			}
		}
		else
		{
			$contenu .= "<tr><td colspan='5'>Aucune descendance de renseignée</td></tr>";
		}
		
		
		
		$contenu .= "
			</tbody>
		</table>";
		
		$datas_page = array(
			"titre"		=> "Fiche du rat ".$rat[0]->raterie->affixe." ".$rat[0]->nom_naissance,
			"contenu"	=> $contenu,
			"special"	=> ""
		);
	}
	else
	{
		$datas_page = array(
			"titre"		=> "Rat Introuvable",
			"contenu"	=> "Soit ce rat n'existe pas/plus soit le lien que vous avez suivi à un problème.",
			"special"	=> ""
		);
	}
}
else if(!empty(filter_input(INPUT_GET,'raterie',FILTER_SANITIZE_STRING)))
{
	$id = filter_input(INPUT_GET,'raterie',FILTER_SANITIZE_STRING);
	
	if(is_numeric($id))
	{
		$datas = $lordrat->getRaterie("base",array("id" => $id))->response->datas;
	}
	else
	{
		$datas = $lordrat->getRaterie("base",array("affixe" => $id))->response->datas;
	}
	
	if(is_array($datas))
	{
		$raterie = $datas[0];
		
		// Traitement du logo
		if($raterie->logo != "")
		{
			$logo_raterie = "<img src='http://www.lord-rat.org/upload/".$raterie->logo."' alt='".$raterie->logo."' />";
		}
		else
		{
			$logo_raterie = "";
		}
		
		// Traitement de la présentation
		if($raterie->presentation != "")
		{
			$presentation_raterie = nl2br($raterie->presentation);
		}
		else
		{
			$presentation_raterie = "Cette raterie n'a pas encore de présentation";
		}
		
		// Réccupération du site web renseigné pour l'utilisateur
		$user_site = $lordrat->getUtilisateur("site",array("id" => $raterie->id_membre))->response->datas;
		
		if(is_array($user_site))
		{
			if($user_site[0]->nom != "")
			{
				$nom_site = $user_site[0]->nom;
			}
			else
			{
				$nom_site = "Site Web de la Raterie";
			}
			
			if (!preg_match("~^(?:f|ht)tps?://~i", $user_site[0]->url))
			{
				$url_site = "http://" . $user_site[0]->url;
			}
			else
			{
				$url_site = $user_site[0]->url;
			}
			
			$site_raterie = "<a href='".$url_site."' target='_blank'>".$nom_site."</a>";
		}
		else
		{
			$site_raterie = "Cette Raterie n'a pas de site web";
		}
		
		$user_infos = $lordrat->getUtilisateur("base",array("id" => $raterie->id_membre))->response->datas;
		
		if(is_array($user_infos))
		{
			$fiche_proprio = "<a href='index.php?page=fiche&amp;utilisateur=".$user_infos[0]->id_membre."'>".$user_infos[0]->pseudo."</a>";
		}
		else
		{
			$fiche_proprio = "Cette raterie n'a pas de propriétaire renseigné.";
		}
		
		$contenu = "
		<div>
			<div style='text-align:center;'><p>".$logo_raterie."</p></div>
			<p>Propriétaire de la raterie : ".$fiche_proprio."</p>
			<p>".$site_raterie."</p>
			<p>".$presentation_raterie."</p>
			<div style='display:inline-block;width:100%;text-align:center;'>
				<form method='post' action='index.php?page=recherche&extendedsearch=1' target='_blank'>
					<input type='hidden' name='extendedsearch' value='1' />
					<input type='hidden' name='origine' value='".$id."' />
					<p><input type='submit' value='Chercher ses rats' /></p>
				</form>
			</div>
		</div>";
		
		$datas_page = array(
			"titre"		=> "Fiche de la raterie ".$raterie->affixe." ".$raterie->nom,
			"contenu"	=> $contenu,
			"special"	=> ""
		);
	}
	else
	{
		$datas_page = array(
			"titre"		=> "Raterie Introuvable",
			"contenu"	=> "Soit cette raterie n'existe pas/plus soit le lien que vous avez suivi à un problème.",
			"special"	=> ""
		);
	}
}
else if(!empty(filter_input(INPUT_GET,'utilisateur',FILTER_SANITIZE_NUMBER_INT)))
{
	$id = filter_input(INPUT_GET,'utilisateur',FILTER_SANITIZE_NUMBER_INT);
	
	$user_infos = $lordrat->getUtilisateur("fiche",array("id" => $id))->response->datas;
	
	if(is_array($user_infos))
	{
		if(!is_null($user_infos[0]->raterie->id))
		{
			$raterie_status = $user_infos[0]->raterie->nom;
			$raterie_btn = "
			<div style='display:inline-block;width:49%;text-align:center;'>
				<p><input type='button' value='Fiche de sa raterie' onclick='window.open(\"index.php?page=fiche&raterie=".$user_infos[0]->raterie->id."\", \"_blank\");'/></p>
			</div>";
		}
		else
		{
			$raterie_status = "Ne possède pas de raterie";
			$raterie_btn = "";
		}
		
		if(empty($raterie_btn))
		{
			$width_search_rats = "100%";
		}
		else
		{
			$width_search_rats = "49%";
		}
		
		$contenu = "
		<div>
			<ul>
				<li>Raterie : ".$raterie_status."</li>
			</ul>
		</div>
		<div>
			<div style='display:inline-block;width:".$width_search_rats.";text-align:center;'>
				<form method='post' action='index.php?page=recherche&extendedsearch=1' target='_blank'>
					<input type='hidden' name='extendedsearch' value='1' />
					<input type='hidden' name='proprio' value='".$id."' />
					<p><input type='submit' value='Chercher ses rats' /></p>
				</form>
			</div>
			".$raterie_btn."
		</div>";
		
		$datas_page = array(
			"titre"		=> "Fiche de l'utilisateur ".$user_infos[0]->pseudo,
			"contenu"	=> $contenu,
			"special"	=> ""
		);
	}
	else
	{
		$datas_page = array(
			"titre"		=> "Utilisateur introuvable",
			"contenu"	=> "Cet utilisateur n'existe pas",
			"special"	=> ""
		);
	}
	
	
}
