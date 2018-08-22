<?php

$stats = $lordrat->getStats("base");

$contenu =  "
<h3 style='width:100%;background-color:#6699ff;text-align:center;'>Générales</h3>
<ul>
	<li>Rats référencés : ".$stats->count->rats."</li>
	<li>Membres du site : ".$stats->count->membres."</li>
	<li>Eleveurs : ".$stats->count->rateries."</li>
	<li>Portées enregistrées : ".$stats->count->portees."</li>
</ul>
<h3 style='width:100%;background-color:#6699ff;text-align:center;'>Les Rats</h3>
<ul>
	<li>Mâles : ".$stats->ratio->rats->sexe->M."%</li>
	<li>Femelles : ".$stats->ratio->rats->sexe->F."%</li>
	<li>Age Moyen Dèces Mâles : ".$stats->moyennes->deces->M." Mois</li>
	<li>Age Moyen Dèces Femelles : ".$stats->moyennes->deces->F." Mois</li>
	<li>Age Moyen Dèces Mixtes : ".$stats->moyennes->deces->A." Mois</li>
	<li>Nombre Moyen de petits par portées : ".$stats->moyennes->portees->nb_petits."</li>
</ul>
<h3 style='width:100%;background-color:#6699ff;text-align:center;'>Les 10 Principales Causes de Dèces</h3>
<canvas id='causes-deces' width='700' height='250'></canvas>
<script>
	var canvasCausesDeces = $(\"#causes-deces\");
	var chartCausesDeces = new Chart(canvasCausesDeces, {
		type: 'bar',
		data: ".json_encode($stats->graphs->causes_deces->top10).",
		options: {
			legend:{
				display:false
			},
			scales: {
				xAxes:[{
					display:false
				}],
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
</script>
";

$datas_page = array(
	"titre"		=> "Statistiques",
	"contenu"	=> $contenu,
	"special"	=> ""
);


