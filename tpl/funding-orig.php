<?php
textdomain('funding');

$pageTitle = _("Coucou");
$pageDescription = _("");

include('cesiumDownloads.php');

include('head.php');

?>


<article id="funding">
	<h1><?php echo _("Coucou"); ?></h1>
	
	<section class="text-box">
		<?php
		if (!empty($subpage)) {
			
			echo '
			<p>
				'. _('Votre téléchargement de Cesium doit être en cours.') . '
			</p>

			<p>
				'. sprintf(_('Si ce n\'est pas le cas, <a href="%s">cliquez ici</a>.'), $cesiumDownloads[substr($subpage, 1)]['url']) .'
			</p>
		
			<p>
				'. _('On profite de ce moment d\'attente pour vous dire un truc&nbsp;:') .'
			</p>';
			
		}
		?>
		
		<p>
			Nous sommes Axiom-Team et nous œuvrons à la promotion de la monnaie libre Ğ1. 
		</p>
		
		<p>
			On prend la parole ici parce qu'on voulait vous informer de la chose suivante&nbsp;:
		</p>
		
		<p>
			Il existe une caisse de côtisations qui permet à la communauté de valoriser (en monnaie libre) 
			la contribution que les développeurs de Cesium apportent au développement de la Ğ1.
		</p>
		
		<p>
			L'objectif est de réunir sur cette caisse la somme de <?php echo FUNDING_TARGET; ?> DU<sub>Ğ1</sub> sur 30 jours glissant.
		</p>
		
		<p>
			Voilà où nous en sommes aujourd'hui ce mois-ci par rapport à cet objectif&nbsp;:
		</p>

		
		<?php
		include('inc/Funding.class.php');
		$startDate = date('d/m/Y', (time() - (30*24*3600)));
		$target = 100;
		$funding = new Funding(FUNDING_PUBKEY, $target, $startDate, 'relative');
		
		echo '
		<aside class="crowdfunding-widget">
			<meter min="0" max="100" value="'. $funding->getPercentage() .'" high="75" low="25" class="progress-bar">
				'. $funding->getPercentage() .'%
			</meter>
			
			<p>
				<strong>'. $funding->getPercentage() .'%</strong>
				<span>du montant souhaité est atteint</span>
			</p>

			<p>
				<strong>'. $funding->getAmountDonated() . ' DU<sub>Ğ1</sub></strong>
				<span>ont déjà donnés, sur un total de '. $target .' DU<sub>Ğ1</sub></span>
			</p>

			<p>
				<span>grâce à </span>
				<strong>'. $funding->getDonorsNb() . '</strong>
				<span>donateurs</span>
			</p>
		</aside>
		';
		
		?>
		
		
		<p>
			Si vous souhaitez soutenir le projet Cesium, c'est simple : 
		</p>

		<div id="pubkey-and-copy-button">
			<p class="pubkey">
				Copiez la clef suivante : 

				<input id="pubkey" type="text" value="<?php echo FUNDING_PUBKEY; ?>" size="8" />... 
				
				dans votre presse-papier en cliquant sur le bouton ci-dessous :
			</p>

			<p class="CTA-button">
				<button id="copyButton">
					Copier la clef
				</button>
			</p>

			<div id="successMsg">
				<p>Et maintenant collez-la dans Cesium afin de faire votre don 😉</p>
				<p style="text-align: center;">Merci pour votre générosité ❤️</p>
				<p style="text-align: right;">Axiom-Team</p>
			</div>
		</div>
	
	</section>
</article>