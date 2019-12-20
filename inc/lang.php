<?php

function getLangName ($isoCode)
{
	global $availableLanguages; 
	
	return $availableLanguages[$isoCode]['name'];
}

function getLocaleCode ($isoCode)
{
	global $availableLanguages; 
	
	return $availableLanguages[$isoCode]['localeCode'];
}

function getLangFolder ($isoCode)
{
	global $availableLanguages; 
	
	return $availableLanguages[$isoCode]['folder'];
}

function defineLang ()
{
	global $availableLanguages;
	
	if (isset($_GET['lang'])) {  /* From URL */

		$lang = $_GET['lang'];

	} else {  /* From browser (if visiting root page /) */

		$lang = preg_replace('/^([^,-]+).*$/', '$1', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

	}
	
	if (!in_array($lang, array_keys($availableLanguages))) {

		define('LANG', DEFAULT_LANG);

	} else {
		
		define('LANG', $lang);

	}

	define('LOCALE_CODE', getLocaleCode(LANG));
	define('LANG_FOLDER', getLangFolder(LANG));
}

function bindTextDomains ($textDomains)
{
	foreach ($textDomains as $td)
	{
		// Spécifie la localisation des tables de traduction
		bindtextdomain($td, './i18n');
	}	
}
