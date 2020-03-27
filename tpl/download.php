<?php

textdomain('download');

$pageTitle = _('Télécharger et installer');
$pageDescription = _("Site officiel de Cesium. Télécharger la dernière version pour Linux, Windows, Mac, Android et iPhone.");

include('cesiumDownloads.php');

include('head.php');

?>


<div id="wrap" class="oe_structure oe_empty">
	<h1>
		<?php echo _("Télécharger Cesium"); ?>
	</h1>

	<section id="download">
		<?php 

		foreach ($cesiumDownloads as $k => $d) {
			
			$href = $d['url'];
			$onclick = 'window.open(\''. $d['url'] .'\');window.location.assign(\''. parseURI(_('/merci').'/'.$k) .'\');return false;';
			
			echo '
				<section>
					<a href="'. $href .'" onclick="'. $onclick .'">
						<img class="card-img-top" src="'. $rootURL . '/img/download/'. $d['img'] .'" alt="Logo '. $d['title'] .'" />
					</a>

					<h3>
						'. $d['title'] .'
					</h3>

					<p>
						'. $d['desc'] .'
					</p>

					<p class="CTA-button">
						<a href="'. $href .'" onclick="'. $onclick .'">
							'. _('Télécharger') .'
						</a>
					</p>

					<p>
						'. $d['extra'] .'
					</p>
				</section>';
		}
		?>
	</section>
</div>

<?php

include('foot.php');
