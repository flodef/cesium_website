<?php

include('cesiumVersions.php');

define('FUNDING_PUBKEY', 'CitdnuQgZ45tNFCagay7Wh12gwwHM8VLej1sWmfHWnQX');
define('FUNDING_TARGET', '100');

$legalNotice = 
	[
		'editor' => 'Axiom-Team', 
		'publisher' => 'Axiom-Team', 
		'host' => 'P2Legal'
	];



/* ====== i18n ====== */

$availableLanguages = 
	[
	 'fr',
	 'en',
	 'es',
	 'va'
	];

define('DEFAULT_LANG', 'fr'); 

include('inc/lang.php');

$textDomains = 
	[
	 'menu', 
	 'home', 
	 'features', 
	 'download', 
	 'tuto'
	];

bindTextDomains($textDomains);

/* ====== /i18n ====== */




// Trouver une façon de définir $rootURL sans faire ça :

if ($_SERVER['SERVER_NAME'] == 'localhost') {
	
	$rootURL = '/www/cesium-website';
	
} else {
	
	$rootURL = '/cesium/cesium.app';
	
}

include('inc/functions.php');

include('inc/display.php');


define('MOD_REWRITE', 'on');
define('FUNDING_ALT', false); 
