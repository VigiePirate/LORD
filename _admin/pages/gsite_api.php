<?php

echo "<h3>Gestion du site</h3>";

$getkeys = array_keys($_GET);

switch($getkeys[1])
{
	case "articles":
		echo "
		<!--<div class='text-center'><div id='article-add-btn' class='btn btn-lord open-pop-up'>Ajouter un Article</div></div>-->
		<p style='text-align:center;'>Merci de choisir un article dans la liste ci dessous.</p>
		<div class='table-responsive'>
			<table class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Titre</th>
						<th>Section</th>
						<th>Auteur</th>
						<th>Daté création</th>
						<th>Date Publication</th>
						<th>Dernière édition</th>
						<th>Nombre de vues</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>";
		
		$result = $lordrat->listArticles("section,ordre","list");
		
		print_r($result);
			
		if(count($result->response->datas) == 0)
		{
			echo "<tr><td colspan='8'>Aucun contenu trouvé dans la base de données. Merci de contacter un Administrateur</td></tr>";
		}
		else if(property_exists($result->response->datas,'error'))
		{
			echo "<tr><td colspan='8'>Une erreur s'est produite lors de la recherche (".$result->response->datas->error."). Merci de contacter un Administrateur</td></tr>";
		}
		else
		{
			foreach($result->response->datas as $article)
			{
				echo "
				<tr>
					<td>".$article->titre."</td>
					<td>".ucfirst($article->section->nom)."</td>
					<td>".$article->auteur->pseudo."</td>
					<td>".$article->date_ajout."</td>
					<td>".$article->date_publication."</td>
					<td>".$article->last_edit."</td>
					<td>".$article->nbr_vues."</td>
					<td>
						<!--<div id='article-show-btn-".$article->id."' class='btn btn-lord article-show-btn open-pop-up' data-id='".$article->id."'><i class='fa fa-search' aria-hidden='true'></i></div>
						<div id='article-edit-btn-".$article->id."' class='btn btn-lord article-edit-btn open-pop-up' data-id='".$article->id."'><i class='fa fa-pencil' aria-hidden='true'></i></div> ";
				
				// On vérouille le bouton de suppression s'il s'agit d'une page système
				if($donnees['system'])
				{
					if($_SESSION['level'] == 'admin')
					{
						echo "<div id='article-del-btn-".$article->id."' class='btn btn-lord article-del-btn open-pop-up' data-id='".$article->id."'><i class='fa fa-trash' aria-hidden='true'></i></div>";
					}
					else
					{
						echo "<div class='btn btn-lord disabled'><i class='fa fa-trash' aria-hidden='true'></i></div>";
					}
				}
				else
				{
					echo "<div id='article-del-btn-".$article->id."' class='btn btn-lord article-del-btn open-pop-up' data-id='".$article->id."'><i class='fa fa-trash' aria-hidden='true'></i></div>";
				}
				
				echo "-->	
					</td>
				</tr>";
			}
		}
		
		echo "
				</tbody>
			</table>
		</div>";
		break;
	case "messagerie":
		echo "<p style='text-align:center;'>La messagerie n'est pas active pour le moment.</p>";
		break;
	case "sections":
		echo "
		<p style='text-align:center;'>Vous pouvez ici modifier l'accueil de chaque section du site.</p>
		<div class='table-responsive'>
			<table class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Nom</th>
						<th>Titre</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>";

		$result = $lordrat->listSections("list");

		if(count($result->response->datas) == 0)
		{
			echo "<tr><td colspan='4'>Aucun contenu trouvé dans la base de données. Merci de contacter un Administrateur</td></tr>";
		}
		else
		{
			foreach($result->response->datas as $section)
			{
				echo "
				<tr>
					<td>".ucfirst($section->nom)."</td>
					<td>".$section->titre."</td>
					<td>".$section->desc."</td>
					<td>
						<!--<div id='section-show-btn-".$section->id."' class='btn btn-lord section-show-btn open-pop-up' data-id='".$section->id."'><i class='fa fa-search' aria-hidden='true'></i></div>
						<div id='section-edit-btn-".$section->id."' class='btn btn-lord section-edit-btn open-pop-up' data-id='".$section->id."'><i class='fa fa-pencil' aria-hidden='true'></i></div>-->
					</td>
				</tr>";
			}
		}

		echo "
				</tbody>
			</table>
		</div>";
		break;
}

