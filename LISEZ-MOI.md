Cesium website
===

## Comment contribuer

### Comment mettre à jour les liens de téléchargement

Lors d'une mise à jour de Cesium, il suffit de mettre à jour [le fichier cesiumVersions.php](cesiumVersions.php) pour que les liens de téléchargement soient automatiquement mis à jour.

Si ceux-ci étaient amenés à changer d'emplacement, veuillez mettre à jour [le fichier cesiumDownloads.php](cesiumDownloads.php)

### Comment traduire le tutoriel

Pour le tutoriel, vous trouverez les fichiers .html dans les dossiers type `i18n/es_ES/contents/tuto/` (où `es_ES` est la langue qui vous intéresse).

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

### Comment modifier les images

C'est dans `i18n/es_ES/contents/tuto/` (où `es_ES` est la langue qui vous intéresse).

Pour des questions de SEO, les noms des fichiers sont traduits, via les fichiers .po

### Comment traduire le reste

Pour les pages :

- Accueil
- Fonctionnalités
- Téléchargement
- ...et les menu de l'entête et du pied de page

les modifications sont à faire dans les fichiers .po que vous trouverez dans les dossiers type `i18n/es_ES/LC_MESSAGES/` (ici : l'espagnol)

Ces fichiers sont éditables avec des logiciels type PoEdit.


## Instructions d'installation

### .htaccess

Votre fichier .htaccess doit contenir les infos suivantes :

```txt
<IfModule mod_rewrite.c>
RewriteEngine On

# Adaptez la ligne suivante à votre configuration (avec un slash à la fin)
RewriteBase /cesium-website-project/cesium_website/

RewriteOptions InheritDown

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule .*\.php - [L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)/(.*)$ index.php?lang=$1&page=/$2 [L]
</IfModule>
```

Modifiez l'instruction RewriteBase du .htaccess pour qu'elle s'accorde à votre propre configuration 
(tapez l'endroit où CesiumWebsite est installé, typiquement /)

Si lorsque vous essayez d'accéder au site, vous avez une erreur "404 Not Found", c'est que votre fichier `.htaccess` n'est pas pris en considération par Apache.

Il vous faudra alors éditer votre fichier `/etc/apache2/apache2.conf` (anciennement `/etc/apache2/httpd.conf`) pour y remplacer :

```txt
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride None
        Require all granted
</Directory>
```
par :
```txt
<Directory /var/www/>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
</Directory>
```

Activez le mod_rewrite d'Apache :
```
sudo a2enmod rewrite
```

Redémarrez Apache :
```
systemctl restart apache2
```

### config.php

Modifiez la variable $rootURL de la même façon.


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
