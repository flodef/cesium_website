<?php

	
require_once('conf.php');
require_once('functions.php');
require_once('Crowdfunding.class.php');
require_once('Color.class.php');
require_once('lib/locales.php');


// =============================== Crowdfunding setting ===============================

$GETs = ['pubkey', 'unit', 'start_date', 'end_date'];

foreach ($GETs as $get) {

	if (!isset($_GET[$get])) {

		$_GET[$get] = NULL;
	}
}

$myCrowdfunding = new Crowdfunding($_GET['pubkey'], $_GET['unit'], $_GET['start_date'], $_GET['end_date'], 'img');


if (isset($_GET['target'])) {

	$myCrowdfunding->setTarget($_GET['target']);
}

if (isset($_GET['title'])) {

	$myCrowdfunding->setTitle($_GET['title']);
}

if (isset($_GET['hide_title'])) {

	$myCrowdfunding->setMustHideTitle($_GET['hide_title']);

}

if (isset($_GET['display_pubkey'])) {

	$myCrowdfunding->setMustDisplayPubkey($_GET['display_pubkey']);
}

if (isset($_GET['display_qrcode'])) {

	$myCrowdfunding->setMustDisplayQRCode($_GET['display_qrcode']);
}

/*
if (isset($_GET['node'])) {
	
	$myCrowdfunding->addNodes(explode(' ', $_GET['node']));
}
*/

if (isset($_GET['logo'])) {

	$myCrowdfunding->setLogo($_GET['logo']);
}



$theme = isset($_GET['theme']) ? $_GET['theme'] : DEFAULT_THEME;

if (!file_exists($tplPath = THEMES_PATH . '/' . $theme . '.image.php')) {
			
	$tplPath = THEMES_PATH . '/' . DEFAULT_THEME . '.image.php';

}

if (file_exists($confPath = THEMES_PATH . '/' . $theme . '.conf.php')) {
	
	require_once($confPath);
}

ob_clean(); // Without this line, encoding problems (UTF-8 php files instead of ANSI) can cause image to not generate)
header ("Content-type: image/png"); // Comment this line if you need to debug

include($tplPath);
