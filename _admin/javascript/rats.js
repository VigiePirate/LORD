// Gestion des rats
$(function(){
	// Ouverture Pop Up SAV d'un rat
	$("body").on('click','.rat-sav-btn',function(){
		var id = $(this).data('id');
		console.log(id);
		$.ajax({
			url:"ajax/rats/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(rat){
				console.log(rat);
				var nom = rat[0].nom_naissance;
				if(rat[0].nom_courant !== "")
				{
					nom = rat[0].nom_courant+" / "+rat[0].nom_naissance
				}
				
				var cause_deces = "";
				
				if(rat[0].date_deces === "0")
				{
					cause_deces = "Vivant";
				}
				else
				{
					cause_deces = "Inconnue";
				}
				
				if(rat[0].cause_deces.nom !== null)
				{
					cause_deces = rat[0].cause_deces.nom.FR;
				}
				
				var savbtn = "";
				
				if(rat[0].etat === "2")
				{
					savbtn = "<div id='rat-sav-valid' class='btn btn-lord' data-id='"+id+"'>Valider cette fiche</div>";
				}
				else
				{
					savbtn = "<div id='rat-sav-unvalid' class='btn btn-lord' data-id='"+id+"'>Renvoyer au SAV cette fiche</div>";
				}
				
				$("#rat-sav-title").empty().append("Visualisation pour SAV fiche Rat "+rat[0].numero+" "+nom);
				$("#rat-sav-content").empty().append("\n\
				<form>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Numero Rat : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].numero+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Nom : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].nom_naissance+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Alias : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled disabled value='"+rat[0].nom_courant+"' />\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Origine : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled disabled value='"+rat[0].raterie.affixe+" "+rat[0].raterie.nom+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Père : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<div class='btn btn-lord btn-block'>"+rat[0].pere.affixe+" "+rat[0].pere.nom_naissance+"'</div>\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Mère : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<div class='btn btn-lord btn-block'>"+rat[0].mere.affixe+" "+rat[0].mere.nom_naissance+"'</div>\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Propriétaire : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].proprio.nom+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Date d'ajout : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].date_ajout+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Dernière Modification : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].date_last_edit+"' />\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Date de Naissance : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].date_naissance+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Date de Dèces : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled disabled value='"+rat[0].date_deces+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Cause de Déces : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled disabled value='"+cause_deces+"' />\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Couleur : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].couleur.nom.FR+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Dilution : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].dilution.nom.FR+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Marquage : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].marquage.nom.FR+"' />\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Oreilles : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].oreilles.nom.FR+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Poils : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].poils.nom.FR+"' />\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							Yeux : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].yeux.nom.FR+"' />\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							Uniques : \n\
						</label>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].uniques[0].nom.FR+"' />\n\
						</div>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].uniques[1].nom.FR+"' />\n\
						</div>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].uniques[2].nom.FR+"' />\n\
						</div>\n\
						<div class='col-sm-2'>\n\
							<input id='' class='form-control' type='text' disabled value='"+rat[0].uniques[3].nom.FR+"' />\n\
						</div>\n\
						<div class='col-sm-2'>\n\
							\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<label class='col-form-label col-sm-2'>\n\
							\n\
						</label>\n\
						<div class='col-sm-2'>\n\
							\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							\n\
						</label>\n\
						<div class='col-sm-2'>\n\
							\n\
						</div>\n\
						<label class='col-form-label col-sm-2'>\n\
							\n\
						</label>\n\
						<div class='col-sm-2'>\n\
							\n\
						</div>\n\
					</div>\n\
					<div class='form-group row'>\n\
						<div class='col-sm-4'>\n\
							<div id='rat-sav-edit' class='btn btn-lord disabled' data-id='"+id+"'>Editer cette fiche</div>\n\
						</div>\n\
						<div class='col-sm-4'>\n\
							"+savbtn+"\n\
						</div>\n\
						<div class='col-sm-4'>\n\
							<div id='ratsav-msg-btn' class='btn btn-lord open-pop-up open-pop-up-lg ratsav-msg-btn' data-id='"+id+"'>Messagerie SAV</div>\n\
						</div>\n\
					</div>\n\
				</form>");
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Activation édition fiche
	
	// Sauvegarde des modification
	
	// Validation d'une fiche
	$("body").on('click','#rat-sav-valid',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/rats/sav/status.php",
			type:"post",
			data:{
				rat:id,
				status:1
			},
			success:function(retour){
				console.log(retour);
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Invalidation d'une fiche
	$("body").on('click','#rat-sav-unvalid',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/rats/sav/status.php",
			type:"post",
			data:{
				rat:id,
				status:0
			},
			success:function(retour){
				console.log(retour);
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Ouverture Pop Up Messagerie
	$("body").on('click','.ratsav-msg-btn',function(){
		var id = $(this).data('id');
		$.ajax({
			url:"ajax/rats/get.php",
			type:"post",
			data:{
				id:id
			},
			success:function(rat){
				var nom = rat[0].nom_naissance;
				if(rat[0].nom_courant !== "")
				{
					nom = rat[0].nom_courant+" / "+rat[0].nom_naissance;
				}
				
				$(document).ready(function(){
					
					$("#ratsav-msg-title").empty().append("Messagerie SAV pour Rat "+rat[0].numero+" "+nom);
					$("#ratsav-msg-content").empty().append("\
					<form>\n\
						<div id='savmsglist' class='form-group row'>\n\
						</div>\n\
						<div class='form-group row'>\n\
							<div class='col'>\n\
								<div id='ratsav-msg-message' class='form-control custom-textarea' contenteditable></div>\n\
							</div>\n\
						</div>\n\
						<div class='form-group row'>\n\
							<div class='col'>\n\
								<div id='ratsav-msg-send' class='btn btn-lord' data-id='"+id+"'>Envoyer Message</div>\n\
							</div>\n\
						</div>\n\
					</form>");
					$(document).ready(function(){
						// Réccupération des messages 
						$.ajax({
							url:"ajax/rats/sav/msg/list.php",
							type:"post",
							data:{
								rat:id
							},
							success:function(messages){
								var msgcount = 0;
						
								var savv1 = "";

								var message_formated = "";

								// Chargement des messages
								if(messages.error === undefined){
									messages.forEach(function(message){
										console.log(message);
										message_formated += "\n\
										<div class='col-lg-12'>\n\
											<div class='form-control'>\n\
												<strong>Message envoyé le "+message.date_sent.string+" par "+message.user.pseudo+"</strong><br />"+message.message+"\n\
											</div>\n\
										</div>";
										msgcount++;
									});
									$("#savmsglist").append(message_formated);
								}

								// Chargement des messages présents dans la V1 du LORD
								if(rat[0].sav_check.html !== "")
								{
									savv1 = "<strong>SAV V1</strong><br />"+rat[0].sav_check.html;

									$("#savmsglist").append("\
									<div class='col-lg-12'>\n\
										<div class='form-control'>"+savv1+"</div>\n\
									</div>");

									msgcount++;
								}

								if(msgcount === 0)
								{
									$("#savmsglist").append("\
									<div class='col-lg-12'>\n\
										<h3>Cette conversation ne contient actuellement aucun message</h3>\n\
									</div>");
								}
							},
							error:function(){
								console.log("AJAX Error");
							}
						});
					});
				});
			},
			error:function(){
				console.log("AJAX Error");
			}
		});
	});
	// Envoi d'un message SAV Rat
	$("body").on('click','#ratsav-msg-send',function(){
		$("#box-result").showBoxResult();
		var id = $(this).data('id');
		var regex = /<br\s*[\/]?>/gi;
		var message = $("#ratsav-msg-message").html();
		$.ajax({
			url:"ajax/rats/sav/msg/add.php",
			type:"post",
			data:{
				rat:id,
				message:message.replace(regex,'\n')
			},
			success:function(retour){
				$("#box-result").updateBoxResult({retour:retour});
				console.log(retour);
			},
			error:function(){
				$("#box-result").updateBoxResult({retour:"failed"});
				console.log("AJAX Error");
			}
		});
	});
});

console.log("Chargement rats.js terminé");
