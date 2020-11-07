<?php

$defaultColors = [
	
	'background_color' => '#ffffff', 
	'border_color' => '#343a40',
	'font_color' => '#212529', 
	'progress_color' => '#ffc107'
];


function computeStyle ($paramName, $value) {
	
	switch ($paramName) {
			
		case 'font_color': return '

			body {

				color: '. $value .';
			}
		';
			
		case 'background_color': return '
			
			body {

				background-color: '. $value .';
			}
		';
			
		case 'border_color': return '

			.progress-container {

				border-color: '. $value .';	
			}
		';
			
		case 'progress_color' : return '

			.progress-bar {

				background-color: '. $value .';	
			}
		';
	}
}



function getComputedStyles () {

	$CSS = '';
	
	global $defaultColors;


	foreach ($defaultColors as $paramName => $defaultColor) {
		
		if (!isset($_GET[$paramName])) {
			
			$c = new Color($defaultColor);
		
		} else {

			try {
				
				$c = new Color($_GET[$paramName]);

			} catch (Exception $e) {

				$myCrowdfunding->decease(sprintf($e->getMessage(), $paramName));
			}
		
		}
		
		$CSS .= computeStyle($paramName, '#' . $c->getHex());
	}
	/*
	if (!$myCrowdfunding->hasTarget()) {
		
		$out = [];
		$out[] = _('Il manque le montant à atteindre. Vérifiez votre syntaxe.');
		$out[] = _('Vérifiez votre syntaxe.');
		$myCrowdfunding->decease($out);
	}*/
	
	return $CSS;
}


