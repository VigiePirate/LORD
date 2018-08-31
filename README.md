# LORD

Livre des Origines du Rat Domestique Version 2

## Proof Of Concept en utilisant Symfony avec un paradigme 'API-first'.

Ce projet est donc construit autour d'une api centrale qui sera interrogée
par l'admin et le front.

L'api est construite en utilisant un squelette de base symfony 4 et ApiPlatform
https://api-platform.com
L'idée de cet outil est d'exposer une api simplement en créant les entités : rien
(ou presque) à gére coté BDD et routing.

Les technologies utilisées pour construire le front et l'admin sont totalement indépendantes
et peuvent être choisies en fonction des affinités des dévs :

### Client JS :

- nécessite de bonnes connaissances en javascript/ frameworks front-end (angular, react, vue...),
- demande plus de travail si le SEO est important (server side rendering avec nodejs),
- sensation de fluidité/rapidité, pas de "blink" car pas de rechargement de page
- ajax, promesses
- ecosystème et communauté : le combo "client js qui interroge une api" est très utilisée et donc très documentée
- 3 applications complétement indépendantes

### Application php (symfony ou pas):

- plus facile à appréhender si la majorité des devs sont proéfficients en php,
- aucun problème de SEO (html rendu coté serveur),
- A priori toutes les applications (admin, api, front) peuvent être intégrées au sein du même projet symfony (
  à confirmer avec la nouvelle architecture de symfony 4)
- Interrogation de l'api via cUrl, fsockopen, http://docs.guzzlephp.org/en/stable

Pour l'exemple je laisse l'admin React fourni par Api Platform, mais je pense qu'il sera beaucoup trop complexe à customiser, et qu'on peut se permettre soit de partir de 0, soit de retravailler les applications admin et front avec la base que l'on a.

### Installation

#### API

Il est nécessaire d'avoir php et composer d'installés.

    cd api
    composer install

Modifier le fichier .env pour rentrer vos paramètres de connexion à la base de données.
L'ORM (composant permettant de gérer la base de données en fonction des entités) utilisé est Doctrine : https://symfony.com/doc/current/doctrine.html

    php bin/console doctrine:database:create
    php bin/console server:run

La base est créée, le serveur php est lancé...mais la base est vide !
Il faudra malheureusement effectuer un travail de revue de la base lordrat_v2 pour voir ce qu'il faut
garder, et on pourra créer un script d'initiation de la base pour importer le contenu nécessaire.

    // créer ou mettre à jour une entité :
    php bin/console make:entity

    // créer un fichier de migration (différence entre la structure de la base et les entités)
    php bin/console make:migration

    // mettre à jour la base
    php bin/console doctrine:migrations:migrate

#### ADMIN

/!\ à modifier selon le choix de la technologie utilisée
Pour un client JS :

    cd admin
    npm install
    npm start
