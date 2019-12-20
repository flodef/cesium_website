<?php

function parseURI ($uri) {
	
	global $rootURL;
	
	if (MOD_REWRITE == 'off')
	{
		if ($uri != '/') {
			
			$uri .= '.php';
		
		}
	}
	
	$uri = $rootURL . '/' . LANG . $uri;
	
	return $uri;
}

function getUserIpAddress ()
{
	if ($_SERVER['SERVER_NAME'] == 'localhost') {
		
		// Valeurs de tests : 
		
		return '128.101.101.101'; // IP à Mineapolis
		
		return '2a01:e0a:306:e4b0:1704:e381:858a:ae94'; // IP en France
		
	} else if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {

		$a = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		return array_pop($a);

	} else {

		return $_SERVER['REMOTE_ADDR'];	

	}

}