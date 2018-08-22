function insertTag(startTag, endTag, textareaId, tagType) {
	var field = document.getElementById(textareaId);
	var scroll = field.scrollTop;
	field.focus();
	
	
	if (window.ActiveXObject) {
		var textRange = document.selection.createRange();            
		var currentSelection = textRange.text;
	} else {
		var startSelection   = field.value.substring(0, field.selectionStart);
		var currentSelection = field.value.substring(field.selectionStart, field.selectionEnd);
		var endSelection     = field.value.substring(field.selectionEnd);
	}
	
	if (tagType) {
		switch (tagType) {
			case "citation":
				endTag = "</citation>";
				if (currentSelection) {
						if (currentSelection.length > 30) {
								var auteur = prompt("Quel est l'auteur de la citation ?") || "";
								startTag = "<citation nom=\"" + auteur + "\">";
						} else {
								var citation = prompt("Quelle est la citation ?") || "";
								startTag = "<citation nom=\"" + currentSelection + "\">";
								currentSelection = citation;    
						}
				} else {
						var auteur = prompt("Quel est l'auteur de la citation ?") || "";
						var citation = prompt("Quelle est la citation ?") || "";
						startTag = "<citation nom=\"" + auteur + "\">";
						currentSelection = citation;    
				}
				break;
			case "image":
				endTag = "";
				var URL = prompt("Quelle est l'url de l'image ?");
				startTag = "<image url=\"" + URL + "\" \/>";
				break;
			case "lien":
				endTag = "</lien>";
				if (currentSelection) {
						if (currentSelection.indexOf("https://") == 0 || currentSelection.indexOf("https://") == 0 || currentSelection.indexOf("ftp://") == 0 || currentSelection.indexOf("www.") == 0) {
								var label = prompt("Quel est le libellé du lien ?") || "";
								startTag = "<lien url=\"" + currentSelection + "\">";
								currentSelection = label;
						} else {
								var URL = prompt("Quelle est l'url ?");
								startTag = "<lien url=\"" + URL + "\">";
						}
				} else {
						var URL = prompt("Quelle est l'url ?") || "";
						var label = prompt("Quel est le libellé du lien ?") || "";
						startTag = "<lien url=\"" + URL + "\">";
						currentSelection = label;                     
				}
				break;
		}
	}
	
	if (window.ActiveXObject) {
		textRange.text = startTag + currentSelection + endTag;
		textRange.moveStart('character', -endTag.length-currentSelection.length);
		textRange.moveEnd('character', -endTag.length);
		textRange.select();  
	} else { // Ce n'est pas IE
		field.value = startSelection + startTag + currentSelection + endTag + endSelection;
		field.focus();
		field.setSelectionRange(startSelection.length + startTag.length, startSelection.length + startTag.length + currentSelection.length);
	}  
	
	field.scrollTop = scroll;   
}

function preview(textareaId, previewDiv) {
	var field = textareaId.value;
	if (document.getElementById('previsualisation').checked && field) {	
		field = field.replace(/&/g, '&amp;');
		field = field.replace(/</g, '&lt;').replace(/>/g, '&gt;');
		field = field.replace(/\n/g, '<br />').replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
		
		field = field.replace(/&lt;bold&gt;([\s\S]*?)&lt;\/bold&gt;/g, '<strong>$1</strong>');
		field = field.replace(/&lt;italic&gt;([\s\S]*?)&lt;\/italic&gt;/g, '<em>$1</em>');
		field = field.replace(/&lt;underline&gt;([\s\S]*?)&lt;\/underline&gt;/g, '<span style="text-decoration:underline;">$1</span>');
		field = field.replace(/&lt;delete&gt;([\s\S]*?)&lt;\/delete&gt;/g, '<span style="text-decoration:line-through;">$1</span>');
		
		field = field.replace(/&lt;left&gt;([\s\S]*?)&lt;\/left&gt;/g, '<span style="display:block;text-align:left;">$1</span>');
		field = field.replace(/&lt;center&gt;([\s\S]*?)&lt;\/center&gt;/g, '<span style="display:block;text-align:center;">$1</span>');
		field = field.replace(/&lt;right&gt;([\s\S]*?)&lt;\/right&gt;/g, '<span style="display:block;text-align:right;">$1</span>');
		
		field = field.replace(/&lt;lien&gt;([\s\S]*?)&lt;\/lien&gt;/g, '<a href="$1">$1</a>');
		field = field.replace(/&lt;lien url="([\s\S]*?)"&gt;([\s\S]*?)&lt;\/lien&gt;/g, '<a href="$1" title="$2">$2</a>');
		field = field.replace(/&lt;image url="([\s\S]*?)" \/&gt;/g, '<img src="$1" alt="Image" />');
		field = field.replace(/&lt;citation nom=\"(.*?)\"&gt;([\s\S]*?)&lt;\/citation&gt;/g, '<p>Citation de $1</p><blockquote cite=\'$1\'>$2</blockquote>');
		
		field = field.replace(/&lt;taille valeur=\"(.*?)\"&gt;([\s\S]*?)&lt;\/taille&gt;/g, '<span style="font-size:$1;">$2</span>');
		field = field.replace(/&lt;color valeur=\"(.*?)\"&gt;([\s\S]*?)&lt;\/color&gt;/g, '<span style="color:$1;">$2</span>');
		
		document.getElementById(previewDiv).innerHTML = field;
	}
}