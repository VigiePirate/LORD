<script type="text/javascript" src="function.js"></script>
<form action="" method="post">
	<div>
		<img src='./design/boutons/bold.png' alt='B' onclick="insertTag('<bold>', '</bold>', 'textarea')"  />
		<img src='./design/boutons/italic.png' alt='I' onclick="insertTag('<italic>', '</italic>', 'textarea')"  />
		<img src='./design/boutons/underline.png' alt='U' onclick="insertTag('<underline>', '</underline>', 'textarea')"  />
		<img src='./design/boutons/del.png' alt='S' onclick="insertTag('<delete>', '</delete>', 'textarea')"  />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<img src='./design/boutons/left.png' alt='L' onclick="insertTag('<left>', '</left>', 'textarea')"  />
		<img src='./design/boutons/center.png' alt='C' onclick="insertTag('<center>', '</center>', 'textarea')"  />
		<img src='./design/boutons/right.png' alt='R' onclick="insertTag('<right>', '</right>', 'textarea')"  />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<img src='./design/boutons/small.png' alt='A' onclick="insertTag('<taille valeur=&quot;small&quot;>', '</taille>', 'textarea')" />
		<img src='./design/boutons/large.png' alt='A' onclick="insertTag('<taille valeur=&quot;large&quot;>', '</taille>', 'textarea')" />
		<img src='./design/boutons/x-large.png' alt='A' onclick="insertTag('<taille valeur=&quot;x-large&quot;>', '</taille>', 'textarea')" />
		<img src='./design/boutons/xx-large.png' alt='A' onclick="insertTag('<taille valeur=&quot;xx-large&quot;>', '</taille>', 'textarea')" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<img src='./design/boutons/yellow.png' alt='C' onclick="insertTag('<color valeur=&quot;yellow&quot;>', '</color>', 'textarea')" />
		<img src='./design/boutons/red.png' alt='C' onclick="insertTag('<color valeur=&quot;red&quot;>', '</color>', 'textarea')" />
		<img src='./design/boutons/blue.png' alt='C' onclick="insertTag('<color valeur=&quot;blue&quot;>', '</color>', 'textarea')" />
		<img src='./design/boutons/purple.png' alt='C' onclick="insertTag('<color valeur=&quot;purple&quot;>', '</color>', 'textarea')" />
		<img src='./design/boutons/orange.png' alt='C' onclick="insertTag('<color valeur=&quot;orange&quot;>', '</color>', 'textarea')" />
		<img src='./design/boutons/green.png' alt='C' onclick="insertTag('<color valeur=&quot;green&quot;>', '</color>', 'textarea')" />
		&nbsp;&nbsp;&nbsp;&nbsp;
		<img src='./design/boutons/link.png' alt='B' onclick="insertTag('', '', 'textarea', 'lien')"  />
		<img src='./design/boutons/img_link.png' alt='B' onclick="insertTag('', '', 'textarea', 'image')"  />
		<img src='./design/boutons/quote.png' alt='B' onclick="insertTag('', '', 'textarea', 'citation')"  />
		&nbsp;&nbsp;&nbsp;&nbsp;		
	</div>
	
	<textarea  onkeyup="preview(this, 'previewDiv');" onselect="preview(this, 'previewDiv');" id="textarea" cols="122" rows="15"></textarea>
		
	<p>
		<input name="previsualisation" type="checkbox" id="previsualisation" value="previsualisation" />
		<label for="previsualisation">Pr&eacute;visualisation automatique</label>
	</p>
	
	<div id="previewDiv" style='width:1000px;'></div>
</form>