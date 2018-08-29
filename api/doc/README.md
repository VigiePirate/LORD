# État des APIs

Le répertoire api, s'il est défini comme une application spécifique, contient en réalité deux API distinctes :

* geonames : traite de données géographiques
* lordrat : l'API qui traite les données du LORD proprement dit
* lordrat public, i.e. sans restriction d'IP : apparemment juste pour la carte des rateries (??)

Chacune de ces API est définie par un identifiant d'application, et autorise les accès en fonction d'une liste
de clés et d'adresses IP. Le code qui effectue la vérification des adresses IP a été inhibé afin que chacun
puisse développer tranquillement sur ses instances locales (classes/api.class/api.mysql.class.php l52-53).

```php
                                if(in_array($ip,$ips)) 
                                { 
                                        $datas = "success"; 
                                } 
                                else 
                                { 
                                        // ***** $datas = array("error" => API_ERROR_IP_NOT_IN_LIST); 
                                        $datas = "success"; 
                                } 

```


Ces identifiants sont stockés dans la base MySQL **lord\_api**, table *api\_apps* et les clés identifiant les
applications clientes et leurs adresses IP dans *api\_keys*.

Le routage vers la bonne application, selon son identifiant, et l'instanciation des classes sont effectués
dans index.php et l'analyse des arguments de l'URL est effectuée par le fichier correspondant dans le
répertoire *applications*.

## Configuration de l'application

Un fichier de configuration générique + un fichier pour chaque classe :

* config.php : Urls de l'api et de la doc du LORD (juste pour info dans les messages aux utilisateurs)
* classes/api.class/api.mysql.config.php : Identifiants de connexion à la base lord\_api.
* classes/geonames.class/geonames.mysql.config.php : Identifiants de connexion à la base geonames.
* classes/lordrat.class/lordrat.mysql.config.php : identifiants de connexion à la base lordrat\_v2 et
  définitions de constantes (nombre max de résultats sur les requêtes et messages d'erreur).

NB : les messages d'erreurs de la classe API\_MYSQL sont définies dans l'index.php plutôt que dans son
fichier de configuration.

## Appels à l'API

Exemple d'URL d'appel de l'API pour tester sur son navigateur :

https://api.lord.chez.moi/utilisateurs/get/full?id=1234&app=NhNWKfsvPJG09wlhT62o&key=LDpkLwmysBVdw1kE9hqH0q5KpPnE3oqO2Q9NmvmO7i1EjmisDJ

Les arguments sont décomposés de la manière suivante :

```
/<module>/<method>/<section>?<params[]>
```

Ou bien

```
/<module>/<method>?<params[]>
```

L'argument `method` n'a en fait pas de raison d'exister dans l'URL car c'est la méthode HTTP qui doit déterminer le
type d'opération. L'URL ne devrait spécifier que les ressources auxquelles cette opération s'applique. Cela
implique de revoir les appels à l'API dans les applications _front_ et _admin_.

Cf. la [liste des modules et de leurs arguments](./lordrat_api.json)

## Rôle des classes

* API\_MYSQL (classes/api.class/api.mysql.class.php) : sélection de l'application et vérification des
  autorisations d'accès (clé + IP)
* GEONAMESi\_MYSQL (classes/geonames.class/geonames.mysql.class.php) : Recherche de données de villes dans la
  base
* LORDRAT\_MYSQL\* (classes/lordrat.class/\*) : Accès aux données du LORD, avec une classe pour chaque argument <module>.



