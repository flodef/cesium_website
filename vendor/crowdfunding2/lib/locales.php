<?php

if (isset($_GET['lang'])) {
	
	if (empty($_GET['lang'])) 
		
		$langdetect = true;
	
	else 
		
		$lang = $_GET['lang'];
}

# Autodetect browser language
if(isset($langdetect) and $langdetect) {
	
	$langd = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	# Client can modify HTTP headers and modify the file path
	# So we must verify $langd
	if (preg_match('#[a-zA-Z_]{2}#i', $langd)) {
		
		$lang = $langd;
	}
}

if(isset($lang) and file_exists(getcwd().'/locales/'.$lang.'.tr.php')) {}
else $lang = 'fr';
require('locales/'.$lang.'.tr.php');

function bparse($text, $vars) {
	
	foreach($vars as $var1 => $var2) {
		
		$text = str_replace('{{'.$var1.'}}', $var2, $text);
	}
	
	return $text;
}

function tr($tkey, $vars=array()) {
	
	global $ttr;
	
	if (isset($ttr[$tkey])) {
		
		return bparse($ttr[$tkey], $vars);
	}
	
	return '';
}


