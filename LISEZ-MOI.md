Cesium website
===

## Le pourquoi du comment

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

Il est possible que courant 2020 ces scripts PHP soient remplacés par un générateur de site statiques (SSG) type Pelican.

## Comment contribuer

### Comment mettre à jour les liens de téléchargement

Lors d'une mise à jour de Cesium, il suffit de mettre à jour le fichier cesiumVersions.php pour que les liens de téléchargement soient automatiquement mis à jour.

Si ceux-ci étaient amenés à changer d'emplacement, veuillez mettre à jour le fichier cesiumDownloads.php

### Comment traduire le tutoriel

Pour le tutoriel, vous trouverez les fichiers .html dans les dossiers type `i18n/es_ES/contents/tuto/`

#### Comment formatter les URLs dans le menu

Il vous faudra aussi modifier le fichier `menu.html`

Dans le menu, les URLs doivent avoir la forme suivante : 
```html
<ul>
	<li>
		<a href="item">Item</a>
	</li>
	<li>
		<a href="item/">Item</a>
		<!-- Ira chercher le index.html du dossier -->
		
		<ul>
			<li><a href="item/sous-item">Sous-item</a></li>
		</ul>
	</li>
</ul>
````
Ici, slash ou pas slash, ça compte : 

* **un slash** de fin pour un **dossier** (va chercher le index.html à la racine du dossier)
* **pas de slash** de fin pour un **fichier** (va chercher le .html correspondant)

#### Comment formatter les URLs dans les fichiers

Chaque URLs est relative au fichier dans lequel on l'écrit.

#### Comment rendre notre code clair pour les autres

Efforçons-nous d'aérer au maximum votre code HTML, afin qu'il soit facilement lisible par tous et donc rapidement modifiable.

Aussi : utiliser 4 espaces consécutifs en guise d'indentation est une déviance ainsi qu'une perversion.

#### Comment faire en sorte que le contenu soit lisible pour le visiteur

J'ai remarqué que pour les instructions dans un tuto, souvent une liste ordonnée &lt;ol&gt;&lt;/ol&gt; rend mieux 
qu'une liste non-ordonnée &lt;ul&gt;&lt;/ul&gt;

#### Soyons sémantiques !

Écrivons à la mode XHTML : 

* un slash à la fin de nos balises &lt;img /&gt;
* un slash à la fin de nos balises &lt;br /&gt;

Des éditeurs comme Notepadqq (Linux) nous permettent de répérer facilement la 
présence de balises non fermées (votre code est coloré diféremment).

Niveau HTML&nbsp;:

* [C'est pas interdit](https://developer.mozilla.org/fr/docs/Web/HTML/Element/li#R%C3%A9sum%C3%A9_technique) 
  de mettre des &lt;p&gt; (contenu de flux) dans des &lt;li&gt;, mais c'est rare que ce soit vraiment nécessaire.
  Généralement le résultat que vous cherchez s'obtient mieux en CSS.

Si un truc rend moche, bidouillez les fichiers .css ou demandez-moi de le faire plutôt 
que de rajouter des balises surnuméraires (genre plutôt que de mettre des &gt;p&gt; ou des &gt;br/&gt; pour créer des marges, 
utilisons la propriété CSS dédiée, *margin*).

### Comment modifier les images

C'est dans `i18n/es_ES/contents/tuto/`

Pour des questions de SEO, les noms des fichiers sont traduits, via les fichiers .po

### Comment traduire le reste

Pour les pages :

- Accueil
- Fonctionnalités
- Téléchargement
- ...et les menu de l'entête et du pied de page

les modifications sont à faire dans les fichiers .po que vous trouverez dans les dossiers type `i18n/es_ES/LC_MESSAGES/` (ici : l'espagnol)

Ces fichiers sont éditables avec des logiciels type PoEdit.



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

