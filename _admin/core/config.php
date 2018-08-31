<?php

// Déclaration de la durée de conservation des informations de sessions dans les cookies
$cookie_lifespan = 3600*24*30;

// Déclaration des pages actives et accessibles dans le code
$active_page = array(
	"articles",
	"changelog",
	"criteres",
	"dashboard",
	"gsite",
	"medias",
	"rats",
	"rateries",
	"users"
);

// Déclaration des plugins
$plugins = array(
	"highlight" => array(
		"css"	=> "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.11.0/styles/default.min.css",
		"js"	=> "https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.11.0/highlight.min.js",
		"php"	=> FALSE
	),
	"jquery.addons" => array(
		"css"	=> FALSE,
		"js"	=> "https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/libs/jquery.addons/dev/jquery.addons.js",
		"php"	=> FALSE
	),
	"jquery-ui" => array(
		"css"	=> "plugins/jquery-ui/jquery-ui.min.css",
		"js"	=> array(
			"plugins/jquery-ui/jquery-ui.min.js",
			"plugins/jquery-ui/jquery-ui.datepicker.fr.js",
			"plugins/jquery-ui/jquery-ui.datepicker.init.js"
		),
		"php"	=> FALSE
	),
	"jquery-ui-timepicker-addon" => array(
		"css"	=> "https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css",
		"js"	=> array(
			"https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js",
			"https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/i18n/jquery-ui-timepicker-fr.js"
		),
		"php"	=> FALSE
	),
	"jquery-upload-file" => array(
		"css"	=> "https://hayageek.github.io/jQuery-Upload-File/4.0.10/uploadfile.css",
		"js"	=> "https://hayageek.github.io/jQuery-Upload-File/4.0.10/jquery.uploadfile.min.js",
		"php"	=> FALSE
	),
	"pop-up" => array(
		"css"	=> "https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/plugins/pop-up/dev/css/pop-up.css",
		"js"	=> "https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/plugins/pop-up/dev/js/pop-up.js",
		"php"	=> FALSE
	),
	"kEditor" => array(
		"css"	=> "https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/plugins/kEditor/dev/css/kEditor.css",
		"js"	=> "https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/plugins/kEditor/dev/js/kEditor.js",
		"php"	=> FALSE
	),
	"kMedia" => array(
		"css"	=> "https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/plugins/kMedia/dev/css/kMedia.css",
		"js"	=> array(
			"plugins/kMedia/kMedia.config.js",
			"https://storage.gra3.cloud.ovh.net/v1/AUTH_24a0caced60d43edb081596c2e658a09/cdn/plugins/kMedia/dev/js/kMedia.js"
		),
		"php"	=> FALSE
	),
);

// URL du site, necessite le / à la fin
$site_url = "https://admin.lord.brobdingnag.pw/";
$front_url = "https://front.lord.brobdingnag.pw/";

// Paramètres de domaines
define('DOMAIN_ROOT',		'lord.brobdingnag.pw/');
define('URL_FRONT',			'https://front.'.DOMAIN_ROOT.'/');
define('URL_ADMIN',			'https://admin.'.DOMAIN_ROOT.'/');

// Information sur l'hébergement
$hosting = array(
	"name"		=> "Brobdingnag",
	"url"		=> "https://front.lord.brobdingnag.pw",
	"mail"		=> "artefact@vigies-pirates.net"		
);

// Information sur le Webmaster
$webmaster = array(
	"name"		=> "Artefact",
	"url"		=> "https://front.lord.brobdingnag.pw",
	"mail"		=> "webmaster@lord-rat.org"
);

// Information sur la version du site
$site_version = "v3.0";

// Activation de l'authentification
$auth_required = TRUE;

// Temps d'attente avant une redirection javascript
$js_wait_redirect_time = 2500;

// Déclaration des bases de données pour les deux versions du site
$db_v1_infos = array(
	"db_host"		=> "localhost",
	"db_name"		=> "lordrat_v1",
	"db_user"		=> "lordrat",
	"db_password"	=> "BBxyzISAJfG4hpMf"
);

$db_v2_infos = array(
	"db_host"		=> "localhost",
	"db_name"		=> "lordrat_v2",
	"db_user"		=> "lordrat",
	"db_password"	=> "BBxyzISAJfG4hpMf"
);

// Définition du chemin absolu ou seronts stockés les médias du site
$_SESSION['medias_path'] = "/lamp0/web/vhosts/lord/medias/";

// Définition du chemin d'accès aux fichier
$_SESSION['medias_http'] = "https://front.lord.brobdingnag.pw/medias/";

