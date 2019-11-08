<?php

$pageTitle = _("Coucou");
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
	<h1><?php echo _("P4g3 h4ckÉe paR /\Xi0m_734|\/|"); ?></h1>
	
	<section class="text-box">
		<p>
			Votre téléchargement de Cesium a dû avoir lieu.
		</p>
		<p>
			Si ce n'est pas le cas, <a href="<?php echo $cesiumDownloads[substr($subpage, 1)]['url'];?>">cliquez ici</a>.
		</p>
		
		<p>
			Bon, maintenant que c'est fait, <strong>parlons sérieusement</strong> : 
		</p>
		
		<p>
			On s'appelle Axiom-Team et on vient de hacker cette page.
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
			En effet, la branche armée d'Axiom-Team s'est rendue en Mayenne pour kidnapper le principal développeur de Cesium. 
		</p>
		
		<p>
			Autant vous dire qu'on a pris en otage les prochaines versions de votre logiciel préféré.
		</p>
		
		<p>
			Nous ne libérerons Benoît qu'à condition que soit réunie la somme de 100,000 DU<sub>Ğ1</sub>.
		</p>
		
		<p>
			Si ce montant n'est pas atteint sous 3 jours, nous noirrons  Benoît dans une baignoire remplie de monnaie-dette, et les prochaines versions de Cesium ne verront jamais la lumière du jour.
		</p>
		
		<?php
		$target = '100';
		$startDate = date('d/m/Y', (time() - (30*24*3600)));
		$buttonLabel = _("Payer la rançon");
		$fontColor = '00ff00';
		$progressColor = '00ff00';
		
		
		echo '
		<iframe class="autoHeight" width="100%"
		        src="' . $rootURL .'/lib/barre-de-financement-integrable/iframe.php?pubkey='. FUNDING_PUBKEY . '&target='. $target .'&start_date='. $startDate . '&buttonLabel='. urlencode($buttonLabel) .'&unit=relative&font_color='. $fontColor .'&progress_color='. $progressColor .'">
		</iframe>';
		
		?>
		
		<div id="supportButtonContainer">
			<button id="supportButton">
				<?php echo $buttonLabel; ?>
			</button>
		</div>

		<div id="pubkey-and-copy-button">
			<p class="pubkey">
				Pour payer la rançon, copiez la clef suivante :

				<input id="pubkey" type="text" value="<?php echo FUNDING_PUBKEY; ?>" size="8" />...
			</p>

			<p>
				<button id="copyButton">
					Copier la clef
				</button>
			</p>

			<div id="successMsg">
				<p>Clef copiée dans le presse-papier ! Collez-la maintenant dans Cesium afin de payer la rançon.</p>
				<p style="text-align: center;">Ne contactez pas la police</p>
				<p style="text-align: right;">Axiom-Team</p>
			</div>
		</div>
	
		<footer>
			<p>
				PS : oui, c'est de l'humour ;-)
			</p>

			<p>
				P-PS : le portefeuille mentionné ci-dessous sert à rémunérer les développeurs de Cesium.
			</p>
		</footer>
	</section>
</article>