<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.11.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.11.0/highlight.min.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<h1>Ressources pour le LORD v1</h1>

<h3>Pour changer un utilisateur dans toutes les tables</h3>

<pre><code class='SQL'>
	SET @old_pseudo = 'Ancien Pseudo', @new_pseudo = 'Nouveau Pseudo';
	UPDATE peel_utilisateurs, peel_marques, peel_rats
	SET peel_utilisateurs.pseudo = @new_pseudo, peel_marques.proprio = @new_pseudo, peel_rats.proprietaire = @new_pseudo
	WHERE peel_utilisateurs.pseudo = @old_pseudo AND peel_marques.proprio = @old_pseudo AND peel_rats.proprietaire = @old_pseudo;
</code></pre>

<h3>Pour Finaliser un changement de pseudo deja fait dans peel_utilisateurs</h3>

<code><pre class='SQL'>
	SET @old_pseudo = 'Ancien Pseudo', @new_pseudo = 'Nouveau Pseudo';
	UPDATE peel_marques, peel_rats
	SET peel_marques.proprio = @new_pseudo, peel_rats.proprietaire = @new_pseudo
	WHERE peel_marques.proprio = @old_pseudo AND peel_rats.proprietaire = @old_pseudo;
</code></pre>