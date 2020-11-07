<?php

require_once('conf.php');
require_once('functions.php');
require_once('Crowdfunding.class.php');
require_once('Color.class.php');
require_once('lib/locales.php');

$GETs = ['pubkey', 'unit', 'start_date', 'end_date'];

foreach ($GETs as $get) {

	if (!isset($_GET[$get])) {
		
		$_GET[$get] = NULL;
	}
}

$myCrowdfunding = new Crowdfunding($_GET['pubkey'], $_GET['unit'], $_GET['start_date'], $_GET['end_date']);


if (isset($_GET['target'])) {
	
	$myCrowdfunding->setTarget($_GET['target']);
}

if (isset($_GET['months_to_consider'])) { // for Tipeee-like themes
	
	$myCrowdfunding->setMonthsToConsider($_GET['months_to_consider']);
}

if (isset($_GET['display_button'])) {
	
	$myCrowdfunding->setMustDisplayButton($_GET['display_button']);
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
	
	$myCrowdfunding->setMustDisplayQRCode(true);
}

/*
if (isset($_GET['node'])) {
	
	$myCrowdfunding->addNodes(explode(' ', $_GET['node']));
}
*/

if (isset($_GET['display_graph'])) {
	
	$myCrowdfunding->setMustDisplayGraph($_GET['display_graph']);
	
	if ($myCrowdfunding->getMustDisplayGraph()) {
	
		require_once('Chart.class.php');
	
		$chart = new Chart($myCrowdfunding);
	}
}





if (!isset($_GET['theme']) or !file_exists($tplPath = THEMES_PATH . '/' . $_GET['theme'] . '.html.php')) {
	
	$theme = DEFAULT_THEME;

} else {
	
	$theme = $_GET['theme'];
}

$tplPath = THEMES_PATH . '/' . $theme . '.html.php';
$confPath = THEMES_PATH . '/' . $theme . '.conf.php';

if (file_exists($confPath)) {
	
	require_once($confPath);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?php echo $myCrowdfunding->getTitle(); ?></title>
	<link rel="stylesheet" href="<?php echo THEMES_PATH . '/' . $theme; ?>.css" />
	
	<?php
	if (function_exists('getComputedStyles')) {
		
		echo '
		<style>
		'. getComputedStyles() .'
		</style>';
	}
	?>
</head>
<body>
	<?php
		include($tplPath);
	?>
</body>
</html>
	





