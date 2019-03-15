# LORD

Livre des Origines du Rat Domestique Version 2

## Vue générale

Tout le code est situé dans un seul dossier lord, qui correspond à l'application symfony.

### Prérequis

Il faut avoir sur sa machine :

- php 7.2+
- [composer](https://getcomposer.org/)
- mysql 5.7+ ou mariadb
- [node](https://nodejs.org/en/)

### [Création du projet](https://symfony.com/doc/current/setup.html)

/!\ Cette étape est uniquement mentionnée à titre informatif !

    composer create-project symfony/website-skeleton lord
    cd lord
    bin/console server:run

[Installation de webpack-encore](https://symfony.com/doc/current/frontend/encore/installation.html) :

    composer require webpack-encore
    npm install

Installation de différents paquets npm nécessaires

`npm i -D postcss-loader sass-loader node-sass autoprefixer babel-preset-env bootstrap jquery popper.js webpack-notifier`

### Set up

Commencez par cloner le projet && cd si vous ne l'avez pas encore :D
    
    git clone git@github.com:VigiePirate/LORD.git && cd LORD/lord
    composer install
    npm install

#### Database

Modifier la ligne DATABASE_URL du fichier .env (fichier de configuration spécifique à chaque développeur
non commité, la configuration exemple se trouve dans .env.dist, qui est commité).

L'ORM (composant permettant de gérer la base de données en fonction des entités) utilisé est [Doctrine](https://symfony.com/doc/current/doctrine.html). Les instructions qui suivent permettent de démarrer un projet vierge au niveau de la BDD (ce qui n'est pas notre cas) :

    php bin/console doctrine:database:create // création de la BDD
    php bin/console server:run // lancement du serveur

Ceci permet de créer une base (vide) et de lancer le serveur PHP.

Pour nous, il faudra importer la base de PA ([cf doc d'installation branche PA](https://github.com/VigiePirate/LORD/blob/PA/database/README.md)). Il y aura certainement des erreurs à régler.
Il faudra malheureusement effectuer un travail de revue de la base lordrat_v2 pour voir ce qu'il faut
garder, et on pourra créer un script d'initiation de la base pour importer le contenu nécessaire.

Si besoin de rajouter un champs à une entité (LordRattery par exemple) ou de créer une entité :

    // créer ou mettre à jour une entité :
    php bin/console make:entity

    // créer un fichier de migration (différence entre la structure de la base et les entités)
    php bin/console make:migration

    // mettre à jour la base
    php bin/console doctrine:migrations:migrate

#### Assets

La gestion des assets se fait avec Encore, un wrapper pour webpack. Il y a toute une configuration
à faire une fois à la création du projet, normalement rien à faire de votre coté.
Pour info, dans le webpack.config.js :

- ligne 20 : `.addEntry("app", "./assets/js/app.js")` : le fichier js principal
- ligne 38 : `.enableSassLoader()` : je pense qu'on va utiliser du scss, il faut donc activer
  le sass-loader de webpack
- ligne 41 : post-css pour autopréfixer (rendre compatible le css avec les vieux navigateurs)

  `.enablePostCssLoader(options => { options.config = { path: "config/postcss.config.js" }; })`

- ligne 51 : `.autoProvidejQuery();` : déclaration globale de jquery

/!\ La compilation de sass requiert node-sass, qui _peut_ être galère à installer.

### Architecture

- assets : css, js, images, etc
- config
- src : dossier où se situe le code source. Il va se décomposer en plusieurs dossiers qui seront créés
  au fur et à mesure des besoins, pour le moment nous avons : - Controller : les actions relatives à chaques routes - Entity : les modèles de données - Migrations : il s'agit d'un dossier créé par doctrine, qui permet de gérer les différences entre
  les modèles et l'état de la base. En effectuant un calcul de différence, on pourra automatiquement
  régénérer les tables dont on a besoin (ainsi que leur structure) - Repository : contient le code qui va requêter en base en relation avec une entité (en gros : les
  requêtes SQL persos)
  Viendront s'ajouter les services, les event listeners, etc.
- templates
- tests : perso je n'ai pas l'habitude d'en faire, comme toujours c'est un compromis entre perdre du
  temps maintenant pour rédiger des tests ou perdre du temps plus tard pour corriger des bugs.
- vendor : tous les bundles, qui sont installés avec composer. Dossier non commité.

### Commandes utiles

- `bin/console server:run` => lance le serveur de développement

- `./node_modules/.bin/encore dev-server --hot` => lancer le serveur des assets, en théorie avec le hot module replacement
  (pas besoin de recharger la page lorsqu'on modifie du css/js), en pratique j'ai l'impression que ça ne marche pas des masses.

- `bin/console doctrine:database:create` : créer la base locale

- `bin/console make:entity` : créer ou mettre à jour une entité. De la même façon on peut créer un controller, une commande, etc

- `bin/console make:migration` : calculer le différentiel entités/base de données

- `bin/console doctrine:migrations:migrate` : appliquer le différentiel

- `bin/console doctrine:schema:update -f` : mettre à jour la structure de la base comme un bourrin (mais ça marche bien)

- Fixtures : en cours de rédaction

Toute la doc qui fait référence à doctrine se trouve [ici](https://symfony.com/doc/current/doctrine.html)

@TODO:

- Inscription et login :heavy_check_mark:
- Gestion des rôles (admin et user) :heavy_check_mark:
- Admin :
    - afficher la liste des rateries :heavy_check_mark:
    - éditer une raterie :heavy_check_mark:
    - ...
- Front : tout
