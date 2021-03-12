<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="lib/css/w3.css">
	<link rel="stylesheet" href="lib/css/font_awesome.min.css">
	<link rel="stylesheet" href="lib/css/gh-fork-ribbon.min.css" />
	<link rel="stylesheet" href="generator.css">
	<title>Génération de votre barre de financement</title>
</head>
<body>
<a class="github-fork-ribbon" href="https://git.duniter.org/paidge/barre-de-financement-int-grable" data-ribbon="Fork me on Gitlab" title="Fork me on Duniter's Gitlab">Fork me on Duniter's Gitlab</a>
<header>
	<div class="w3-panel w3-padding-16 w3-display-middle w3-center w3-theme-d2">
		<h1 class="w3-jumbo">Générez votre barre de financement</h1>
		<h2>En monnaie libre Ğ1</h2>
		<p><a href="#content" id="smooth-scroll" class="w3-btn w3-theme-l5 w3-padding-large w3-large w3-margin-top w3-hover-theme">Commencer</a></p>
	</div>
</header>
<section id="content" class="w3-padding-32 w3-container w3-theme-l1">
	<div class="w3-content">
		<form class="w3-container">
			<fieldset class="w3-theme-l5">
				<legend class="w3-theme-d5 w3-padding-small w3-xlarge">Paramètres du crowdfunding</legend>
				<p class="field">
					<label for="pubkey">Pubkey&nbsp;:</label>
					<input id="pubkey" name="pubkey" type="text" class="w3-input w3-border w3-animate-input" required placeholder="27b1j7BPssdjbXmGNMYU2JJrRotqrZMruu5p5AWowUEy" pattern="^[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{43,44}$" />
				</p>
				<p class="field">
					<label for="target">Montant cible à atteindre&nbsp;:</label>
					<input id="target" name="target" type="number" class="w3-input w3-border" required placeholder="1000" min="0" />
				</p>
				<p class="field">
					<label for="unit">Unité&nbsp;:</label>
					<select id="unit" name="unit" class="w3-select w3-border">
						<option value="quantitative">quantitatif (G1)</option>
						<option value="relative" selected>relatif (DU)</option>
					</select>
				</p>
				
				<p class="field">
					<label for="period">Période de financement&nbsp;:</label>
					<select id="period" name="period" class="w3-select w3-border">
						<option value="current-monh" selected>Mois courant</option>
						<option value="one-date">A partir d'une date</option>
						<option value="two-dates">Entre deux dates</option>
					</select>
				</p>
				<p id="p-start_date" class="field w3-hide">
					<label for="start_date">Date de début&nbsp;:</label>
					<input id="start_date" name="start_date" type="date" class="w3-input w3-border" />
				</p>
				<p id="p-end_date" class="field w3-hide">
					<label for="end_date">Date de fin&nbsp;:</label>
					<input id="end_date" name="end_date" type="date" class="w3-input w3-border" />
				</p>
			</fieldset>
			
			
			
			<fieldset class="w3-theme-l5">
				<legend class="w3-theme-d5 w3-padding-small w3-xlarge">
					Options d'affichage
				</legend>
				
				<p class="field">
					<label for="lang">Langue&nbsp;:</label>
					<select id="lang" name="lang" class="w3-select w3-border">
						<option value="fr" selected>français</option>
						<option value="en">anglais</option>
						<option value="eo">esperanto</option>
					</select>
				</p>
				
				<p class="field">
					<label for="title">Titre&nbsp;:</label>
					<input id="title" name="title" type="text" class="w3-input w3-border w3-animate-input" placeholder="Financement participatif en monnaie libre" />
				</p>
				
				<p class="field">
					<label for="theme">Thème&nbsp;:</label>
					<select id="theme" name="theme" class="w3-select w3-border">
						<option value="paidge" selected>Paidge</option>
						<option value="kickstarter">Kickstarter</option>
					</select>
				</p>
				
				<p class="field" id="p-hide_title">
					<label for="hide_title">Masquer le titre&nbsp;:</label>
					<input id="hide_title" name="hide_title" type="checkbox" class="w3-check" />
				</p>
				
				<p class="field" id="p-display_pubkey">
					<label for="display_pubkey">Afficher la clef publique&nbsp;:</label>
					<input id="display_pubkey" name="display_pubkey" type="checkbox" class="w3-check" />
				</p>
				<p class="field" id="p-display_qrcode">
					<label for="display_qrcode">Afficher le QRcode&nbsp;:</label>
					<input id="display_qrcode" name="display_qrcode" type="checkbox" class="w3-check" />
				</p>
				
				<p class="field" id="p-type">
					<label for="type">Type d'intégration&nbsp;:</label>
					<select id="type" name="type" class="w3-select w3-border" required>
						<option value="iframe" selected>Iframe</option>
						<option value="png">Image PNG</option>
						<option value="svg">Image SVG</option>
					</select>
				</p>
				
				<p id="p-display_button" class="field">
					<label for="display_button">Afficher le boutton&nbsp;:</label>
					<input id="display_button" name="display_button" type="checkbox" class="w3-check" />
				</p>
				
				<p id="p-logo" class="field w3-hide">
					<label for="logo">Logo&nbsp;:</label>
					<select id="logo" name="logo" class="w3-select w3-border">
						<option value="no-logo" selected>Aucun</option>
						<option value="cesium">Cesium</option>
						<option value="duniter">Duniter</option>
						<option value="dunitrust">Dunitrust</option>
						<option value="junes">pièce de Geconomicus</option>
						<option value="sakia">Sakia</option>
						<option value="silkaj">Silkaj</option>
					</select>
				</p>
				
				<p class="field" id="p-background_color">
					<label for="background_color">Arrière-plan&nbsp;:</label>
					<input id="background_color" name="background_color" type="color" value="#ffffff" />
				</p>
				<p class="field" id="p-font_color">
					<label for="font_color">Texte&nbsp;:</label>
					<input id="font_color" name="font_color" type="color" value="#212529" />
				</p>
				<p class="field" id="p-progress_color">
					<label for="progress_color">Barre de progression&nbsp;:</label>
					<input id="progress_color" name="progress_color" type="color" value="#ffc107" />
				</p>
				<p class="field" id="p-border_color">
					<label for="border_color">Bordures&nbsp;:</label>
					<input id="border_color" name="border_color" type="color" value="#343a40" />
				</p>
				
				<p id="p-display_graph" class="field">
					<label for="display_graph">Afficher le graphique&nbsp;:</label>
					<input id="display_graph" name="display_graph" type="checkbox" class="w3-check" />
				</p>
			</fieldset>
			
			<!--
			<fieldset class="w3-theme-l5">
				<legend class="w3-theme-d5 w3-padding-small w3-xlarge">
					Paramètres avancés
				</legend>
				
				<p class="field">
					<label for="node">Nœud duniter&nbsp;:</label>
					<input id="node" name="node" type="text" class="w3-input w3-border w3-animate-input" placeholder="g1.duniter.org" pattern="^([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,6}$" />
				</p>
			</fieldset>
			-->
			
			<div class="w3-center">
				<button id="submit" class="w3-btn w3-theme-l5 w3-padding-large w3-large w3-margin-top w3-hover-theme">
					Générer
				</button>
			</div>
		</form>
	</div>
