// Gestion des critères
$(function(){
	// Ouverture Pop Up ajout critere
	$("body").on('click','.critere-add-btn',function(){
		var critere = $(this).data('critere');
		$(document).ready(function(){
			switch(critere)
			{
				case "causesdeces":
					$("#critere-add-title").empty().append("Ajout d'une Cause de Déces");
					var valid = true;
					break;
				case "couleurs":
					$("#critere-add-title").empty().append("Ajout d'une Couleur");
					var valid = true;
					break;
				case "dilutions":
					$("#critere-add-title").empty().append("Ajout d'une Dilution");
					var valid = true;
					break;
				case "marquages":
					$("#critere-add-title").empty().append("Ajout d'un Marquage");
					var valid = true;
					break;
				case "poils":
					$("#critere-add-title").empty().append("Ajout d'un type de Poils");
					var valid = true;
					break;
				case "pbsantes":
					$("#critere-add-title").empty().append("Ajout d'un Problème de santé");
					var valid = true;
					break;
				case "oreilles":
					$("#critere-add-title").empty().append("Ajout d'un type d'Oreilles");
					var valid = true;
					break;
				case "uniques":
					$("#critere-add-title").empty().append("Ajout d'une caractéristique Unique");
					var valid = true;
					break;
				case "yeux":
					$("#critere-add-title").empty().append("Ajout d'un type d'Yeux");
					var valid = true;
					break;
				default:
					$("#critere-add-title").empty().append("Critère inconnu");
					var valid = false;
					break;
			}
			
			if(valid)
			{
				$("#critere-add-content").empty().append("\n\
				<form>\n\
					<div class='form-group row'>\n\
						<label for='nom' class='col-sm-2 col-form-label'>Nom : </label>\n\
						<div class='col-sm-10'>\n\
							<input type='text' class='form-control' id='critere-nom-FR'>\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<div class='col'>\n\
							<div class='btn btn-lord' data-critere='"+critere+"' id='critere-add-submit'>Ajouter</div>\n\
						</div>\n\
					</div>\n\
				</form>");
			}
			else
			{
				$("#critere-add-content").empty().append("Ce critère n'a pas de formulaire. Merci de rafraichir la page, si le problème persiste merci de contacter un administrateur.");
			}
		});
	});
	// Sauvegarde du nouveau critere
	$("body").on('click','#critere-add-submit',function(){
		$("#box-result").showBoxResult();
		var critere = $(this).data('critere');
		var nom = $("#critere-nom-FR").val();
		console.log(critere+" - "+nom);
		$(document).ready(function(){
			$.ajax({
				url:"ajax/criteres/add.php",
				type:"post",
				data:{
					critere:critere,
					nom:nom
				},
				success:function(retour){
					console.log(retour);
					$("#box-result").updateBoxResult({retour:retour});
				},
				error:function(){
					console.log("AJAX Error");
					$("#box-result").updateBoxResult({retour:"failed"});
				}
			});
		});
	});
	// Ouverture Pop Up edition
	$("body").on('click','.critere-edit-btn',function(){
		var critere = $(this).data('critere');
		var id = $(this).data('id');
		console.log(critere+" - "+id);
		$(document).ready(function(){
			switch(critere)
			{
				case "causesdeces":
					$("#critere-edit-title").empty().append("Edition d'une Cause de Déces");
					var valid = true;
					break;
				case "couleurs":
					$("#critere-edit-title").empty().append("Edition d'une Couleur");
					var valid = true;
					break;
				case "dilutions":
					$("#critere-edit-title").empty().append("Edition d'une Dilution");
					var valid = true;
					break;
				case "marquages":
					$("#critere-edit-title").empty().append("Edition d'un Marquage");
					var valid = true;
					break;
				case "poils":
					$("#critere-edit-title").empty().append("Edition d'un type de Poils");
					var valid = true;
					break;
				case "pbsantes":
					$("#critere-edit-title").empty().append("Edition d'un Problème de santé");
					var valid = true;
					break;
				case "oreilles":
					$("#critere-edit-title").empty().append("Edition d'un type d'Oreilles");
					var valid = true;
					break;
				case "uniques":
					$("#critere-edit-title").empty().append("Edition d'une caractéristique Unique");
					var valid = true;
					break;
				case "yeux":
					$("#critere-edit-title").empty().append("Edition d'un type d'Yeux");
					var valid = true;
					break;
				default:
					$("#critere-edit-title").empty().append("Critère inconnu");
					var valid = false;
					break;
			}
			
			if(valid)
			{
				$.ajax({
					url:"ajax/criteres/get.php",
					type:"post",
					data:{
						critere:critere,
						id:id
					},
					success:function(datas){
						$("#critere-edit-content").empty().append("\n\
						<form>\n\
							<div class='form-group row'>\n\
								<label for='nom' class='col-sm-2 col-form-label'>Nom : </label>\n\
								<div class='col-sm-10'>\n\
									<input type='text' class='form-control' id='critere-nom-FR' value='"+datas[0].nom.FR+"'>\n\
								</div>\n\
							</div>\n\
							<div class='form-group row'>\n\
								<div class='col'>\n\
									<div class='btn btn-lord' data-critere='"+critere+"' data-id='"+id+"' id='critere-edit-submit'>Ajouter</div>\n\
								</div>\n\
							</div>\n\
						</form>");
					},
					error:function(){
						$("#critere-edit-content").empty().append("Echec de la récupération du critère. Merci de rafraichir la page, si le problème persiste merci de contacter un administrateur.");
					}
				});
				
			}
			else
			{
				$("#critere-edit-content").empty().append("Ce critère n'a pas de formulaire. Merci de rafraichir la page, si le problème persiste merci de contacter un administrateur.");
			}
		});
	});
	// Sauvegarde de l'édition
	$("body").on('click','#critere-edit-submit',function(){
		$("#box-result").showBoxResult(); 
		var id		= $(this).data('id');
		var critere	= $(this).data('critere');
		var nom		= $("#critere-nom-FR").val();
		$.ajax({
			url:"ajax/criteres/save.php",
			type:"post",
			data:{
				critere:critere,
				id:id,
				nom:nom
			},
			success:function(retour)
			{
				console.log(retour);
				if(retour === "success")
				{
					$("#box-result").updateBoxResult({retour:retour});
				}
				else
				{
					$("#box-result").updateBoxResult({message:retour.error,type:"info"});
				}
			},
			error:function()
			{
				console.log("AJAX Error");
				$("#box-result").updateBoxResult({retour:"failed"});
			}
		});
	});
	// Ouverture Pop Up de groupement de critères
	$("body").on('click','.critere-group-btn',function(){
		var id = $(this).data('id');
		var critere = $(this).data('critere');
		$(document).ready(function(){
			switch(critere)
			{
				case "causesdeces":
					$("#critere-group-title").empty().append("Fusion de Causes de Déces");
					var valid = true;
					break;
				case "couleurs":
					$("#critere-group-title").empty().append("Fusion de Couleurs");
					var valid = true;
					break;
				case "dilutions":
					$("#critere-group-title").empty().append("Fusion de Dilutions");
					var valid = true;
					break;
				case "marquages":
					$("#critere-group-title").empty().append("Fusion de Marquages");
					var valid = true;
					break;
				case "poils":
					$("#critere-group-title").empty().append("Fusion de types de Poils");
					var valid = true;
					break;
				case "pbsantes":
					$("#critere-group-title").empty().append("Fusion de Problèmes de santé");
					var valid = true;
					break;
				case "oreilles":
					$("#critere-group-title").empty().append("Fusion de type d'Oreilles");
					var valid = true;
					break;
				case "uniques":
					$("#critere-group-title").empty().append("Fusion de caractéristiques Unique");
					var valid = true;
					break;
				case "yeux":
					$("#critere-group-title").empty().append("Fusion de type d'Yeux");
					var valid = true;
					break;
				default:
					$("#critere-group-title").empty().append("Critère inconnu");
					var valid = false;
					break;
			}
			
			if(valid)
			{
				$.ajax({
					url:"ajax/criteres/get.php",
					type:"post",
					data:{
						critere:critere,
						id:id
					},
					success:function(datas){
						console.log(datas);
						$.ajax({
							url:"ajax/criteres/list.php",
							type:"post",
							data:{
								critere:critere
							},
							success:function(criteres){
								$("#critere-group-content").empty().append("\
								<form>\n\
									<div class='form-group row'>\n\
										<div class='col'>\n\
											<p>Vers quel critère voulez vous rattacher les rats ayant le critère \""+datas[0].nom.FR+"\" ? <span style='color:red;font-weight:bold;'>Le critère source sera supprimé</span></p>\n\
										</div>\n\
									</div>\n\
									<div class='form-group'>\n\
										<div class='col'>\n\
											<select id='critere-cible' class='form-control'>\n\
											</select>\n\
										</div>\n\
									</div>\n\
									<div class='form-group'>\n\
										<div class='col'>\n\
											<div id='critere-group-submit' class='btn btn-lord' data-critere='"+critere+"' data-id='"+id+"'>Fusioner</div>\n\
										</div>\n\
									</div>\n\
								</form>\n\
								");
								$(document).ready(function(){
									criteres.forEach(function(crit){
										if(crit.id != id)
										{
											$("#critere-cible").append("<option value='"+crit.id+"'>"+crit.nom.FR+"</option>");
										}
									});
								});
							},
							error:function(){
								console.log("AJAX Error");
								$("#critere-group-content").empty().append("Echec de la réccupération de la liste des critères. Merci de rafraichir la page, si le problème persiste merci de contacter un administrateur.");
							}
						});
					},
					error:function(){
						console.log("AJAX Error");
						$("#critere-group-content").empty().append("Echec de la réccupération des informations du critère. Merci de rafraichir la page, si le problème persiste merci de contacter un administrateur.");
					}
				});
			}
			else
			{
				$("#critere-group-content").empty().append("Ce critère n'a pas de formulaire. Merci de rafraichir la page, si le problème persiste merci de contacter un administrateur.");
			}
		});
		
	});
	// Fusion des critères
	$("body").on('click','#critere-group-submit',function(){
		var critere = $(this).data('critere');
		var source = $(this).data('id');
		var cible = $("#critere-cible").val();
		console.log(critere+" : "+source+" va disparaitre au profit de "+cible);
		$("body").openPopUp('criteres-groupprogress-box',{size:'pop-up-xs',noclose:true,noflag:true});
		$(document).ready(function(){
			$("#criteres-groupprogress-title").empty().append("Etat fusion");
			$("#criteres-groupprogress-content").empty().append("\n\
			<ul class='fa-ul'>\n\
				<li><span class='fa-li' id='fa-groupprogress-1'><i class='fas fa-spinner fa-pulse'></i></span>Migration des rats ayant le critère à supprimer</li>\n\
				<li><span class='fa-li' id='fa-groupprogress-2'><i class='fas fa-square'></i></span>Suppression du critère</li>\n\
			</ul>");
			$.ajax({
				url:"ajax/criteres/move.php",
				type:"post",
				data:{
					critere:critere,
					source:source,
					cible:cible
				},
				success:function(retour){
					console.log(retour);
				},
				error:function(){
					console.log("AJAX Error");
				}
			});
		});
	});
	// Ouverture Pop Up suppression de critere
	$("body").on('click','.critere-delete-btn',function(){
		var critere = $(this).data('critere');
		var id = $(this).data('id');
		console.log(critere+" - "+id);
		$(document).ready(function(){
			$("#critere-delete-title").empty().append("Suppression d'un critère");
			$.ajax({
				url:"ajax/criteres/get.php",
				type:"post",
				data:{
					critere:critere,
					id:id
				},
				success:function(retour){
					$("#critere-delete-content").empty().append("\n\
					<p>\n\
						Merci de confirmer la suppression du critere \""+retour[0].nom.FR+"\"<br />\n\
						<div class='btn btn-lord' data-id='"+id+"' data-critere='"+critere+"' id='critere-delete-submit'>\n\
							Oui\n\
						</div>\n\
						<div class='btn btn-lord close-pop-up'>\n\
							Annuler\n\
						</div>\n\
					</p>");
				},
				error:function(){
					console.log("AJAX Error");
					$("#critere-delete-content").empty().append("Echec de reccupération des infos pour ce critère. Merci de rafraichir la page");
				}
			});
		});
	});
	// Suppression du critère
	$("body").on('click','#critere-delete-submit',function(){
		$("#box-result").showBoxResult();
		var critere = $(this).data('critere');
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/criteres/delete.php",
			type:"post",
			data:{
				critere:critere,
				id:id
			},
			success:function(retour){
				console.log(retour);
				$("#box-result").updateBoxResult({retour:retour});
			},
			error:function(){
				console.log("AJAX Error");
				$("#box-result").updateBoxResult({retour:"failed"});
			}
		});
	});
});

console.log("Fin chargement criteres.js");


