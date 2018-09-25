# Principe d'une application "tout en un"

C'est dans les dossiers src/Controller et templates que la distinction admin/front se fait principalement.
L'annotation @Route dans le [controller principal de l'admin](https://github.com/VigiePirate/LORD/blob/symfony/lord/src/Controller/Admin/DashboardController.php) permet de lier une url à l'action d'un controller.

L'admin et le front ont accès aux mêmes entités (dossier src/Entity), qui correspondent à la représentation objet d'une table de la BDD. Il n'est donc pas requis d'exposer ces données via une api pour pouvoir les manipuler (Create, Read, Update, Delete), même si cela peut s'avérer peut pratique pour effectuer une requête ajax par exemple (requête javascript non-bloquante effectuée depuis une vue pour actualiser une portion de page sans recharger toute la page).

Pro :

- un seul langage dominant (php) et un seul framework (symfony). Le JS est limité aux animations sur les pages et aux requêtes ajax. A noter qu'on utilise aussi un moteur de templating (twig), pour éviter d'avoir des `<?php echo "toto"; ?>` partout dans le html.
- moins de développement a priori (besoins en api beaucoup plus limités).
- symfony possède un large écosystème (communauté, plugins) qui peuvent accélérer le dev.

Cons :

- Il faut bien comprendre le fonctionnement de symfony + apprendre twig. Cela peut représenter une surcharge de travail au niveau du développement front-end (que ce soit pour l'admin ou le front).
- Application php => multipage, donc on a plus facilement une impression de lenteur ("blink" quand on navigue sur le site), mais de toutes façons on y est habitué vu que + de 80% des sites web tournent sous php.

