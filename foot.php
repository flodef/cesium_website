			</main>

			<footer>
				<div>
					<nav id="sitemap">
						<h5>
							<?php echo dgettext('menu', 'Plan du site'); ?>
						</h5>

						<ul>
							<li>
								<a href="<?php echo parseURI('/'); ?>">
									<?php echo dgettext('menu', 'Accueil'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo parseURI(dgettext('menu', '/fonctionnalites')); ?>">
									<?php echo dgettext('menu', 'Fonctionnalités'); ?>
								</a>
							</li>
							<li>
								<a href="<?php echo parseURI(dgettext('menu', '/telechargement')); ?>">
									<?php echo dgettext('menu', 'Téléchargement'); ?>
								</a>
							</li>
							<li>
								<a href="https://forum.duniter.org/c/support/cesium">
									<?php echo dgettext('menu', 'Support'); ?>
								</a>
							</li>
						</ul>
					</nav>

					<nav id="developper-links">
						<h5>
							<?php echo dgettext('menu', 'Développeur ? Rejoignez-nous !');?>
						</h5>

						<ul>
							<li>
								<a href="https://forum.duniter.org/c/support/cesium">
									<?php echo dgettext('menu', 'Forum Cesium'); ?>
								</a>
							</li>
							<li>
								<a href="https://forum.duniter.org/c/presentations">
									<?php echo dgettext('menu', 'Venez faire connaissance'); ?>
								</a>
							</li>
							<li>
								<a href="https://git.duniter.org/clients/cesium-grp/cesium">
									<?php echo dgettext('menu', 'Forge GitLab de Cesium'); ?>
								</a>
							</li>
							<li>
								<a href="https://git.duniter.org/clients/cesium-grp/cesium/blob/master/doc/development_guide.md">
									<?php echo dgettext('menu', 'Guide du développement Cesium'); ?>
								</a>
							</li>
							<li>
								<span>&#99;&#111;&#110;&#116;&#97;&#99;&#116;&#64;&#100;&#117;&#110;&#105;&#116;&#101;&#114;&#46;&#111;&#114;&#103;</span>
							</li>
						</ul>
					</nav>

					<section id="about">
						<h5><?php echo ('Qui sommes-nous ?'); ?></h5>

						<p>
							Ce site est édité par Axiom-Team, qui est une équipe de techniciens, graphistes et designers 
							ayant pour but la promotion des Monnaies Libres, des outils qui s'y rapportent, 
							et le soutien des développeurs qui créent ces derniers.
						</p>

						<p>
							<a href="<?php echo $rootURL . dgettext('menu', '/mentions-legales'); ?>">Mentions légales</a>
						</p>
					</section>

					<nav id="langSelector">
						<h5><?php echo dgettext('menu', 'Choix de langue'); ?></h5>

						<ul>
							<?php 

							textdomain('menu');

							foreach ($availableLanguages as $thisLangIsoCode => $thisLang)
							{
								/* To have links translated */
								putenv('LC_ALL='. $thisLang['localeCode']);
								setlocale(LC_ALL, $thisLang['localeCode']);

								echo '
								<li>';
								
									if ($thisLangIsoCode == LANG) {

										echo '
										<strong>
											<span>
												' . $thisLangIsoCode . '
											</span>
											<span>
												' . $thisLang['name'] . '
											</span>
										</strong>';

									} else {
										
										echo '
										<a href="'. $rootURL .'/'. $thisLangIsoCode . dgettext('menu', $pagePermalink) .'">
												<span>
													' . $thisLangIsoCode . '
												</span>
												<span>
													' . $thisLang['name'] . '
												</span>
										</a>';
										
									}
									
									echo '
								</li>';
							}
							
							putenv('LC_ALL='. LANG_FOLDER);
							setlocale(LC_ALL, LOCALE_CODE);
							?>
						</ul>
					</nav>
				</div>
			</footer>
	
	<script src="<?php echo $rootURL;?>/lib/scripts.js"></script>
<!-- Matomo Image Tracker-->
<img src="https://piwik.p2p.legal/matomo.php?idsite=3&amp;rec=1" style="border:0" alt="" />
<!-- Matomo JS-->
<script type="text/javascript">
  var _paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//piwik.p2p.legal/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '3']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
</body>

</html>

