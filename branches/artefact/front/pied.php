<?php
	$begin = 2009;
	$annee = date('Y', time());
	
	if($begin != $annee)
	{
		$annee = $begin . " - " . $annee;
	}
?>

<div id="pied">
	<p>
		Powered By : <a href="https://front.lord.brobdingnag.pw" target="_blank">Brobdingnag</a> | Design par Lime<br />
		&copy; <?php echo $annee; ?> <a href="https://front.lord.brobdingnag.pw" target="_blank">Livre des Origines du Rat Domestiques</a> - tous droits réservés<br />
		Hébergeur : <a href="https://front.lord.brobdingnag.pw" target="_blank">brobdingnag.pw</a>
	</p>
</div>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115891771-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-115891771-1');
</script>


