<?php

include('co_db.php');

include('functions.php');

$req = $bdd->query("SELECT type FROM mails ORDER BY type");

while($donnees = $req->fetch())
{
	echo send_mail($donnees['type'],'kerwyn@thehiddendungeon.com','Kerwyn Raczaron','test')."<br />";
}

$req->closeCursor();
