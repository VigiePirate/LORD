<?php

if($index)
{
	$datas_page['contenu'] .= "
	<form method='post' action='#' style='width:100%;margin-top:25px;'>
		<table style='width:500px;margin:auto;'>
			<tr>
				<td style='width:35%;'>
					<label for='email'>Adresse Mail* : </label>
				</td>
				<td>
					<input type='text' name='email' id='email' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type='button' onclick='alert(\"Ce formulaire est actuellement désactivé\");' value='Envoyer' />
				</td>
			</tr>
		</table>
	</form>";
}
else
{
	http_response_code(404);
	include("/lamp0/web/lord/front/error.php");
	die();
}