</section>
<section id="display_result" class="w3-padding-32 w3-container w3-theme-d1">
	<div class="w3-content">
		<h2 id="preview_label" class="w3-hide">
			Prévisualisation :
		</h2>
		
		<div id="preview" class="w3-margin-top w3-center"></div>
		
		<div id="integration-instructions" class="w3-hide">
			
			<h2>Comment l'intégrer</h2>


			<h3>Option n°1&nbsp;: Code HTML</h3>

			<p>Pour intégrer la barre sur un site web ou blog (type Wordpress).</p>

			<textarea id="htm" onclick="select();" onfocus="select();" rows="5" readonly></textarea>

			<div id="htmButton" class="buttons w3-bar w3-center w3-hide">
				<div class="tooltip">
					<button id="copy" class="w3-btn w3-theme-l5 w3-padding-large w3-large w3-margin-top w3-hover-theme" onclick="copyToClipboard('#htm')">
						Copier le code HTML
					</button>

					<span class="tooltiptext">Copié !</span>
				</div>
			</div>


			
			
			<h3>Option n°2&nbsp;: Code Markdown</h3>

			<p>Pour l'intégrer&nbsp;:</p>
			
			<ul>
				<li>sur un forum Discourse (forum.monnaie-libre.org, forum.duniter.org),</li>
				<li>un pad CodiMD (FramaPad, P2Pad, etc.)</li>
				<li>un générateur de site statique (type Pelican).</li>
			</ul>
			
			<p>
				Note pour <strong>Discourse&nbsp;: votre image risque de ne pas être mise à jour</strong> car, par défaut, 
				les forums Discourse téléchargent une copie de toutes les images que vous insérez, 
				plutôt que de les afficher de façon dynamique.
			</p>

			<textarea id="markdown" onclick="select();" onfocus="select();" rows="5" readonly></textarea>

			<div id="markdownButton" class="buttons w3-bar w3-center w3-hide">
				<div class="tooltip">
					<button id="copy" class="w3-btn w3-theme-l5 w3-padding-large w3-large w3-margin-top w3-hover-theme" onclick="copyToClipboard('#markdown')">
						Copier le code Markdown
					</button>

					<span class="tooltiptext">Copié !</span>
				</div>
			</div>


			
			<h3>Option n°3&nbsp;: Wikitext</h3>

			<p>Pour l'intégrer sur un wiki type DokuWiki (FramaWiki)</p>
			
			<textarea id="wikitext" onclick="select();" onfocus="select();" rows="5" readonly></textarea>

			<div id="wikitextButton" class="buttons w3-bar w3-center w3-hide">
				<div class="tooltip">
					<button id="copy" class="w3-btn w3-theme-l5 w3-padding-large w3-large w3-margin-top w3-hover-theme" onclick="copyToClipboard('#wikitext')">
						Copier le code Wikitext
					</button>

					<span class="tooltiptext">Copié !</span>
				</div>
			</div>



			<h3>Option n°4&nbsp;: BBCode</h3>

			<p>Pour l'intégrer sur un forum type phpBB</p>
			
			<textarea id="bbcode" onclick="select();" onfocus="select();" rows="5" readonly></textarea>

			<div id="bbcodeButton" class="buttons w3-bar w3-center w3-hide">
				<div class="tooltip">
					<button id="copy" class="w3-btn w3-theme-l5 w3-padding-large w3-large w3-margin-top w3-hover-theme" onclick="copyToClipboard('#bbcode')">
						Copier le BBCode
					</button>

					<span class="tooltiptext">Copié !</span>
				</div>
			</div>
			
		</div>

	</div>
