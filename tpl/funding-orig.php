<?php

$pageTitle = _("Encouragez-nous !");
$pageDescription = _("");

include('cesiumDownloads.php');

include('head.php');

?>


<article id="funding">
	<h1><?php echo _("On a besoin de vous !"); ?></h1>
	
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
				'. _('On profite de ce moment d\'attente pour vous adresser ce petit appel à l\'action&nbsp;:') .'
			</p>';
			
		}
		?>
		
		<h2>On a besoin de vous !</h2>
		
		<p>
			L'adoption de la Ğ1 est lente.
		</p>
		
		<p>
			Cela tient principalement à deux choses&nbsp;:
		</p>

		<ol>
			<li>il est difficile de convertir des gens à la monnaie libre, pour diverses raisons (la monnaie, c'est compliqué, la confiance n'est pas forcément là a prior, etc.)</li>
			<li>les logiciels de l'écosystème (Cesium, Duniter, etc.) doivent encore être améliorés pour garantir l'expansion de la Ğ1 (par exemple en permettant de valider les transactions plus sûrement et rapidement)</li>
		</ol>

		<h2>
			Comment vous pouvez contribuer au développement de la Ğ1
		</h2>
		
		<h3>
			1. En finançant les développeurs en Ğ1
		</h3>
		
		<p>
			La situation actuelle est la suivante&nbsp;:
		</p>

		<p>
			Certains développeurs de la Ğ1 (Eloïs par exemple) ont fait le choix de démissionner 
			de leur emploi pour se concentrer sur le développement de l'écosystème logiciel.  
			D'autres développeurs contribuent sur leur temps libre, les soirs et week-ends.
		</p>

		<p>
			Cette situation ne permet pas un développement très rapide des logiciels 
			car, comme tout un chacun, un développeur n'a que 24&nbsp;h dans une journée.
		</p>

		<p>
			Cependant, il existe des caisses de côtisations qui permettent à la communauté Ğ1 de valoriser, en Ğ1, 
			les contributions que les développeurs apportent à l'écosystème logiciel de la Ğ1.
		</p>
		
		<p>
			Chaque mois, une vingtaine de contributeurs se voient gratifiés d'au moins 15 DU<sub>Ğ1</sub> pour leurs travaux sur Cesium, Silkaj, Sakia, Duniter, etc... Il est donné davantages à certains contributeurs, sur divers critères comme l'impact espéré de leur contribution, ou encore la quantité de travail nécessaire à la production du code.
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
		
		<h3>
			2. En vendant en Ğ1 des biens et services
		</h3>
		
		<p>
			La valeur d'une monnaie tient aux biens et services qui s'échange dans ladite monnaie.
		</p>

		<p>
			Pour valoriser la Ğ1, il faut mettre des biens et services en vente, par exemple sur 
			<a href="https://www.gchange.fr/">ğchange</a>.
		</p>
		
		<p>
			En faisant ça, vous permettez aux développeurs de continuer à développer la Ğ1 de deux façons&nbsp;:
		</p>
		
		<ol>
			<li>
				<strong>directement</strong> si vous vendez un bien ou service à un développeur. À titre d'exemple, Éloïs, 
				qui en 2020 est le développeur principal de Duniter (logiciel crucial car c'est le moteur de la blockchain)
				<a href="https://www.gchange.fr/#/app/market/view/AXIVawVxUm73BnXnuMPx/cherche-logement-a-louer-toute-lanne-en-1-en-occitanie">cherche un logement à louer en Occitanie</a>.
			</li>
			<li>
				<strong>indirectement</strong> (mais c'est tout aussi utile&nbsp;!) si vous vendez à quelqu'un qui ne développe pas la Ğ1, 
				car tout utilisateur de la Ğ1 qui voit qu'il peut acheter des biens et services en Ğ1 sera à son tour motivé à mettre des choses 
				en vente, et cela peut conduire à la mise en vente par certains junistes de biens ou services que les développeurs recherche 
			</li>
		</ol>

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