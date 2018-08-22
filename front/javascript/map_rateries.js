// Chargement de la map
$(function() {
	var latitude_init = 47;
	var longitude_init = 2.5;
	var zoom_init = 6;

	//$("#rateriesmap").append("Coucou");

	//var rateriesmap = new google.maps.Map(document.getElementById('rateriesmap'), {
	var rateriesmap = new google.maps.Map($("#rateriesmap")[0], {
		zoom: zoom_init,
		center: {lat: latitude_init, lng: longitude_init},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	var marker;
	
	var infowindow = new google.maps.InfoWindow();
	
	$.ajax({
		url:"https://api.larchiviste.fr/rateries/map",
		type:"post",
		data:{
			app:"NhNWKfsvPJG09wlhT62o",
			key:"a9e73XeL42Y97z4KBGwXJegHA6aLz7WKgaRk866c85mgEq1f6x"
		},
		success:function(retour){
			pois = retour.response.datas;
			
			pois.forEach(function(poi){
				// Ajout du pointeur sur la carte
				marker = new google.maps.Marker({
					position: {lat: poi.lat, lng: poi.lng},
					map: rateriesmap,
					icon: 'img/ressources/markers/maker.png'
				});
				// Ajout de l'infobulle du pointeur
				google.maps.event.addListener(marker, 'click', (function(marker) {
					return function() {
						if(poi.url != null)
						{
							var site_web = "<br /><a href='"+poi.url+"' target='_blank'>Site Web de la Raterie</href>";
						}
						else
						{
							var site_web = "";
						}
						
						var fiche_raterie = "<a href='index.php?page=fiche&raterie="+poi.affixe+"' target='_blank'>Fiche de la raterie</a>";
						
						infowindow.setContent("\
							"+poi.affixe+" "+poi.nom+"<br />\n\
							"+fiche_raterie+"\n\
							"+site_web+"");
						infowindow.open(rateriesmap, marker);
					};
				})(marker));
			});
			//var pois = JSON.parse(retour);
			/*pois.forEach(function(poi){
				// Ajout du pointeur sur la carte
				marker = new google.maps.Marker({
					position: {lat: poi.lat, lng: poi.lng},
					map: rateriesmap,
					icon: 'img/ressources/markers/maker.png'
				});
				// Ajout de l'infobulle du pointeur
				google.maps.event.addListener(marker, 'click', (function(marker) {
					return function() {
						infowindow.setContent("\
							Affixe : "+poi.affixe+"<br />\n\
							Nom : "+poi.nom+"\n\
							Ville : "+poi.ville+"<br />\n");
						infowindow.open(rateriesmap, marker);
					}
				})(marker));
			});*/
		},
		error:function(){
			console.log("AJAX Error");
		}
	});
});