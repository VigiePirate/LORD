<?php

switch($section)
{
	case "add":
		echo "Soon";
		break;
	case "sav":
		$nb_rats = $lordrat->countRats(array('sav' => 2))->response->datas;
		
		echo "<h3>Liste des Rats en attente de traitement</h3>";
		
		$nb_elems = 25;
		
		$nb_pages = ceil($nb_rats / $nb_elems);
		
		if(!empty(filter_input(INPUT_GET,'num_page',FILTER_SANITIZE_NUMBER_INT)))
		{
			$num_page = filter_input(INPUT_GET,'num_page',FILTER_SANITIZE_NUMBER_INT);
		}
		else
		{
			$num_page = 1;
		}
		
		$orders = array("affixe","!affixe","dateajout","!dateajout","nom","!nom","numero","!numero","origine","!origine","proprio","!proprio");
		
		if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)) AND in_array(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING),$orders))
		{
			$order = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
		}
		else
		{
			$order = "!dateajout";
		}
		
		$start = $nb_elems * ($num_page - 1);
		
		$params = array(
			"etat"		=> 2,
			"order"		=> $order,
			"content"	=> 'list',
			"start"		=> $start,
			"quantity"	=> $nb_elems
		);
		
		$rats = $lordrat->searchRat($params);
		
		//print_r($rats);
		
		// Affichage des boutons pour le changement de page
		echo "<div class='text-center'><div class='btn-group'>";
		
		// Bouton retour première page et page précédente
		if($num_page > 1)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=1\";'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".($num_page - 1)."\";'><i class='fa fa-angle-left'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-left'></i></div>";
		}
		
		if($num_page < 7)
		{
			for($i = 1 ; $i < $num_page ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = 1 ; $i < 3 ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
			
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($num_page - 3) ; $i < ($num_page - 1) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Affichage page courante
		echo "<div class='btn btn-lord active'>".$num_page."</div>";
		
		if($num_page > ($nb_pages - 7))
		{
			for($i = ($num_page + 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = ($num_page + 1) ; $i < ($num_page + 3) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($nb_pages - 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Bouton retour page suivante et dernière page
		if($num_page < $nb_pages)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".($num_page + 1)."\";'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$nb_pages."\";'><i class='fa fa-angle-double-right'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-right'></i></div>";
		}
		
		echo "</div></div>";
		
		echo "
		<div class='table-responsive' style='margin-top:5px;'>
			<table class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Numero</th>
						<th>Nom</th>
						<th>Propriétaire</th>
						<th>Origne</th>
						<th>Status</th>
						<th>Date d'ajout</th>
						<th style='width:120px;'>Actions</th>
					</tr>
				</thead>
				<tbody>";
		
		foreach($rats as $rat)
		{
			if($rat->sav_check != "")
			{
				$etat = "Traitement SAV V1";
			}
			else
			{
				$etat = "Attente SAV";
			}
			
			// Réccupération de l'état SAV détaillé du RAT
			$sav_state = $lordrat->listRatSavMsg(array('rat' => $rat->id));
			
			if(is_array($sav_state))
			{
				$lastmsg = reset($sav_state);
				
				if($lastmsg->user->level == "staff" OR $lastmsg->user->level == "sav")
				{
					$etat = "Attente Utilisateur";
				}
				else
				{
					$etat = "Attente SAV";
				}
			}
			
			echo "
			<tr>
				<td>".$rat->numero."</td>
				<td>".$rat->nom_naissance_rat."</td>
				<td>".$rat->proprio->pseudo."</td>
				<td>".$rat->raterie->nom."</td>
				<td>".$etat."</td>
				<td>".date('d-m-Y',$rat->date_ajout)."</td>
				<td>
					<div id='rat-sav-btn-".$rat->id."' class='btn btn-sm btn-lord rat-sav-btn open-pop-up open-pop-up-lg' data-id='".$rat->id."'><i class='fas fa-search'></i></div>
					<div id='ratsav-msg-btn-".$rat->id."' class='btn btn-sm btn-lord ratsav-msg-btn open-pop-up open-pop-up-md' data-id='".$rat->id."'><i class='fas fa-envelope'></i></div>
				</td>
			</tr>";
		}
		
		echo "
				</tbody>
			</table>
		</div>";
		
		// Affichage des boutons pour le changement de page
		echo "<div class='text-center'><div class='btn-group'>";
		
		// Bouton retour première page et page précédente
		if($num_page > 1)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=1\";'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".($num_page - 1)."\";'><i class='fa fa-angle-left'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-left'></i></div>";
		}
		
		if($num_page < 7)
		{
			for($i = 1 ; $i < $num_page ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = 1 ; $i < 3 ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
			
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($num_page - 3) ; $i < ($num_page - 1) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Affichage page courante
		echo "<div class='btn btn-lord active'>".$num_page."</div>";
		
		if($num_page > ($nb_pages - 7))
		{
			for($i = ($num_page + 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = ($num_page + 1) ; $i < ($num_page + 3) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($nb_pages - 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Bouton retour page suivante et dernière page
		if($num_page < $nb_pages)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".($num_page + 1)."\";'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&amp;section=sav&amp;order=".$order."&amp;num_page=".$nb_pages."\";'><i class='fa fa-angle-double-right'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-right'></i></div>";
		}
		
		echo "</div></div>";
		break;
	default: // Affichage liste par défaut
		$nb_rats = $lordrat->countRats()->response->datas;
		
		echo "<h3>Liste des Rats</h3>";
		
		$nb_elems = 25;
		
		$nb_pages = ceil($nb_rats / $nb_elems);
		
		if(!empty(filter_input(INPUT_GET,'num_page',FILTER_SANITIZE_NUMBER_INT)))
		{
			$num_page = filter_input(INPUT_GET,'num_page',FILTER_SANITIZE_NUMBER_INT);
		}
		else
		{
			$num_page = 1;
		}
		
		$orders = array("affixe","!affixe","dateajout","!dateajout","nom","!nom","numero","!numero","origine","!origine","proprio","!proprio");
		
		if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)) AND in_array(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING),$orders))
		{
			$order = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
		}
		else
		{
			$order = "!dateajout";
		}
		
		$start = $nb_elems * ($num_page - 1);
		
		$rats = $lordrat->listRats($order,'list',$start,$nb_elems)->response->datas;
		
		//print_r($rats);
		
		// Affichage des boutons pour le changement de page
		echo "<div class='text-center'><div class='btn-group'>";
		
		// Bouton retour première page et page précédente
		if($num_page > 1)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=1\";'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".($num_page - 1)."\";'><i class='fa fa-angle-left'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-left'></i></div>";
		}
		
		if($num_page < 7)
		{
			for($i = 1 ; $i < $num_page ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = 1 ; $i < 3 ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
			
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($num_page - 3) ; $i < ($num_page - 1) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Affichage page courante
		echo "<div class='btn btn-lord active'>".$num_page."</div>";
		
		if($num_page > ($nb_pages - 7))
		{
			for($i = ($num_page + 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = ($num_page + 1) ; $i < ($num_page + 3) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($nb_pages - 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Bouton retour page suivante et dernière page
		if($num_page < $nb_pages)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".($num_page + 1)."\";'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$nb_pages."\";'><i class='fa fa-angle-double-right'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-right'></i></div>";
		}
		
		echo "</div></div>";
		
		echo "
		<div class='table-responsive' style='margin-top:5px;'>
			<table class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Numero</th>
						<th>Nom</th>
						<th>Propriétaire</th>
						<th>Origne</th>
						<th>Status</th>
						<th>Date d'ajout</th>
						<th style='width:120px;'>Actions</th>
					</tr>
				</thead>
				<tbody>";
		
		foreach($rats as $rat)
		{
			
			switch($rat->etat)
			{
				case "1":
					$etat = "OK";
					break;
				case "2":
					$etat = "SAV";
					break;
				default:
					$etat = "Inconnu";
					break;
			}
			
			echo "
			<tr>
				<td>".$rat->numero."</td>
				<td>".$rat->nom_naissance_rat."</td>
				<td>".$rat->proprio->pseudo."</td>
				<td>".$rat->raterie->nom."</td>
				<td>".$etat."</td>
				<td>".date('d-m-Y',$rat->date_ajout)."</td>
				<td>
					<div id='rat-sav-btn-".$rat->id."' class='btn btn-sm btn-lord rat-sav-btn open-pop-up open-pop-up-lg' data-id='".$rat->id."'><i class='fas fa-search'></i></div>
					<div id='ratsav-msg-btn-".$rat->id."' class='btn btn-sm btn-lord ratsav-msg-btn open-pop-up open-pop-up-md' data-id='".$rat->id."'><i class='fas fa-envelope'></i></div>
				</td>
			</tr>";
		}
		
		echo "
				</tbody>
			</table>
		</div>";
		
		// Affichage des boutons pour le changement de page
		echo "<div class='text-center'><div class='btn-group'>";
		
		// Bouton retour première page et page précédente
		if($num_page > 1)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=1\";'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".($num_page - 1)."\";'><i class='fa fa-angle-left'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-left'></i></div>";
		}
		
		if($num_page < 7)
		{
			for($i = 1 ; $i < $num_page ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = 1 ; $i < 3 ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
			
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($num_page - 3) ; $i < ($num_page - 1) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Affichage page courante
		echo "<div class='btn btn-lord active'>".$num_page."</div>";
		
		if($num_page > ($nb_pages - 7))
		{
			for($i = ($num_page + 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = ($num_page + 1) ; $i < ($num_page + 3) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($nb_pages - 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Bouton retour page suivante et dernière page
		if($num_page < $nb_pages)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".($num_page + 1)."\";'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rats&order=".$order."&num_page=".$nb_pages."\";'><i class='fa fa-angle-double-right'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-right'></i></div>";
		}
		
		echo "</div></div>";
		break;
}
		

