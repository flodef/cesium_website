<?php


$cesiumDownloads = 
[
	'android' => [
		'title' => 'Android', 
		'url' => 'https://play.google.com/store/apps/details?id=fr.duniter.cesium', 
		'img' => 'android.png', 
		'desc' => _('Disponible directement sur le Play Store'), 
		'extra' => sprintf(_('(ou <a href="%s">télécharger le fichier .apk</a>)'), 'https://github.com/duniter/cesium/releases/download/v'. $cesiumVersions['android'] .'/cesium-v'. $cesiumVersions['android'] .'-android.apk')
	], 
	'iphone' => [
		'title' => 'iPhone', 
		'url' => 'https://apps.apple.com/app/cesium-%C4%9F1/id1471028018', 
		'img' => 'apple.png', 
		'desc' => _('Disponible sur l\'App Store'), 
		'extra' => ''
	], 
	'linux' => [
		'title' => 'Linux', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-desktop-v%s-linux-x64.deb', $cesiumVersions['linux'], $cesiumVersions['linux']), 
		'img' => 'tux.png', 
		'desc' => _('Paquet .deb pour Debian ou Ubuntu'), 
		'extra' => _('En cas de problème&nbsp;:') . '<br /><code>sudo apt-get install -y libgconf-2-4</code>'
	], 
	'windows' => [
		'title' => 'Windows', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-desktop-v%s-windows-x64.exe', $cesiumVersions['windows'], $cesiumVersions['windows']), 
		'img' => 'windows.png', 
		'desc' => _('Installateur .exe pour Windows'), 
		'extra' => _('Lancez le .exe et suivez les instructions à l\'écran')
	], 
	'mac' => [
		'title' => 'Mac', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-v%s-web.zip', $cesiumVersions['mac'], $cesiumVersions['mac']), 
		'img' => 'apple.png', 
		'desc' => _('Version web fonctionnant sous Mac'), 
		'extra' => _('Décompressez le fichier .zip et ouvrez le fichier index.html')
	], 
	'yunohost' => [
		'title' => 'Yunohost', 
		'url' => 'https://github.com/duniter/cesium_ynh', 
		'img' => 'yunohost.png', 
		'desc' => _('Paquet pour Yunohost'), 
		'extra' => ''
	], 
	'web' => [
		'title' => 'Web', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-v%s-web.zip', $cesiumVersions['web'], $cesiumVersions['web']), 
		'img' => '1024px-Applications-internet.png', 
		'desc' => _('Pour une installation sur un serveur web'), 
		'extra' => ''
	], 
	'livrables' => [
		'title' => _('Livrables'), 
		'url' => 'https://github.com/duniter/cesium/releases', 
		'img' => '1200px-Octicons-mark-github.png', 
		'desc' => _('Toutes versions disponibles sur GitHub'), 
		'extra' => ''
	]
];

