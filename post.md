[cesium.app] Quelques nouveautés et gros changement d'organisation
===

Bonjour tous, 

cesium.app évolue ! 

Quelques modifications visibles de tous, mais l'essentiel du changement sera au niveau de l'organisation.

Tour d'horizon : 

## En façade, peu de changement...

Mais vous pouvez aller jeter un oeil quand même : 

http://uploads.borispaing.fr/cesium/cesium.app/

- Page d'accueil un peu retravaillée : 
	- Caractéristiques : 
		- réduites à 3 au lieu de 6 : exit "collaboratif", "modifiable", "fort de café"
		- petit effet bouton enfoncé 
		- changement des couleurs des icônes
	- Commentaires mis en valeurs (plutôt que d'être confusément aposés sur une photo)
	- Photos mises en valeur (plutôt que d'être tristement cachées derrière un commentaire)
- Traduction en Haut Valyrian (parce que pourquoi pas ?)
- Ajout d'une page fonctionnalités, ce qui fait suite aux discussions relatives à l'arrêt de CesiumWeb et la nécessité pour l'utilisateur de savoir ce qu'il aura.
- Une [page de remerciements](http://uploads.borispaing.fr/cesium/cesium.app/fr/merci/android) s'affiche après le clic sur le bouton "Télécharger" et propose à l'utilisateur de faire un don en G1 sur le portefeuille de Cesium-Team.
- Architecture du tutoriel retravaillée pour avoir des pages plus courtes, plus digestes, et avec un sommaire latéral.

## Sous le capot, tout change !

Mais c'est sous le capot que tout change.

En effet, c'est avec le plus grand désarroi qu'après avoir constaté les limitations du CMS que nous utilisions jusque là pour éditer cesium.app, j'ai décidé de coder un système sur-mesure.

### Les limitations du CMS

Les limitations constatées sur le CMS que nous utilisions étaient les suivantes : 

- Difficulté à mettre à jour le contenu du site (le WYSIWYG du CMS était très désagréable à utiliser).
- Impossibilité d'avoir un rendu visuel correct (notamment sur le tutoriel)
- Impossibilité d'adapter les images en fonction de la langue du visiteur (et encore moins en fonction de son pays). Très problématique pour nous car nous avons besoin d'afficher des captures d'écran de Cesium adaptées au visiteur.
- Impossibilité de rendre les traductions indépendantes : la traduction se fait obligatoirement phrase par phrase, ce qui peut donner des choses pas naturelles, et n'offre pas de flexibilité pour la rédaction du tutoriel (qui devrait pouvoir être plus ou moins fourni en fonction de la disponibilité des traducteurs, et qui devrait aussi pouvoir être organisé différemment d'une langue à l'autre).
- Impossibilité de traduire les permaliens (mauvais pour le SEO)

### (CMS) vs. (sur-mesure + Git)

J'ai l'habitude d'utiliser des CMS dans mes projets et je trouve généralement que c'est la démarche la plus appropriée car elle évite de perdre du temps à réinventer la roue et même lorsqu'il s'agit de faire rédiger du contenu par plusieurs personnes, il existe des outils idoines.

En revanche, ici, c'était un peu différent et il a fallu s'adapter au contexte particulier et des besoins spécifiques engendrés par celui-ci : 

| Qualité évaluée | CMS | Scripts sur-mesure + Git |
|---|---|---|
| Qui peut éditer le contenu ? | Le contenu est suposément éditable par quelqu'un qui serait seulement moyennement geek. | Il faut être pas mal geek pour utiliser Git, mais n'importe qui qui aurait l'idée de contribuer à un site web est probablement geek au point d'être capable d'utiliser Git. |
| Bus factor | Pour mettre à jour le contenu (par exemple lors de la sortie d'une nouvelle version de Cesium), il faut que suffisamment de personnes disposent sur le site d'un compte avec privilèges éditeur au minimum. | Tout le monde peut mettre à jour le contenu. Il faut que suffisamment de personnes soient administrateurs du dépôt Git pour valider les modifications. |
| Résilience en cas de problème | Il faut que des sauvegardes aient été faites soigneusement. | Le site s'installe n'importe où en 30 minutes. |
| Changement d'apparence | Laborieuse | Tout est accessible dans le CSS via une convention de nommage sémantique (pas de noms de classe caca à la Twitter-boostrap qui rappellent surtout l'époque du HTML4) | 
