<?php

function getLangName ($code)
{
	switch ($code)
	{
		case 'fr' : 
			return 'français';
		case 'en' : 
			return 'english' ;
		case 'es' :
			return 'español';
		case 'hv' :
			return 'haut valyrian';
		case 'it' : 
			return 'italiano';
		default : 
			return ''; // Supposedly cannot happen
	}
}

function getGetTextFolder ($code)
{
	switch ($code)
	{
		case 'fr' :
			return 'fr_FR';
		case 'en' :
			return 'en_GB';
		case 'es' :
			return 'es_ES';
		case 'hv' :
			return 'en_US';
		case 'it' :
			return 'it_IT';
	}
}

function defineLang ()
{
	global $availableLanguages;
	
	if (isset($_GET['lang'])) {

		$lang = $_GET['lang'];

	} else {

		$lang = preg_replace('/^([^,-]+).*$/', '$1', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

	}

	if (!in_array($lang, $availableLanguages)) {

		define('LANG', DEFAULT_LANG);

	} else {

		define('LANG', $lang);

	}

	define('L10N_FOLDER', getGetTextFolder(LANG));
}

function bindTextDomains ($textDomains)
{
	foreach ($textDomains as $td)
	{
		// Spécifie la localisation des tables de traduction
		bindtextdomain($td, './i18n');
	}	
}
