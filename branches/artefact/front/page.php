<!DOCTYPE html>
<html lang="fr">
    <head>
		<title>Lord Rat</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" media="screen" type="text/css" title="Design" href="design/general.css" />
		<link rel='shortcut icon' type='image/x-icon' href='design/favicon.ico'/>
		<!-- Javascript Map Google -->
		<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyARDZm6S7vN1UwIOnjUVoVlLuHs68qDMek&sensor=false"></script>
		<!-- Appel jquery -->
		<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script src="https://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
		<script type="text/javascript" src="javascript/map_rateries.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    </head>
    <body>
		<?php
			include("menu.php");
			
			echo "<div id='corps'>";
			
			if(isset($datas_page['titre']))
			{
				echo "
				<h1>".$datas_page['titre']."</h1>
				<div class='art'>
					<p>".$datas_page['contenu']."</p>
					<p>".$datas_page['special']."</p>
				</div>";
			}
			else
			{
				echo "
				<h1>Page introuvable</h1>
				<div class='art'><p style='text-align:center;'>Vous n'avez pas l'autorisation d'afficher cette page ou elle n'existe pas</p></div>";
			}
			
			echo "</div>";
			
			include("pied.php");
		?>
    </body>
</html>