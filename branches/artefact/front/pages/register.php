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
				<td style='width:35%;'>
					<label for='email_confirm'>Confirmer Email* : </label>
				</td>
				<td>
					<input type='text' name='email_confirm' id='email_confirm' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='pseudo'>Pseudo* : </label>
				</td>
				<td>
					<input type='text' name='pseudo' id='pseudo' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='prenom'>Prénom : </label>
				</td>
				<td>
					<input type='text' name='prenom' id='prenom' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='nom'>Nom : </label>
				</td>
				<td>
					<input type='text' name='nom' id='nom' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='nom'>Date de naissance : </label>
				</td>
				<td>
					<input type='text' name='nom' id='nom' value='' style='width:100%;' placeholder='JJ/MM/AAAA'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='pays'>Pays* : </label>
				</td>
				<td>
					<input type='text' name='pays' id='pays' value='France' style='width:100%;' placeholder=''/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='cp'>Code Postal* : </label>
				</td>
				<td>
					<input type='text' name='cp' id='cp' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='ville'>Ville* : </label>
				</td>
				<td>
					<input type='text' name='ville' id='ville' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='password'>Mot de passe : </label>
				</td>
				<td>
					<input type='password' name='password' id='password' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td style='width:35%;'>
					<label for='password_confirm'>Confirmer mot de passe : </label>
				</td>
				<td>
					<input type='password' name='password_confirm' id='password_confirm' value='' style='width:100%;'/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type='button' onclick='alert(\"Ce formulaire est actuellement désactivé\");' value='S&#039;inscrire' />
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

