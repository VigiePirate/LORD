<?php

if($index)
{
	$datas_page['contenu'] .= "
	<form method='post' action='#' style='width:100%;margin-top:25px;'>
		<table style='width:500px;margin:auto;'>
			<tr>
				<td style='width:35%;'>
					<label for='email'>Adresse Mail : </label>
				</td>
				<td>
					<input type='text' name='email' id='email' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td>
					<label for='password'>Mot de passe : </label>
				</td>
				<td>
					<input type='password' name='password' id='password' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type='button' onclick='alert(\"Ce formulaire est actuellement désactivé\");' value='Connexion' />
				</td>
			</tr>
		</table>
	</form>";
}
else
{
	http_response_code(404);
	include("/var/www/lord-rat.org/front/public-html/error.php");
	die();
}