// Déclaration des menus => Sera migré dans une base de données lors d'une prochaine version
$menus = array(
	"bottom"	=> array(
		"active"	=> TRUE,
		"type"		=> "link",
		"text"		=> "
		Webmaster & Designer <a href='".$webmaster["url"]."' target='_blank'>".$webmaster["name"]."</a> - 
		Hébergement <a href='".$hosting['url']."' target='_blank'>".$hosting['name']."</a> - 
		Version courante : ".$site_version
		),
	"top"		=> array(
		"active"	=> TRUE,
		"type"		=> "menu",
		"brand"		=> "Administration du LORD",
		"elements"	=> array(
				array(
					"titre"		=> "Les Rats",
					"name"		=> "rats",
					"url"		=> "#",
					"active"	=> TRUE,
					"submenu"	=> array(
						array(
							"titre"		=> "Ajouter",
							"name"		=> "add",
							"url"		=> "index.php?page=rats&amp;section=add",
							"active"	=> FALSE
						),
						array(
							"titre"		=> "Liste",
							"name"		=> "list",
							"url"		=> "index.php?page=rats&amp;section=list",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "SAV",
							"name"		=> "sav",
							"url"		=> "index.php?page=rats&amp;section=sav",
							"active"	=> TRUE
						)
					)
				),
				array(
					"titre"		=> "Les Rateries",
					"name"		=> "rateries",
					"url"		=> "#",
					"active"	=> TRUE,
					"submenu"	=> array(
						array(
							"titre"		=> "Ajouter",
							"name"		=> "add",
							"url"		=> "index.php?page=rateries&amp;section=add",
							"active"	=> FALSE
						),
						array(
							"titre"		=> "Liste",
							"name"		=> "list",
							"url"		=> "index.php?page=rateries&amp;section=list",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "La MAP",
							"name"		=> "map",
							"url"		=> "index.php?page=rateries&amp;section=map",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "SAV",
							"name"		=> "sav",
							"url"		=> "index.php?page=rateries&amp;section=sav",
							"active"	=> FALSE
						)
					)
				),
				array(
					"titre"		=> "Les Critères",
					"name"		=> "criteres",
					"url"		=> "#",
					"active"	=> TRUE,
					"submenu"	=> array(
						array(
							"titre"		=> "Causes de dèces",
							"name"		=> "causesdeces",
							"url"		=> "index.php?page=criteres&amp;section=causesdeces",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Couleurs",
							"name"		=> "couleurs",
							"url"		=> "index.php?page=criteres&amp;section=couleurs",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Dilutions",
							"name"		=> "dilutions",
							"url"		=> "index.php?page=criteres&amp;section=dilutions",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Marquages",
							"name"		=> "marquages",
							"url"		=> "index.php?page=criteres&amp;section=marquages",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Poils",
							"name"		=> "poils",
							"url"		=> "index.php?page=criteres&amp;section=poils",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Problèmes de santés",
							"name"		=> "pbsantes",
							"url"		=> "index.php?page=criteres&amp;section=pbsantes",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Oreilles",
							"name"		=> "oreilles",
							"url"		=> "index.php?page=criteres&amp;section=oreilles",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Uniques",
							"name"		=> "uniques",
							"url"		=> "index.php?page=criteres&amp;section=uniques",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Yeux",
							"name"		=> "yeux",
							"url"		=> "index.php?page=criteres&amp;section=yeux",
							"active"	=> TRUE
						)
					)
				),
				array(
					"titre"		=> "Les Utilisateurs",
					"name"		=> "users",
					"url"		=> "#",
					"active"	=> FALSE,
					"submenu"	=> array(
						array(
							"titre"		=> "Ajouter",
							"name"		=> "add",
							"url"		=> "index.php?page=users&amp;section=add",
							"active"	=> FALSE
						),
						array(
							"titre"		=> "Liste",
							"name"		=> "list",
							"url"		=> "index.php?page=users&amp;section=list",
							"active"	=> TRUE
						)
					)
				),
				array(
					"titre"		=> "Gestion du site",
					"name"		=> "gsite",
					"url"		=> "#",
					"active"	=> TRUE,
					"submenu"	=> array(
						array(
							"titre"		=> "Sections",
							"name"		=> "sections",
							"url"		=> "index.php?page=gsite&amp;section=sections",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Articles",
							"name"		=> "articles",
							"url"		=> "index.php?page=gsite&amp;section=articles",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Messagerie",
							"name"		=> "messagerie",
							"url"		=> "index.php?page=gsite&amp;section=messagerie",
							"active"	=> FALSE
						),
						array(
							"titre"		=> "Medias",
							"name"		=> "medias",
							"url"		=> "index.php?page=gsite&amp;section=medias",
							"active"	=> TRUE
						),
						array(
							"titre"		=> "Suggestions",
							"name"		=> "suggestions",
							"url"		=> "index.php?page=gsite&amp;section=suggestions",
							"active"	=> FALSE
						),
						array(
							"titre"		=> "Changelog",
							"name"		=> "changelog",
							"url"		=> "index.php?page=gsite&amp;section=changelog",
							"active"	=> FALSE
						),
						array(
							"titre"		=> "PhpMyAdmin",
							"name"		=> "phpmyadmin",
							"url"		=> "phpmyadmin",
							"active"	=> TRUE
						)
					)
				)
			),
		"elements_right" => array(
			array(
				"titre"		=> "Messagerie",
				"name"		=> "messagerie",
				"url"		=> "index.php?page=messagerie",
				"align"		=> "right",
				"active"	=> TRUE
			),
			array(
				"titre"		=> "Profil",
				"profil"	=> "profil",
				"url"		=> "index.php?page=profil",
				"align"		=> "right",
				"active"	=> TRUE
			),
			array(
				"titre"		=> "Déconnexion",
				"name"		=> "logout",
				"url"		=> "index.php?logout",
				"align"		=> "right",
				"active"	=> TRUE
			)
		)
	)
);

