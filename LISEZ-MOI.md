Cesium website
===

## A propos

Cet ensemble de scripts a pour but de rendre la modification du site cesium.app accessible à tout un chacun.

Ce qui était autrefois fait avec un CMS est maintenant fait avec ce script maison, ce qui présente les avantages suivants : 

* Le site est installable par n'importe qui n'importe où, ce qui : 
	* nous rend plus résilient en cas de problème
	* diminue le bus factor
* Mise à jour facilitée : 
	* au changement de version de l'appli Cesium, chaque contributeur du GitLab peut dorénavant faire un commit pour modifier le fichier cesiumVersions.php
	* chacun peut participer à l'amélioration du tutoriel (ou même du site en général)
* Traductions facilitée : 
	* alors que la traduction avec le CMS générait des pertes d'informations lors d'une mise à jour, le script maison résoud ce problème en utilisant des fichiers .po
	* pour le tutoriel, les traductions sont indépendantes ; on n'est donc pas obligé de faire de la traduction phrase par phrase ; on peut avoir des tutoriels organisés totalement différemment d'une langue à l'autre
	* Les captures d'écran sont aussi adaptées en fonction de la langue du visiteur
* Chargement plus rapide
* Personnalisation du style facilitée par un code complètement sémantique (pas de classes à la Twitter-boostrap).
* Edition facilitée : adieu le WYSIWYG laborieux de l'ancien CMS
* Chargement plus rapide, grâce à un code plus léger et optimisé à nos besoins.

## Contribuer

### Mettre à jour les liens de téléchargement

Lors d'une mise à jour de Cesium, il suffit de mettre à jour le fichier cesiumVersions.php pour que les liens de téléchargement soient automatiquement mis à jour.

Si ceux-ci étaient amenés à changer d'emplacement, veuillez mettre à jour le fichier cesiumDownloads.php

### Contribuer aux traductions

Fichiers .po pour les pages Accueil, Fonctionnalités et Téléchargement (et les menu de l'entête et du pied de page).
Ces fichiers sont éditables avec PoEdit.

Fichiers .html pour le tutoriel


## Licences

Ce logiciel est pour sa majeure partie sous licence GNU GPL 3.0.

Aux exceptions suivantes : 
	
- Le script Funding.class.php est basé sur la [barre de financement intégrable](https://git.duniter.org/paidge/barre-de-financement-int-grable), elle-même sous licence GNUL GPL 3.
- [Composer](https://getcomposer.org/) est sous licence MIT.
- [GeoIP2](https://maxmind.github.io/GeoIP2-php/) est la création de by MaxMind est distribué sous licence Apache
- Les [bases de données GeoLite2](https://dev.maxmind.com/geoip/geoip2/geolite2/) sont la création de MaxMind et sont sous licence Creative Commons Attribution-ShareAlike 4.0 International.
- Le script [LazyImg](https://github.com/colas31/lazyImg), dont la licence est inconnue.
- [Font-Awesome](https://fontawesome.com/license/free) est sous licence libre ([voir détail](https://fontawesome.com/license/free))
- Les photos, qui sont la propriété de leurs auteurs
- Le logo Cesium est la création de DiG

## Instructions d'installation

### .htaccess

Votre fichier .htaccess doit contenir les infos suivantes :

```
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /www/cesium-website/

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .*\.php - [L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)/(.*)$ index.php?lang=$1&page=/$2 [L]


# Redirections pour gérer l'ancienne structure de liens sans perdre en SEO
# (ex : /telechargement au lieu de /fr/telechargement)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)$ fr/$1 [R=301]
</IfModule>
```

Modifiez l'instruction RewriteBase du .htaccess pour qu'elle s'accorde à votre propre configuration 
(tapez l'endroit où CesiumWebsite est installé, typiquement /)

### config.php

Modifiez la variable $rootURL de la même façon.

