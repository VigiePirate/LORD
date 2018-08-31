<?php

switch($section)
{
	case "add":
		echo "Comming Soon ;)";
		break;
	case "map":
		echo "Visible à cette adresse : <a href='http://preview.lord-rat.org/index.php?page=article&load=carte_des_rateries' target='_blank'>http://preview.lord-rat.org/index.php?page=article&load=carte_des_rateries<a>";
		break;
	default:
		$nb_rateries = $lordrat->countRateries()->response->datas;
		
		echo "<h3>Liste des Rateries</h3>";
		
		$nb_elems = 25;
		
		$nb_pages = ceil($nb_rateries / $nb_elems);
		
		if(!empty(filter_input(INPUT_GET,'num_page',FILTER_SANITIZE_NUMBER_INT)))
		{
			$num_page = filter_input(INPUT_GET,'num_page',FILTER_SANITIZE_NUMBER_INT);
		}
		else
		{
			$num_page = 1;
		}
		
		$orders = array("affixe","!affixe","nom","!nom","proprio","!proprio");
		
		if(!empty(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING)) AND in_array(filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING),$orders))
		{
			$order = filter_input(INPUT_GET,'order',FILTER_SANITIZE_STRING);
		}
		else
		{
			$order = "affixe";
		}
		
		$start = $nb_elems * ($num_page - 1);
		
		$rateries = $lordrat->listRateries($order,'list',$start,$nb_elems)->response->datas;
		
		//print_r($rateries);
		
		// Affichage des boutons pour le changement de page
		echo "<div class='text-center'><div class='btn-group'>";
		
		// Bouton retour première page et page précédente
		if($num_page > 1)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=1\";'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".($num_page - 1)."\";'><i class='fa fa-angle-left'></i></div>";
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
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = 1 ; $i < 3 ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
			
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($num_page - 3) ; $i < ($num_page - 1) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Affichage page courante
		echo "<div class='btn btn-lord active'>".$num_page."</div>";
		
		if($num_page > ($nb_pages - 7))
		{
			for($i = ($num_page + 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = ($num_page + 1) ; $i < ($num_page + 3) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($nb_pages - 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Bouton retour page suivante et dernière page
		if($num_page < $nb_pages)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".($num_page + 1)."\";'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$nb_pages."\";'><i class='fa fa-angle-double-right'></i></div>";
		}
		else
		{
			echo "
			<div class='btn btn-lord disabled'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord disabled'><i class='fa fa-angle-double-right'></i></div>";
		}
		
		echo "</div></div>";
		
		echo "
		<div class='table-responsive' style='margin-top:15px;'>
			<table class='table table-striped table-bordered'>
				<thead>
					<tr>";
		
		if($order == "affixe")
		{
			echo "<th class='clicable' onclick='location.href=\"index.php?page=rateries&order=!affixe&num_page=".$num_page."\";'>Affixe <i class='fas fa-sort-alpha-up'></i></th>";
		}
		else if($order == "!affixe")
		{
			echo "<th class='clicable' onclick='location.href=\"index.php?page=rateries&order=affixe&num_page=".$num_page."\";'>Affixe <i class='fas fa-sort-alpha-down'></i></th>";
		}
		else
		{
			echo "<th class='clicable' onclick='location.href=\"index.php?page=rateries&order=affixe&num_page=".$num_page."\";'>Affixe</th>";
		}
		
		if($order == "nom")
		{
			echo "<th class='clicable' onclick='location.href=\"index.php?page=rateries&order=!nom&num_page=".$num_page."\";'>Nom <i class='fas fa-sort-alpha-up'></i></th>";
		}
		else if($order == "!nom")
		{
			echo "<th class='clicable' onclick='location.href=\"index.php?page=rateries&order=nom&num_page=".$num_page."\";'>Nom <i class='fas fa-sort-alpha-down'></i></th>";
		}
		else
		{
			echo "<th class='clicable' onclick='location.href=\"index.php?page=rateries&order=nom&num_page=".$num_page."\";'>Nom</th>";
		}
		
		echo "
						<th>Proprio</th>
						<th>MAP</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>";
		
		if(isset($rateries->error))
		{
			echo "<tr><td colspan='5'>".$rateries->error."</td></tr>";
		}
		else
		{
			foreach($rateries as $raterie)
			{
				$pseudo = "";
				if($raterie->on_map == 1)
				{
					$on_map = "<div data-id='".$raterie->id_raterie."' class='btn btn-success raterie-map-hide'><i class='fa fa-crosshairs'></i></div>";
				}
				else
				{
					$on_map = "<div data-id='".$raterie->id_raterie."' class='btn btn-lord raterie-map-show'><i class='fa fa-crosshairs'></i></div>";
				}
				
				if($raterie->id_membre == 0)
				{
					$pseudo = "Système";
				}
				else
				{
					$user = $lordrat->getUtilisateur("full", array("id" => $raterie->id_membre))->response->datas;

					if(is_array($user))
					{
						$pseudo = $user[0]->pseudo;
					}
				}

				echo " 
				<tr>
					<td>".$raterie->affixe."</td>
					<td>".$raterie->nom."</td>
					<td>".$pseudo."</td>
					<td>".$on_map."</td>
					<td>
						<!--<div id='raterie-edit-btn-".$raterie->id_raterie."' data-id='".$raterie->id_raterie."' class='btn btn-lord btn-xs open-pop-up open-pop-up-md raterie-edit-btn'><i class='fa fa-pencil-square-o'></i></div>-->
					</td>
				</tr>";
			}
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
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=1\";'><i class='fa fa-angle-double-left'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".($num_page - 1)."\";'><i class='fa fa-angle-left'></i></div>";
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
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = 1 ; $i < 3 ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
			
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($num_page - 3) ; $i < ($num_page - 1) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Affichage page courante
		echo "<div class='btn btn-lord active'>".$num_page."</div>";
		
		if($num_page > ($nb_pages - 7))
		{
			for($i = ($num_page + 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		else
		{
			for($i = ($num_page + 1) ; $i < ($num_page + 3) ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		
			echo "<div class='btn btn-lord disabled'>...</div>";
			
			for($i = ($nb_pages - 1) ; $i <= $nb_pages ; $i++)
			{
				echo "<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$i."\";'>".$i."</div>";
			}
		}
		
		// Bouton retour page suivante et dernière page
		if($num_page < $nb_pages)
		{
			echo "
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".($num_page + 1)."\";'><i class='fa fa-angle-right'></i></div>
			<div class='btn btn-lord' onclick='location.href=\"index.php?page=rateries&order=".$order."&num_page=".$nb_pages."\";'><i class='fa fa-angle-double-right'></i></div>";
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

