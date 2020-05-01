<?php

$pageTitle = _("Rançon");
$pageDescription = _("");
$bodyIds = 'f-alt-1';

include('cesiumDownloads.php');

include('head.php');

// Documentation :
// 
// https://packagist.org/packages/geoip2/geoip2
// 
require_once 'vendor/autoload.php';
use GeoIp2\Database\Reader;
$reader = new Reader('vendor/GeoLite2-Country/GeoLite2-Country.mmdb');
$record = $reader->country(getUserIpAddress());
$countryIsoCode = $record->country->isoCode;
$countryName = $record->country->name;


function formatCountryName ($country, $lang)
{
	if ($lang == 'fr')
	{
		switch ($country) {
			
			case 'France':
				return 'en France';
			case 'United States':
				return 'aux États-Unis';
			case 'Spain':
				return 'en Espagne';
			case 'Canada':
				return 'au Canada';
			default:
				return $country;
		}
	}
	
	else
	{
		return $country;	
	}
	
}
?>

<article>
	<h1><?php echo _("P4g3 h4ckÉe paR |\/|0Xi/\-|\/|437"); ?></h1>
	
	<section class="text-box">
		<?php
		
		
		$target = FUNDING_TARGET * 5;
		
		
		
		if (!empty($subpage)) {
			echo '
			<p>
				Votre téléchargement de Cesium a dû avoir lieu.
			</p>
			<p>
				Si ce n\'est pas le cas, <a href="'. $cesiumDownloads[substr($subpage, 1)]['url'] .'">cliquez ici</a>.
			</p>

			<p>
				Bon, maintenant que c\'est fait, <strong>parlons sérieusement</strong> : 
			</p>';
		}
		?>
		
		<p>
			On s'appelle Moixa-Maet et on vient de hacker cette page.
		</p>
		
		<p>
			Vous ne nous connaissez peut-être pas, mais nous, on sait qui vous êtes.
		</p>
		
		<p>On connaît beaucoup de choses à votre sujet...</p>
		
		<p>Par exemple, on sait que :</p>
		
		<ul>
			<li>vous parlez <?php echo getLangName(LANG); ?></li>
			<li>vous habitez <?php echo formatCountryName($countryName, LANG); ?></li>
			<li>vous aimez la Ğ1</li>
		</ul>
		
		<p>
			(ok, c'est peut-être pas grand chose, mais on débute dans le piratage, alors un peu d'indulgence s'il-vous-plaît)
		</p>
		
		<p>
			La raison pour laquelle nous avons pris le contrôle de cette page, c'est pour vous demander le paiement d'une rançon.
		</p>
		
		<p>
			En effet, la branche armée de Moixa-Maet a défié le confinement et s'est rendue en Mayenne pour kidnapper le principal développeur de Cesium. 
		</p>
		
		<p>
			Autant vous dire qu'on a pris en otage les prochaines versions de votre logiciel préféré.
		</p>
		
		<p>
			Nous ne libérerons Benoît qu'à condition que soit réunie la somme de <?php echo $target; ?> DU<sub>Ğ1</sub>.
		</p>
		
		<p>
			Si ce montant n'est pas atteint sous 3 jours, nous noierons  Benoît dans une baignoire remplie de monnaie-dette, 
			et les prochaines versions de Cesium ne verront jamais le jour.
		</p>
		
		<?php
		
		include('inc/Crowdfunding.class.php');
		$startDate = date('Y-m-d', (time() - (30*24*3600)));
		
		$cfDuniter = new Crowdfunding(FUNDING_PUBKEY, 'relative', $startDate);
		
		$buttonLabel = _("Payer la rançon");
		
		$totalCollected = round($cfDuniter->getAmountCollected());
		$portionReached = round($totalCollected / $target * 100);
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
				Pour l\'instant, seulement 
				<strong>'. $portionReached .'%</strong>
				<span>de la rançon demandée est payée.</span>
			</p>
		</aside>
		';
		
		?>
		
		<div id="supportButtonContainer">
			<button id="supportButton">
				<?php echo $buttonLabel; ?>
			</button>
		</div>

		<div id="pubkey-and-copy-button">
			<p class="pubkey">
				Payez la rançon. Copiez la clef suivante&nbsp;:

				<input id="pubkey" type="text" value="<?php echo FUNDING_PUBKEY; ?>" size="8" />...
			</p>

			<p>
				<button id="copyButton">
					Copier la clef
				</button>
			</p>

			<div id="successMsg">
				<p>Clef copiée dans le presse-papier ! Collez-la maintenant dans l'annuaire Cesium afin de payer la rançon.</p>
				<p style="text-align: center;">Ne contactez pas la police</p>
			</div>
		</div>
	
		<footer>
			<p>
				PS : poisson 🐟 d'avril 😉
			</p>
		</footer>
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
