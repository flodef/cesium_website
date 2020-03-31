<?php

$pageTitle = _("Encouragez-nous !");
$pageDescription = _("");

include('cesiumDownloads.php');

include('head.php');

?>


<article id="funding">
	<h1><?php echo _("Encouragez-nous !"); ?></h1>
	
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
			Vous rêvez d'un système monétaire plus juste&nbsp;?
		</p>
		
		<p>
			Nous aussi.
		</p>
		
		<p>
			L'ennui ? 
		</p>
		
		<p>
			L'adoption de la Ğ1 est lente.
		</p>
		
		<p>
			Cela tient à plusieurs choses, et l'une d'entre elles, c'est que le temps que les développeurs 
			peuvent allouer au développement est limité.
		</p>
		
		<p>
			Il n'y a malheureusement que 24 heures dans une journée :-(
		</p>
		
		<p>
			Mais vous avez le pouvoir de contribuer à faire du rêve que nous partageons une réalité.
		</p>
		
		<p>
			Comment&nbsp;?
		</p>
		
		<p>
			Tout simplement en finançant développeurs.
		</p>
		
		<p>
			Il existe des caisses de côtisations qui permettent à la communauté Ğ1 de valoriser, en Ğ1, 
			les contributions que les développeurs apportent à l'écosystème logiciel de la Ğ1.
		</p>
		
		<p>
			Chaque mois, une vingtaine de contributeurs se voient gratifiés de 15 DU<sub>Ğ1</sub> pour leurs travaux sur Cesium, Silkaj, Sakia, Duniter, etc...
		</p>
		
		<p>
			Ces rémunérations sont faites en toute transparence ; et vous pouvez les retrouver sur le site et le forum de Duniter, ainsi que dans la blockchain.
		</p>
		
		<p>
			Nous aimerions augmenter progressivement la rémunération des développeurs 
			jusqu'à atteindre des montants qui permettent à quelques développeurs 
			d'allouer à la Ğ1 davantage de leur temps.
		</p>
		
		<p>
			Ce mois-ci, nous aimerions donc atteindre la somme de <?php echo FUNDING_TARGET; ?> DU<sub>Ğ1</sub>. 
			Voilà où nous en sommes par rapport à cet objectif&nbsp;:
		</p>

		
		<?php
		include('inc/Crowdfunding.class.php');
		$startDate = date('Y-m-d', (time() - (30*24*3600)));
		
		$cfDuniter = new Crowdfunding(FUNDING_PUBKEY, 'relative', $startDate);
		
		/*
		$donationsList = $cfDuniter->getDonationsList();
		$min = $cfDuniter->getMinDonation();
		$max = $cfDuniter->getMaxDonation();
		*/
			
		$totalCollected = round($cfDuniter->getAmountCollected());
		$portionReached = round($totalCollected / FUNDING_TARGET * 100);
		$totalDonorsNb = $cfDuniter->getDonorsNb();
		
		
		echo '
		<aside class="crowdfunding-widget">
			<!--
			<meter min="0" max="100" value="'. $portionReached .'" high="75" low="25" class="progress-meter">
				'. $portionReached .'%
			</meter>
			-->
			<!--
			<div class="progress-container">
				<div class="progress-bar" 
					 aria-valuenow="'. max($portionReached, 100) .'"
					 aria-valuemin="0" 
					 aria-valuemax="100" 
					 style="width:0%;">

					<span class="sr-only">
						'. $portionReached . '%
					</span>

				</div>
			</div>
			-->
			
			<p>
				<strong>'. $portionReached .'%</strong>
				<span>du montant souhaité est atteint</span>
			</p>

			<p>
				<strong>'. $totalCollected . ' DU<sub>Ğ1</sub></strong>
				<span>ont déjà été donnés, sur un total de '. FUNDING_TARGET .' DU<sub>Ğ1</sub></span>
			</p>

			<p>
				<span>grâce à </span>
				<strong>'. $totalDonorsNb . '</strong>
				<span>donateurs</span>
			</p>
		</aside>
		';
		
		?>
		
		
		<p>
			Si vous souhaitez soutenir la Ğ1, c'est simple : 
		</p>

		<div id="pubkey-and-copy-button">
			<p class="pubkey">
				Copiez la clef suivante dans votre presse-papier&nbsp;: 

				<input id="pubkey" type="text" value="<?php echo FUNDING_PUBKEY; ?>" />
				
				en cliquant sur le bouton ci-dessous&nbsp;:
			</p>

			<p class="CTA-button">
				<button id="copyButton">
					Copier la clef
				</button>
			</p>

			<div id="successMsg">
				<p>Et maintenant collez-la dans l'annuaire Cesium afin de faire votre don 😉</p>
				<p style="text-align: center;">Merci pour votre générosité ❤️</p>
			</div>
		</div>
		
		<?php
		/*
		echo '
		<p>
			Nous remercions chaleureusement tous les junistes qui ont fait un don ce mois-ci&nbsp;:
		</p>';
		
		
		if (empty($donationsList)) {

			echo _('Pas encore de donateurs');

		} else {
			
			echo '<ul class="donorsList">';

			foreach ($donationsList as $t) {

				echo '

				<li style="font-size: '.  (1 + ($t['amount'] / $max) * 2) . 'em;">
				
					<span>'. $t['name'] .'</span>
					
				</li>';
			}

			echo '</ul>';
		}
		*/
		?>
	
	</section>
</article>


<script>
function copy() {
	
	var copyText = document.querySelector("#pubkey");
	copyText.select();
	document.execCommand("copy");

	var successMsg = document.querySelector("#successMsg");
	successMsg.style.opacity = "1";
	/*successMsg.style.height = "3em";*/

	var copyButton = document.querySelector("#copyButton");
	copyButton.style.animation = "none";
	
}

function support() {
	
	var pubkeyAndCopyButton = document.querySelector("#pubkey-and-copy-button");
	var supportButtonContainer = document.querySelector("#supportButtonContainer");
	supportButtonContainer.style.opacity = "0";
	supportButtonContainer.style.height = "0";
	pubkeyAndCopyButton.style.height = "100%";
	pubkeyAndCopyButton.style.opacity = "1";
	
	var supportButton = document.querySelector("#supportButton");
	$(this).style.animation = "none";
}

document.querySelector("#copyButton").addEventListener("click", copy);
document.querySelector("#supportButton").addEventListener("click", support);
</script>