// Création menu déroulant pour les sections
var select_section;

$(function(){
	$.ajax({
		url:"ajax/gsite/sections/list.php",
		success:function(retour){
			console.log(retour);
			select_section = "<select id='article-section' class='form-control'>";
			var sections = JSON.parse(retour);
			sections.forEach(function(section){
				select_section += "<option value='"+section.id+"'>"+section.nom.ucfirst()+"</option>";
			});
			select_section += "</select>";
		},
		error:function(){
			console.log("Impossible de charger la liste des sections");
		}
	});
});

// Gestion des sections
$(function(){
	// Ouverture Pop Up visu de la section
	$("body").on('click','.section-show-btn',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/gsite/sections/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(retour){
				console.log(retour);
				var section = JSON.parse(retour);
				$('document').ready(function(){
					$("#section-show-title").empty().append("Apperçu de "+section.titre);
					$("#section-show-content").empty().append("<div class='text-left'>"+section.contenu+"</div>");
				});
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Ouverture Pop Up édition section
	$("body").on('click','.section-edit-btn',function(){
		var id = $(this).data('id');
		console.log(id);
		$.ajax({
			url:"ajax/gsite/sections/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(retour){
				console.log(retour);
				var section = JSON.parse(retour);
				$('document').ready(function(){
					$("#section-edit-title").empty().append("Apperçu de "+section.titre);
					$("#section-edit-content").empty().append("\
					<form class='form-horizontal'>\n\
						<div class='form-group'>\n\
							<label class='control-label col-md-1 col-sm-2' for='section-titre'>Titre:</label>\n\
							<div class='col-md-11 col-sm-10'>\n\
								<input type='text' class='form-control' id='section-titre' placeholder='Titre'>\n\
							</div>\n\
						</div>\n\
						<div class='form-group'>\n\
							<label class='control-label col-md-1 col-sm-2' for='section-desc'>Description:</label>\n\
							<div class='col-md-11 col-sm-10'>\n\
								<input type='text' class='form-control' id='section-desc' placeholder='Description de la Section'>\n\
							</div>\n\
						</div>\n\
						<div class='form-group'>\n\
							<label class='control-label col-md-1 col-sm-2' for='section-contenu'>Contenu:</label>\n\
							<div class='col-md-11 col-sm-10'>\n\
								<div id='section-contenu' class='form-control k-area' contentEditable></div>\n\
							</div>\n\
						</div>\n\
						<div class='form-group'>\n\
							<div class='text-center'>\n\
								<div id='section-edit-submit' class='btn btn-lord'>Sauvegarder</button>\n\
							</div>\n\
						</div>\n\
					</form>");
					$("#section-titre").val(section.titre);
					$("#section-desc").val(section.desc);
					$("#section-contenu").append(section.contenu);
					$("#section-edit-submit").data('id',section.id);
					kEditorInit();
				});
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Sauvegarde des modifications
	$("body").on('click','#section-edit-submit',function(){
		$("#box-result").showBoxResult();
		var id		= $(this).data('id');
		var titre	= $("#section-titre").val();
		var desc	= $("#section-desc").val();
		var contenu	= $("#section-contenu").html();
		$("document").ready(function(){
			$.ajax({
				url:"ajax/gsite/sections/save.php",
				type:"post",
				data:{
					id:id,
					titre:titre,
					desc:desc,
					contenu:contenu
				},
				success:function(retour){
					console.log(retour);
					$("#box-result").updateBoxResult({retour:retour});
				},
				error:function(){
					console.log("AJAX Error");
					$("#box-result").updateBoxResult({retour:"failed"});
				}
			})
		});
	});
});

// Gestion des articles
$(function(){
	// Pop Up d'ajout d'article
	$("body").on('click','#article-add-btn',function(){
		$("document").ready(function(){
			$("#article-add-title").empty().append("Ajout d'un article");
			$("#article-add-content").empty().append("\n\
			<form class='form form-horizontal'>\n\
				<div class='form-group'>\n\
					<label class='control-label col-sm-2' for='article-titre'>Titre : </label>\n\
					<div class='col-sm-4'>\n\
						<input type='text' id='article-titre' class='form-control' />\n\
					</div>\n\
					<label class='control-label col-sm-2' for='article-section'>Section : </label>\n\
					<div class='col-sm-4'>\n\
						"+select_section+"\n\
					</div>\n\
				</div>\n\
				<div class='form-group'>\n\
					<label class='control-label col-sm-2' for='article-desc'>Description</label>\n\
					<div class='col-sm-10'>\n\
						<input type='text' class='form-control' id='article-desc' />\n\
					</div>\n\
				</div>\n\
				<div class='form-group'>\n\
					<label class='control-label col-sm-2' for='article-contenu'>Contenu:</label>\n\
					<div class='col-sm-10'>\n\
						<div id='article-contenu' class='form-control k-area' contentEditable></div>\n\
					</div>\n\
				</div>\n\
				<div class='form-group'>\n\
					Options avancées, merci de laisser par défaut si vous avez un doute de leurs fonctions\n\
				</div>\n\
				<div class='form-group'>\n\
					<label class='control-label col-sm-2' for='article-publie'>Publié : </label>\n\
					<div class='col-sm-1'>\n\
						<select class='form-control' id='article-publie'>\n\
							<option value='1'>Oui</option>\n\
							<option value='0'>Non</option>\n\
						</select>\n\
					</div>\n\
					<label class='control-label col-sm-2' for='article-date'>Date de publication : </label>\n\
					<div class='col-sm-2'>\n\
						<input type='text' id='article-date' class='dynamic_datetimepicker form-control' placeholder='Par défaut la date de création'/>\n\
					</div>\n\
					<label class='control-label col-sm-1' for='article-system'>Système : </label>\n\
					<div class='col-sm-1'>\n\
						<select class='form-control' id='article-system'>\n\
							<option value='0'>Non</option>\n\
							<option value='1'>Oui</option>\n\
						</select>\n\
					</div>\n\
					<label class='control-label col-sm-1' for='article-nom'>Chemin : </label>\n\
					<div class='col-sm-2'>\n\
						<input type='text' class='form-control' id='article-nom' placeholder='Personaliser url'/>\n\
					</div>\n\
				</div>\n\
				<div class='form-group'>\n\
					<label class='control-label col-sm-2' for='article-special'>Code Spécial : </label>\n\
					<div class='col-sm-10'>\n\
						<textarea row='10' id='article-special' class='form-control'></textarea>\n\
					</div>\n\
				</div>\n\
				<div class='form-group'>\n\
					<div class='text-center'>\n\
						<div id='article-add-submit' class='btn btn-lord'>Ajout</button>\n\
					</div>\n\
				</div>\n\
			</form>");
			kEditorInit();
		});
	});
	// Sauvegarde de l'article
	$("body").on('click','#article-add-submit',function(){
		$("#box-result").showBoxResult();
		$.ajax({
			url:"ajax/gsite/articles/add.php", 
			type:"post",
			data:{
				titre:		$("#article-titre").val(),
				section:	$("#article-section").val(),
				desc:		$("#article-desc").val(),
				contenu:	$("#article-contenu").html(),
				publie:		$("#article-publie").val(),
				date:		$("#article-date").val(),
				system:		$("#article-system").val(),
				nom:		$("#article-nom").val(),
				special:	$("#article-special").html()
			},
			success:function(retour){
				console.log(retour);
				$("#box-result").updateBoxResult({retour:retour});
			},
			error:function(){
				$("#box-result").updateBoxResult({retour:"failed"});
				console.log("AJAX Error");
			}
		});
	});
	// Pop Up de visu
	$("body").on('click','.article-show-btn',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/gsite/articles/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(retour){
				console.log(retour);
				var article = JSON.parse(retour);
				$("#article-show-title").empty().append("Prévisualisation de \""+article.titre+"\"");
				$("#article-show-content").empty().append("<p class='text-left'>"+article.contenu+"</p>");
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Pop Up d'édition d'article
	$("body").on('click','.article-edit-btn',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/gsite/articles/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(retour){
				console.log(retour);
				var article = JSON.parse(retour);
				$("#article-edit-title").empty().append("Edition Article "+article.titre);
				$("#article-edit-content").empty().append("\n\
				<form class='form form-horizontal'>\n\
					<div class='form-group'>\n\
						<label class='control-label col-sm-2' for='article-titre'>Titre : </label>\n\
						<div class='col-sm-4'>\n\
							<input type='text' id='article-titre' class='form-control' />\n\
						</div>\n\
						<label class='control-label col-sm-2' for='article-section'>Section : </label>\n\
						<div class='col-sm-4'>\n\
							"+select_section+"\n\
						</div>\n\
					</div>\n\
					<div class='form-group'>\n\
						<label class='control-label col-sm-2' for='article-desc'>Description</label>\n\
						<div class='col-sm-10'>\n\
							<input type='text' class='form-control' id='article-desc' />\n\
						</div>\n\
					</div>\n\
					<div class='form-group'>\n\
						<label class='control-label col-sm-2' for='article-contenu'>Contenu:</label>\n\
						<div class='col-sm-10'>\n\
							<div id='article-contenu' class='form-control k-area' contentEditable></div>\n\
						</div>\n\
					</div>\n\
					<div class='form-group'>\n\
						Options avancées, merci de laisser par défaut si vous avez un doute de leurs fonctions\n\
					</div>\n\
					<div class='form-group'>\n\
						<label class='control-label col-sm-2' for='article-publie'>Publié : </label>\n\
						<div class='col-sm-1'>\n\
							<select class='form-control' id='article-publie'>\n\
								<option value='1'>Oui</option>\n\
								<option value='0'>Non</option>\n\
							</select>\n\
						</div>\n\
						<label class='control-label col-sm-2' for='article-date'>Date de publication : </label>\n\
						<div class='col-sm-2'>\n\
							<input type='text' id='article-date' class='dynamic_datetimepicker form-control'/>\n\
						</div>\n\
						<label class='control-label col-sm-1' for='article-system'>Système : </label>\n\
						<div class='col-sm-1'>\n\
							<select class='form-control' id='article-system'>\n\
								<option value='0'>Non</option>\n\
								<option value='1'>Oui</option>\n\
							</select>\n\
						</div>\n\
						<label class='control-label col-sm-1' for='article-nom'>Chemin : </label>\n\
						<div class='col-sm-2'>\n\
							<span class='form-control' id='article-nom'></span><!--<input type='text' class='form-control' id='article-nom' placeholder='Personaliser url'/>-->\n\
						</div>\n\
					</div>\n\
					<div class='form-group'>\n\
						<label class='control-label col-sm-2' for='article-special'>Code Spécial : </label>\n\
						<div class='col-sm-10'>\n\
							<textarea row='10' id='article-special' class='form-control'></textarea>\n\
						</div>\n\
					</div>\n\
					<div class='form-group'>\n\
						<div class='text-center'>\n\
							<div id='article-edit-submit' class='btn btn-lord'>Sauvegarde</button>\n\
						</div>\n\
					</div>\n\
				</form>");
				$("#article-titre").val(article.titre);
				$("#article-section").val(article.section.id);
				$("#article-desc").val(article.desc);
				$("#article-contenu").append(article.contenu);
				$("#article-publie").val(article.publie);
				$("#article-date").val(article.date_publication);
				$("#article-system").val(article.system);
				$("#article-nom").append(article.nom);
				$("#article-special").val(article.special);
				$("#article-edit-submit").data('id',article.id);
				kEditorInit();
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Sauvegarde des modifications
	$("body").on('click','#article-edit-submit',function(){
		$("#box-result").showBoxResult();
		$.ajax({
			url:"ajax/gsite/articles/save.php",
			type:"post",
			data:{
				id:			$(this).data('id'),
				titre:		$("#article-titre").val(),
				section:	$("#article-section").val(),
				desc:		$("#article-desc").val(),
				contenu:	$("#article-contenu").html(),
				publie:		$("#article-publie").val(),
				date:		$("#article-date").val(),
				system:		$("#article-system").val(),
				special:	$("#article-special").html()
			},
			success:function(retour){
				console.log(retour);
				$("#box-result").updateBoxResult({retour:retour});
			},
			error:function(){
				$("#box-result").updateBoxResult({retour:"failed"});
				console.log("AJAX Error");
			}
		});
	});
	// Pop Up Suppression Article
	$("body").on('click','.article-del-btn',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/gsite/articles/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(retour){
				console.log(retour);
				var article = JSON.parse(retour);
				$("document").ready(function(){
					$("#article-del-title").empty().append("Suppression Article "+article.titre);
					$("#article-del-content").empty().append("\
					Etes vous sur de vouloir supprimer l'article "+article.titre+" présent dans la section "+article.section.nom+" ?\n\
					<div id='article-del-submit' class='btn btn-lord' data-id="+id+">Oui supprimer cet article</div>\n\
					");
				});
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Suppression
	$("body").on('click','#article-del-submit',function(){
		$("#box-result").showBoxResult();
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/gsite/articles/del.php",
			type:"post",
			data:{
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
	// Monter article dans la liste
	
	// Descendre article dans la liste
	
	// Trier les artcles par ordre alphabétique
	
});
