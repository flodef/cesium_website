<?php
textdomain('jobs');

$pageTitle = _("Rejoignez l'équipe");
$pageDescription = _("");

include('head.php');

?>


<article id="jobs">
	<h1><?php echo _("Rejoignez l'équipe !"); ?></h1>
	
	<section class="text-box">
		<p>
			Vous êtes développeur ?
		</p>
		
		<p>
			Rejoignez-nous !
		</p>

		<p>
			Cesium est une application open-source développée en AngularJS.
		</p>

		<p>
			Les version 1.x de Cesium utilisent AngularJS 1.x tandis que Cesium v2 est en train d'être developée en utilisant Angular 2.x
		</p>

		<p>
			Vous pouvez d'ores et déjà installer Cesium depuis les sources, et suivre les 
			<a href="https://git.duniter.org/clients/cesium-grp/cesium/blob/master/doc/development_guide.md">documentations techniques</a>
			pour vous aider à mieux comprendre le code et y contribuer:
		</p>
		
		<p class="CTA-button">
			<a href="https://git.duniter.org/clients/cesium-grp/cesium">
				Voir le GitLab de Cesium
			</a>
		</p>
		
		<p>
			N'hésitez pas à vous présenter à notre équipe de développeurs en postant une petite présentation dans 
			<a href="https://forum.duniter.org/c/presentations">la catégorie "Présentations"</a> du forum Duniter. 
		</p>
	
	</section>
</article>

<?php


include('foot.php');
