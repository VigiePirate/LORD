// Chargement du selecteur de date de manière dynamique
$("body").on('focus','.dynamic_datepicker',function(){
	$(this).datepicker({
		changeMonth:true,
		changeYear:true
	});
	// Définition en français
	$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
});

// Chargement du selecteur de date et heure de manière dynamique
$("body").on('focus','.dynamic_datetimepicker',function(){
	$(this).datetimepicker({
		changeMonth:true,
		changeYear:true
	});
	// Définition en français
	$.datepicker.setDefaults( $.datepicker.regional[ "fr" ] );
});