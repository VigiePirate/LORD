<?php

function kcode_to_html($kcode)
{
	$entree = array(
	'#&lt;bold&gt;(.*)&lt;/bold&gt;#Usi',
	'#&lt;italic&gt;(.*)&lt;/italic&gt;#Usi',
	'#&lt;underline&gt;(.*)&lt;/underline&gt;#Usi',
	'#&lt;delete&gt;(.*)&lt;/delete&gt;#Usi',
	'#&lt;left&gt;(.*)&lt;/left&gt;#Usi',
	'#&lt;center&gt;(.*)&lt;/center&gt;#Usi',
	'#&lt;right&gt;(.*)&lt;/right&gt;#Usi',
	'#&lt;taille valeur=&quot;(.*)&quot;&gt;(.*)&lt;/taille&gt;#Usi',
	'#&lt;color valeur=&quot;(.*)&quot;&gt;(.*)&lt;/color&gt;#Usi',
	'#&lt;lien url=&quot;(.*)&quot;&gt;(.*)&lt;/lien&gt;#Usi',
	'#&lt;image url=&quot;(.*)&quot; /&gt;#Usi',
	'#&lt;citation nom=&quot;(.*)&quot;&gt;(.*)&lt;/citation&gt;#Usi');
	
	$sortie = array(
	'<strong>$1</strong>',
	'<em>$1</em>',
	'<span style="text-decoration:underline;">$1</span>',
	'<span style="text-decoration:line-through;">$1</span>',
	'<span style="display:block;text-align:left;">$1</span>',
	'<span style="display:block;text-align:center;">$1</span>',
	'<span style="display:block;text-align:right;">$1</span>',
	'<span style="font-size:$1;">$2</span>',
	'<span style="color:$1">$2</span>',
	'<a href="$1" title="$2">$2</a>',
	'<img src="$1" alt="Image" />',
	'<p>Citation de $1</p><blockquote cite=\'$1\'>$2</blockquote>');
	
	$html = nl2br(htmlentities($kcode));
	
	$count = count($entree) - 1;
	
	for($i=0;$i<=$count;$i++)
	{
		$html = preg_replace($entree[$i],$sortie[$i],$html);
	}
	
	return $html;
}

// Génération des token pour les emails
// Renvoi le token si demande valide sinon renvoi 1
function generate_token($mail,$pseudo,$password)
{
	$token = 1;
	
	if($mail != "" AND $pseudo != "" AND $password != "")
	{
		$token = sha1($mail.$pseudo.$password);
	}
	
	return $token;
}

// Envoi de l'email selon type demandé
// Renvoi 0 si OK
// Renvoi 1 si erreur
function send_mail($type,$mail,$pseudo,$password)
{
	global $bdd;
	
	$req = $bdd->prepare("SELECT subject,text,html FROM mails WHERE type = :type");
	$req->execute(array("type" => $type));
	
	$donnees = $req->fetch();
	
	$flag = 0;
	
	// Gestion des serveurs ne gérants pas bien le retour à la ligne
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn|outlook).[a-z]{2,4}$#", $mail))
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}

	//=====Définition du sujet.
	$sujet = utf8_decode($donnees['subject']);
	//=========
	
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = utf8_decode($donnees['text']);
	$message_html = utf8_decode($donnees['html']);
	//==========

	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========

	//=====Création du header de l'e-mail.
	$header = "From: \"Le LORD\"<webmaster@lord-rat.org>".$passage_ligne;
	$header.= "Reply-to: \"Le LORD\"<webmaster@lord-rat.org>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========

	//=====Création du message.
	$message = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$message.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========

	//=====Envoi de l'e-mail.
	if(!mail($mail,$sujet,$message,$header))
	{
		$flag = 1;
	}
	//==========
	
	return $flag;
}

?>