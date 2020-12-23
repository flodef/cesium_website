Comment traduire le site
===

## Comment traduire le contenu principal

Pour les pages :

- Accueil
- Fonctionnalités
- Téléchargement

...et les menu de l'entête et du pied de page :

les modifications sont à faire dans les fichiers .po que vous trouverez dans les dossiers type `i18n/es_ES/LC_MESSAGES/` (ici : l'espagnol)

Ces fichiers sont éditables avec des logiciels type [PoEdit](https://poedit.net/).

## Comment traduire le tutoriel

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
```

Ici, slash ou pas slash, ça compte : 

* **un slash** de fin pour un **dossier** (va chercher le index.html à la racine du dossier)
* **pas de slash** de fin pour un **fichier** (va chercher le .html correspondant)

### Comment formatter les URLs dans les fichiers

Chaque URLs est relative au fichier dans lequel on l'écrit.

### Comment rendre notre code clair pour les autres

Efforçons-nous d'aérer au maximum votre code HTML, afin qu'il soit facilement lisible par tous et donc rapidement modifiable.

Aussi : utiliser 4 espaces consécutifs en guise d'indentation est une déviance ainsi qu'une perversion.

### Comment faire en sorte que le contenu soit lisible pour le visiteur

J'ai remarqué que pour les instructions dans un tuto, souvent une liste ordonnée &lt;ol&gt;&lt;/ol&gt; rend mieux 
qu'une liste non-ordonnée &lt;ul&gt;&lt;/ul&gt;

## Comment modifier les images

C'est dans `i18n/es_ES/contents/tuto/` (où `es_ES` est la langue qui vous intéresse).

Pour des questions de SEO, les noms des fichiers sont traduits, via les fichiers .po