</section>
	
	
<div id="back-to-top" class="w3-hover-theme">
	<i class="fa fa-angle-double-up" aria-hidden="true"></i>
</div>
	
	
<footer class="w3-container w3-padding-16 w3-center w3-theme-d5">
	<p>
		Code source disponible sur 
		
		<a href="https://git.duniter.org" target="_blank">
			le Gitlab Duniter
		</a>
	</p>
	
	<p>
		Développé par 
		
		<a href="https://g1.duniter.fr/#/app/wot/27b1j7BPssdjbXmGNMYU2JJrRotqrZMruu5p5AWowUEy/" target="_blank">
			Paidge
		</a>
	</p>
	
	<div class="w3-xlarge">
		<a href="https://www.facebook.com/pjchancellier" target="_blank"><i class="fab fa-facebook-f w3-margin-right"></i></a>
		<a href="https://diaspora.normandie-libre.fr/people/97f6cd801bcf01365ebe002564b8841f" target="_blank"><i class="fab fa-diaspora w3-margin-right"></i></a>
		<a href="https://www.youtube.com/watch?v=SjoYIz_3JLI&list=PLmKEBjWrttOu93a92v62EWnjcs_fX6I7C" target="_blank"><i class="fab fa-youtube w3-margin-right"></i></a>
		<a href="https://normandie-libre.fr" target="_blank"><i class="fas fa-globe"></i></a>
	</div>
</footer>
	
	
<script>
</script>
<script src="lib/js/jquery-3.4.1.min.js"></script>
<script src="lib/js/generate.js"></script>
<script>
function copyToClipboard(element) {
	$(element).select();
	document.execCommand("copy");
	$('.tooltip').addClass('tooltip_display');
	setTimeout(function(){$('.tooltip').removeClass('tooltip_display');}, 600)
}
</script>
</body>
</html>
