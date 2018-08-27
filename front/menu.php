<?php
	// attribut rajouté à des fin de débuggage
	//@TODO: virer ça
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Récupération des sections
	$req = $bdd->query("
	SELECT sc.id id_section, sc.nom nom_section, sc.description desc_section
	FROM sections_contenus sc
	ORDER BY sc.id");
	
	$sections = $req->fetchAll();
	
	$req->closeCursor();
	
	echo "
	<div id='menu'>
		<ul id='nav'>
			<li><div id='box1'></div>
			<ul id='list1'>";
	
	$req = $bdd->prepare(
		"SELECT * 
		FROM articles a
		INNER JOIN articles_contenus ac ON a.id=ac.id
		WHERE section = :id_section"
	);
	$req->execute(array("id_section" => $sections[0]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['description'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>
			</li>
			<li><a id='box2' href='index.php?page=".$sections[1]['nom_section']."' title='".$sections[1]['desc_section']."'></a>
			<!--<ul id='list2'>";
	
	$req = $bdd->prepare(
		"SELECT * 
		FROM articles a
		INNER JOIN articles_contenus ac ON a.id=ac.id
		WHERE section = :id_section"
	);
	$req->execute(array("id_section" => $sections[1]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['description'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>-->
			</li>
			<li><div id='box3'></div>
			<ul id='list3'>";
	
	$req = $bdd->prepare(
		"SELECT * 
		FROM articles a
		INNER JOIN articles_contenus ac ON a.id=ac.id
		WHERE section = :id_section"
	);
	$req->execute(array("id_section" => $sections[2]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['description'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>
			</li>
			<li><div id='box4'></div>
			<ul id='list4'>";
	
	$req = $bdd->prepare(
		"SELECT * 
		FROM articles a
		INNER JOIN articles_contenus ac ON a.id=ac.id
		WHERE section = :id_section"
	);

	$req->execute(array("id_section" => $sections[3]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['description'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>
			</li>
			<li><a id='box5' href='index.php?page=".$sections[4]['nom_section']."' title='".$sections[4]['desc_section']."'></a>
			</li>
			<li><div id='box6'></div>
			<ul id='list5'>";
	
	$req = $bdd->prepare(
		"SELECT * 
		FROM articles a
		INNER JOIN articles_contenus ac ON a.id=ac.id
		WHERE section = :id_section"
	);

	$req->execute(array("id_section" => $sections[5]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['description'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>
			</li>
			<li><a id='box7' href='index.php?page=".$sections[6]['nom_section']."' title='".$sections[6]['desc_section']."'></a>
			<!--<ul id='list6'>";
	
	$req = $bdd->prepare("SELECT * FROM articles WHERE section = :id_section");
	$req->execute(array("id_section" => $sections[6]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['desc'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>-->
			</li>
			<li><a id='box8' href='index.php?page=".$sections[7]['nom_section']."' title='".$sections[7]['desc_section']."'></a>
			<!--<ul id='list7'>";
	
	$req = $bdd->prepare("SELECT * FROM articles WHERE section = :id_section");
	$req->execute(array("id_section" => $sections[7]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['desc'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>-->
			</li>
			<li><a id='box9' href='index.php?page=".$sections[8]['nom_section']."' title='".$sections[8]['desc_section']."'></a>
			<!--<ul id='list8'>";
	
	$req = $bdd->prepare("SELECT * FROM articles WHERE section = :id_section");
	$req->execute(array("id_section" => $sections[8]['id_section']));
	
	while($donnees = $req->fetch())
	{
		echo "<li><a href='index.php?page=article&amp;load=".$donnees['nom']."' title='".addslashes($donnees['desc'])."'>".$donnees['titre']."</a>";
	}
	
	$req->closeCursor();
	
	echo "	</ul>-->
			</li>
		</ul>
	</div>";
?>