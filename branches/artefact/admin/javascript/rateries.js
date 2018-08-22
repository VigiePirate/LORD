

$(function(){
	// Masquage d'une raterie sur la map
	$("body").on('click','.raterie-map-hide',function(){
		var btn = $(this);
		var id = btn.data('id');
		console.log("Masquage Raterie "+id);
		btn.removeClass('raterie-map-hide').removeClass('btn-success').addClass('btn-lord').addClass('disabled').children('i').removeClass('fa-crosshairs').addClass('fa-spinner').addClass('fa-pulse');
		$.ajax({
			url:"https://api.larchiviste.fr/rateries/map",
			type:"post",
			data:{
				app:"NhNWKfsvPJG09wlhT62o",
				key:"a9e73XeL42Y97z4KBGwXJegHA6aLz7WKgaRk866c85mgEq1f6x",
				id:id
			},
			success:function(retour){
				if(retour.response.datas === "success")
				{
					btn.addClass('raterie-map-show').removeClass('disabled').children('i').removeClass('fa-spinner').removeClass('fa-pulse').addClass('fa-crosshairs');
				}
				else
				{
					console.log("Toggle Failed");
				}
			},
			error:function(){
				console.log("AJAX Failed");
			}
		});
	});
	// Affichage d'une raterie sur la map
	$("body").on('click','.raterie-map-show',function(){
		var btn = $(this);
		var id = btn.data('id');
		console.log("Affichage Raterie "+id);
		btn.removeClass('raterie-map-show').addClass('disabled').children('i').removeClass('fa-crosshairs').addClass('fa-spinner').addClass('fa-pulse');
		$.ajax({
			url:"https://api.larchiviste.fr/rateries/map",
			type:"post",
			data:{
				app:"NhNWKfsvPJG09wlhT62o",
				key:"a9e73XeL42Y97z4KBGwXJegHA6aLz7WKgaRk866c85mgEq1f6x",
				id:id
			},
			success:function(retour){
				if(retour.response.datas === "success")
				{
					btn.addClass('raterie-map-hide').removeClass('disabled').removeClass('btn-lord').addClass('btn-success').children('i').removeClass('fa-spinner').removeClass('fa-pulse').addClass('fa-crosshairs');
				}
				else
				{
					console.log("Toggle Failed");
				}
			},
			error:function(){
				console.log("AJAX Failed");
			}
		});
	});
});

console.log("rateries.js correctement chargé");


