<?php


$cesiumDownloads = 
[
	'android' => [
		'title' => 'Android', 
		'url' => 'https://play.google.com/store/apps/details?id=fr.duniter.cesium', 
		'img' => 'android.svg', 
		'desc' => _('Disponible directement sur le Play Store'), 
		'extra' => sprintf(_('(ou <a href="%s">télécharger le fichier .apk</a>)'), 'https://github.com/duniter/cesium/releases/download/v'. $cesiumVersions['android'] .'/cesium-v'. $cesiumVersions['android'] .'-android.apk')
	], 
	'iphone' => [
		'title' => 'iPhone', 
		'url' => 'https://apps.apple.com/app/cesium-%C4%9F1/id1471028018', 
		'img' => 'apple.svg', 
		'desc' => _('Disponible sur l\'App Store'), 
		'extra' => ''
	], 
	'debian' => [
		'title' => 'Debian (et dérivés)', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-desktop-v%s-linux-x64.deb', $cesiumVersions['linux'], $cesiumVersions['linux']), 
		'img' => 'debian.svg', 
		'desc' => _('Paquet .deb pour Debian ou Ubuntu'), 
		'extra' => _('En cas de problème&nbsp;:') . '<br /><code>sudo apt-get install -y libgconf-2-4</code>'
	],
		'arch' => [
		'title' => 'Arch Linux (et dérivés)', 
		'url' => sprintf('https://aur.archlinux.org/packages/cesium-desktop-deb'), 
		'img' => 'arch.svg', 
		'desc' => _('A installer via AUR'), 
		'extra' => _('<code>yaourt -S cesium-desktop-deb</code>')
	], 
	'windows' => [
		'title' => 'Windows', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-desktop-v%s-windows-x64.exe', $cesiumVersions['windows'], $cesiumVersions['windows']), 
		'img' => 'windows.svg', 
		'desc' => _('Installateur .exe pour Windows'), 
		'extra' => _('Lancez le .exe et suivez les instructions à l\'écran')
	], 
	'mac' => [
		'title' => 'Mac', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-v%s-web.zip', $cesiumVersions['mac'], $cesiumVersions['mac']), 
		'img' => 'apple.svg', 
		'desc' => _('Version web fonctionnant sous Mac'), 
		'extra' => _('Décompressez le fichier .zip et ouvrez le fichier index.html')
	], 
	'Firefox_Add-on' => [
		'title' => _('Firefox Add-on'), 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-v%s-extension-firefox.xpi', $cesiumVersions['firefox'], $cesiumVersions['firefox']), 
		'img' => 'firefox2019.png', 
		'desc' => _('Expérimental Firefox Add-on'), 
		'extra' => ''
	], 
	'web' => [
		'title' => 'Web', 
		'url' => sprintf('https://github.com/duniter/cesium/releases/download/v%s/cesium-v%s-web.zip', $cesiumVersions['web'], $cesiumVersions['web']), 
		'img' => '1024px-Applications-internet.png', 
		'desc' => _('Pour une installation sur un serveur web'), 
		'extra' => ''
	], 
	'yunohost' => [
		'title' => 'Yunohost', 
		'url' => 'https://github.com/duniter/cesium_ynh', 
		'img' => 'yunohost.svg', 
		'desc' => _('Paquet pour Yunohost'), 
		'extra' => ''
	], 
	'livrables' => [
		'title' => _('Livrables'), 
		'url' => 'https://github.com/duniter/cesium/releases', 
		'img' => 'github.svg', 
		'desc' => _('Toutes versions disponibles sur GitHub'), 
		'extra' => ''
	], 
];

