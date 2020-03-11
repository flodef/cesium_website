<?php
$bodyIds = 'home';

$pageTitle = _('Cesium Ğ1 - Site officiel');
$pageDescription = _("Cesium est l'application la plus intuitive pour gérer votre portefeuille en monnaie-libre Ğ1.");

include('head.php');

textdomain('home');

?>

<section id="showcase">
	<div>
		<figure id="home-app-screenshot">
			<img src="<?php echo $rootURL . '/i18n/' . LANG_FOLDER . '/contents' . _('/accueil') . _('/Cesium-G1-maquette.png'); ?>" 
				 alt="capture d'écran de Cesium" />
		</figure>

		<h2 id="USP">
			<?php echo _("Recevez et envoyez <br />de la monnaie libre Ğ1"); ?>
		</h2>

		<p class="CTA-button">
			<a href="<?php echo parseURI(_("/telechargement")); ?>">
				<?php printf(_("Télécharger Cesium %s"), $cesiumVersions['home']); ?>
			</a>
		</p>


		<p id="licence">
			<?php printf(_('Logiciel libre sous licence %s'), 'GNU AGPL-3.0'); ?>
		</p>

		<aside>
			<?php printf(_('Développeur ?')); ?>
			<a href="<?php echo parseURI(_("/developpeurs")); ?>">
				<?php echo _('Rejoignez-nous !'); ?>
			</a>
		</aside>
	</div>
</section>


<section class="features-list" id="features-list-1">
	<div>
		<h2>
			<?php echo _('Cesium : la solution simple<br />pour échanger en monnaie libre'); ?>
		</h2>
		
		<dl>
			<dt>
				<?php echo _('Sécurisé'); ?>
			</dt>

			<dd>
				<?php echo _('Cesium signe numériquement vos transactions avant de les transmettre à la blockchain de Duniter.'); ?>
			</dd>

			<dt>
				<?php echo _('Offert'); ?>
			</dt>

			<dd>
				<?php echo _("Parce qu'il est codé avec amour par une communauté de gens " . 
							 "qui croient aux monnaies libres en général (et à la Ğ1 en particulier), " . 
							 "Cesium vous est offert sans exiger de contre-partie. "); ?>
			</dd>

			<dt>
				<?php echo _('Libre'); ?>
			</dt>

			<dd>
				<?php 
				print _('Cesium est un logiciel libre.');
				
				printf(_('Vous êtes donc libre d\'en consulter le code source (sur <a href="%s">GitLab</a>), ' . 
				          'et d\'adapter Cesium à vos besoins pour, par exemple, lancer votre propre monnaie libre.'
						), 
						"https://git.duniter.org/clients/cesium-grp/cesium"); ?>
			</dd>
		</dl>
	</div>
</section>

<section id="steps">
	<div>
		<h2>
			<?php echo _('Plus que quelques pas<br />avant de recevoir vos premières Ğ1'); ?>
		</h2>

		<figure>
			<a href="<?php echo parseURI(_("/telechargement")); ?>">
				<img src="<?php echo $rootURL; ?>/img/home/telecharger-cesium-full.png" alt="Télécharger Cesium" />
			</a>

			<figcaption>
				<h3>1. <?php echo _('Téléchargez Cesium'); ?></h3>

				<p>
					<?php 
						printf(_('Rendez-vous sur <a href="%s">la page Téléchargement</a> pour récupérer le ' . 
								 'fichier qui convient à votre système d\'exploitation.'
								), parseURI(_("/telechargement"))
							  );
					?>
				</p>
			</figcaption>
		</figure>

		<figure>
			<img src="<?php echo $rootURL; ?>/img/home/creer-un-compte-simple-portefeuille.png" alt="Créer un compte simple portefeuille" />

			<figcaption>
				<h3>2. <?php echo _('Créez un compte'); ?></h3>

				<p>
					<?php echo _('Sur l\'accueil, cliquez sur "Créer un compte", puis "Commencer" et "Simple portefeuille".'); ?>
				</p>

				<p>
					<?php echo _('Choisissez un identifiant secret et un mot de passe tout aussi secret.'); ?>
					<?php echo _('Mémorisez-les bien car il ne sera pas possible de les retrouver ensuite.'); ?>
				</p>
			</figcaption>
		</figure>

		<figure>
			<img src="<?php echo $rootURL; ?>/img/home/clef-publique.png" alt="Copier sa clef publique" />

			<figcaption>
				<h3>3. <?php echo _('Recevez des paiements'); ?></h3>

				<p>
					<?php echo _('Cliquez sur votre clef publique, copiez-la et transmettez-la à ' . 
								 'la personne qui souhaite vous faire un virement en Ğ1.');?>
				</p>
			</figcaption>
		</figure>
	</div>
</section>

<?php

$reviewsPath = './i18n/' . LANG_FOLDER . '/contents' . _('/accueil') . _('/avis') . '/';

if (file_exists($reviewsPath) AND ($reviewsFiles = scandir($reviewsPath)) AND count($reviewsFiles)-2 > 0)
{
	echo '

	<section id="reviews">
		<h2>'. _('Ce qu\'elles et ils en pensent') .'</h2>';

		foreach ($reviewsFiles as $rf)
		{
			if ($rf != '.' AND $rf != '..')
			{
				echo '
				<blockquote>
					<div>';

					readfile($reviewsPath . $rf);

					echo '
					</div>
				</blockquote>';
			}

		}

		echo '
	</section>';	
}

?>


<section id="gallery">
	<h2>
		<?php echo _('Cesium partout'); ?>
	</h2>

	<div>
		<figure id="bar">
			<span>
				<img src="<?php echo $rootURL;?>/img/home/pros-bar.jpg" />
			</span>
		</figure>

		<figure id="djoliba">
			<span>
				<img src="<?php echo $rootURL;?>/img/home/djoliba-630p-50-pcts.jpeg" />
			</span>
		</figure>

		<figure id="boat">
			<span>
				<img src="<?php echo $rootURL;?>/img/home/Voilier-June-cropped-50-pcts.jpeg" />
			</span>
		</figure>

		<figure id="vietnam">
			<span>
				<img src="<?php echo $rootURL;?>/img/home/cesium-vietnam-1200-50-pcts.jpg" />
			</span>
		</figure>
	</div>
</section>


<?php

include('foot.php');
