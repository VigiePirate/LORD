<?php

if(!empty(filter_input(INPUT_GET,"order",FILTER_SANITIZE_STRING)))
{
	$order = filter_input(INPUT_GET,"order",FILTER_SANITIZE_STRING);
}
else
{
	$order = "nom";
}

$num_page = 0;

switch($section)
{
	case "causesdeces":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des causes de dèces</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "couleurs":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des couleurs</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "dilutions":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des dilutions</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "marquages":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des marquages</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "pbsantes":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des problèmes de santés</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "poils":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des types de poils</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "oreilles":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des types d'oreilles</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "uniques":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des particularité uniques</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	case "yeux":
		echo "<div class='row'><div class='col'><h3>Affichage de la liste des types d'yeux</h3></div></div>";

		$criteres = $lordrat->listCriteres($section,$order,"list",NULL,NULL)->response->datas;
		break;
	default:
		echo "<div class='row'><div class='col'><h3>Ce critère n'est pas connu, merci de vous rapprocher d'un administrateur</h3>";
		
		$criteres = NULL;
		break;
}

// Critère est valide
if(!is_null($criteres))
{
	echo "
	<div class='row'>
		<div class='col'>
			<div class='text-center' style='margin-bottom:8px;'>
				<div id='critere-add-".$section."' class='btn btn-lord critere-add-btn open-pop-up open-pop-up-md' data-critere='".$section."'>Ajouter</div>
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='col'>
			<div class='table-responsive'>
				<table class='table table-striped table-bordered table-sm'>
					<thead>
						<tr>";

	if($order == "nom")
	{
		echo "<th class='clicable' onclick='location.href=\"index.php?page=criteres&section=".$section."&order=!nom&num_page=".$num_page."\";'>Nom <i class='fas fa-sort-alpha-down'></i></th>";
	}
	else if($order == "!nom")
	{
		echo "<th class='clicable' onclick='location.href=\"index.php?page=criteres&section=".$section."&order=nom&num_page=".$num_page."\";'>Nom <i class='fas fa-sort-alpha-up'></i></th>";
	}
	else
	{
		echo "<th class='clicable' onclick='location.href=\"index.php?page=criteres&section=".$section."&order=nom&num_page=".$num_page."\";'>Nom</th>";
	}

	echo "
					<th>Rats</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>";

	if(is_array($criteres))
	{
		foreach($criteres as $crit)
		{
			echo "
			<tr>
				<td>".$crit->nom->FR."</td>
				<td>".$crit->count."</td>
				<td>
					<div id='critere-edit-btn-".$section."-".$crit->id."' class='btn btn-sm btn-lord critere-edit-btn open-pop-up open-pop-up-md' data-language='FR' data-critere='".$section."' data-id='".$crit->id."'><i class='fas fa-edit' aria-hidden='true'></i></div>";
			
			if($crit->count != 0)
			{
				echo "<div id='critere-group-btn-".$section."-".$crit->id."' class='btn btn-sm btn-lord critere-group-btn open-pop-up open-pop-up-md' data-language='FR' data-critere='".$section."' data-id='".$crit->id."'><i class='far fa-object-group' aria-hidden='true'></i></div>";
			}
			else
			{
				echo "<div id='critere-delete-btn-".$section."-".$crit->id."' class='btn btn-sm btn-lord critere-delete-btn open-pop-up open-pop-up-sm' data-language='FR' data-critere='".$section."' data-id='".$crit->id."'><i class='fas fa-trash-alt' aria-hidden='true'></i></div>";
			}
			
			echo "
				</td>
			</tr>";
		}
	}
	else
	{
		echo "<tr><td colspan='3'>".$criteres->error."</td></tr>";
	}

	echo "
					</tbody>
				</table>
			</div>
		</div>
	</div>";
}
