<?php
switch($section)
{
	case "articles":
		echo "
		<h3>Gestion des articles</h3>
		<div class='text-center'><div id='article-add-btn' class='btn btn-lord open-pop-up open-pop-up-fs'>Ajouter un Article</div></div>
		<p style='text-align:center;'>Merci de choisir un article dans la liste ci dessous.</p> 
		<div class='table-responsive'>
			<table class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Titre</th>
						<th>Section</th>
						<th>Auteur</th>
						<th>Date création</th>
						<th>Date Publication</th>
						<th>Dernière édition</th>
						<th>Nombre de vues</th>
						<th style='width:120px;'>Actions</th>
					</tr>
				</thead>
				<tbody>";
		
		$req = $db_v2->query("
		SELECT a.id id, a.titre titre, a.date_ajout date_ajout, a.date_publication date_publication, a.last_edit last_edit, a.nbr_vues nbr_vues, s.nom section, u.pseudo, a.system system
		FROM `articles` a
		LEFT JOIN `sections` s ON a.section = s.id
		LEFT JOIN `users` u ON u.id_membre = a.auteur
		ORDER BY a.section,a.ordre");
		
		if($req->rowCount())
		{
			while($donnees = $req->fetch())
			{
				echo "
				<tr>
					<td>".$donnees['titre']."</td>
					<td>".ucfirst($donnees['section'])."</td>
					<td>".$donnees['pseudo']."</td>
					<td>".date('d-m-Y à H:i',$donnees['date_ajout'])."</td>
					<td>".date('d-m-Y à H:i',$donnees['date_publication'])."</td>
					<td>".date('d-m-Y à H:i',$donnees['last_edit'])."</td>
					<td>".$donnees['nbr_vues']."</td>
					<td>
						<div id='article-show-btn-".$donnees['id']."' class='btn btn-lord article-show-btn open-pop-up open-pop-up-fs' data-id='".$donnees['id']."'><i class='fa fa-search' aria-hidden='true'></i></div>
						<div id='article-edit-btn-".$donnees['id']."' class='btn btn-lord article-edit-btn open-pop-up open-pop-up-fs' data-id='".$donnees['id']."'><i class='fa fa-edit' aria-hidden='true'></i></div> ";
				
				// On vérouille le bouton de suppression s'il s'agit d'une page système
				if($donnees['system'])
				{
					if(isset($_SESSION['level']) && $_SESSION['level'] == 'admin')
					{
						echo "<div id='article-del-btn-".$donnees['id']."' class='btn btn-lord article-del-btn open-pop-up open-pop-up-fs' data-id='".$donnees['id']."'><i class='fa fa-trash' aria-hidden='true'></i></div>";
					}
					else
					{
						echo "<div class='btn btn-lord disabled'><i class='fa fa-trash' aria-hidden='true'></i></div>";
					}
				}
				else
				{
					echo "<div id='article-del-btn-".$donnees['id']."' class='btn btn-lord article-del-btn open-pop-up open-pop-up-fs' data-id='".$donnees['id']."'><i class='fa fa-trash' aria-hidden='true'></i></div>";
				}
				
				echo "		
					</td>
				</tr>";
			}
		}
		else
		{
			echo "<tr><td colspan='7'>Aucun article trouvé dans la base de données</td></tr>";
		}
		
		$req->closeCursor();
		
		echo "
				</tbody>
			</table>
		</div>";
		break;
	case "changelog":
		break;
	case "medias":
		echo "
		<h3>Gestion des medias</h3>

		<div class='text-center'><div id='medias-add-btn' class='btn btn-lord open-pop-up open-pop-up-md'>Ajouter</div></div>

		<div class='table-responsive'>
			<table class='table table-bordered table-striped' style='margin-top: 15px;'>
				<thead>
					<tr>
						<th>Fichier</th>
						<th>Auteur</th>
						<th>Utilisé sur</th>
						<th>Date Ajout</th>
						<th>Dernière Edition</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>";
		
		$medias = $lordrat->listMedias()->response->datas;

		if(is_array($medias))
		{
			foreach($medias as $media)
			{
				// Création auto thumbnail si n'existe pas
				if(!file_exists($_SESSION['medias_path']."thumbnail/".$media->fichier))
				{
					if(file_exists($_SESSION['medias_path'].$media->fichier))
					{
						imagethumb($_SESSION['medias_path'].$media->fichier, $_SESSION['medias_path']."thumbnail/".$media->fichier,250);
					}
				}

				// Si echec création thumbnail on charge l'image d'origine
				if(!file_exists($_SESSION['medias_path']."thumbnail/".$media->fichier))
				{
					$image = $front_url."medias/".$media->fichier;
				}
				else
				{
					$image = $front_url."medias/thumbnail/".$media->fichier;
				}

				echo "
				<tr>
					<td><img src='".$image."' alt='".$media->fichier."' style='max-width:250px;'/></td>
					<td>".$media->auteur->pseudo."</td>
					<td>Comming Soon</td>
					<td>".date('d-m-Y à H:i',$media->date_ajout)."</td>
					<td>".date('d-m-Y à H:i',$media->date_edit)."</td>
					<td>
						<div id='medias-del-btn-".$media->id."' class='btn btn-lord medias-del-btn open-pop-up' data-id='".$media->id."'><i class='fa fa-trash' aria-hidden='true'></i></div>
					</td>
				</tr>";
			}
		}
		else
		{
			echo "<tr><td colspan='6'>".$medias->error."</td></tr>";
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
		if(isset($getkeys[2]) && $getkeys[2] == "edit")
		{
			$section = "Get From DB";
			echo "<p style='text-align:center;'>Edition de la page d'accueil de la section ".$section.".</p>";
		}
		else
		{
			echo "
			<p style='text-align:center;'>Vous pouvez ici modifier l'accueil de chaque section du site.</p>
			<div class='table-responsive'>
				<table class='table table-striped table-bordered'>
					<thead>
						<tr>
							<th>Nom</th>
							<th>Titre</th>
							<th>Description</th>
							<th style='width:120px;'>Action</th>
						</tr>
					</thead>
					<tbody>";
			
			$req = $db_v2->query("SELECT * FROM `sections` ORDER BY `nom`");
			
			if($req->rowCount())
			{
				while($donnees = $req->fetch())
				{
					echo "
					<tr>
						<td>".ucfirst($donnees['nom'])."</td>
						<td>".$donnees['titre']."</td>
						<td>".$donnees['desc']."</td>
						<td>
							<div id='section-show-btn-".$donnees['id']."' class='btn btn-lord section-show-btn open-pop-up open-pop-up-fs' data-id='".$donnees['id']."'><i class='fa fa-search' aria-hidden='true'></i></div>
							<div id='section-edit-btn-".$donnees['id']."' class='btn btn-lord section-edit-btn open-pop-up open-pop-up-fs' data-id='".$donnees['id']."'><i class='fa fa-edit' aria-hidden='true'></i></div>
						</td>
					</tr>";
				}
			}
			else
			{
				echo "<tr><td colspan='3'>Aucun contenu trouvé dans la base de données. Merci de contacter un Administrateur</td></tr>";
			}
			
			$req->closeCursor();
			
			echo "
					</tbody>
				</table>
			</div>";
		}
		break;
	case "suggestions":
		break;
}
