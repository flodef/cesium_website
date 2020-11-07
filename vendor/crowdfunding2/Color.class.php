<?php

class Color {
	
	private $hex;
	
	private $rgb;
	
	private $hsl;
	
	private $alpha;
	
	private $validColorsList = [
		
		'white' => 'ffffff', 
		'silver' => 'C0C0C0', 
		'gray' => '808080', 
		'black' => '000000', 
		'red' => 'FF0000', 
		'maroon' => '800000', 
		'yellow' => 'FFFF00', 
		'olive' => '808000', 
		'lime' => '00FF00', 
		'green' => '008000', 
		'acqua' => '00FFFF', 
		'cyan' => '00FFFF', 
		'teal' => '008080', 
		'blue' => '0000FF', 
		'navy' => '000080', 
		'fuchsia' => 'FF00FF', 
		'magenta' => 'FF00FF', 
		'purple' => '800080'
	];
	
	private $regexes =  [
		
		'hex3' => '/^([a-fA-F0-9]{3}){1,2}$/',
		'hex6' => '/^#(([a-fA-F0-9]{3}){1,2})$/',
		'rgb' => '/^rgb\( *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5])\, *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]), *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]) *\)$/', 
		'rgba' =>'/^hsla\( *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5])\, *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5]), (0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5])\, *((0\.[0-9]{1,2}|1))\)$/', 
		'hsl' => '/^hsl\( *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5])\, *([0-9]{1,3}(\.[0-9]{0,2})?)%, *([0-9]{1,3}(\.[0-9]{0,2})?)% *\)$/', 
		'hsla' => '/^hsla\( *(0?[0-9]{1,2}|1[0-9]{1,2}|2[0-4][0-9]|25[0-5])\, *([0-9]{1,3}(\.[0-9]{0,2})?)%, *([0-9]{1,3}(\.[0-9]{0,2})?)%\, *((0\.[0-9]{1,2}|1))\)$/', 
	];
	
	public function __construct ($colorStr) {


		if ($colorStr == 'transparent') {
			
			
			
		} else if (array_key_exists($colorStr, $this->validColorsList)) {
			
			$this->hex = $this->validColorsList[$colorStr];

		} else if (preg_match($this->regexes['hex3'], $colorStr)) {
			
			$this->hex = $colorStr;

		} else if (preg_match($this->regexes['hex6'], $colorStr, $matches)) {
			
			$this->hex = $matches[1];
		
		} else if (preg_match($this->regexes['rgb'], $colorStr, $matches)) {
			
			$this->rgb = array(
				'r' => $matches[1], 
				'g' => $matches[2], 
				'b' => $matches[3], 
			);
			
		} else if (preg_match($this->regexes['rgba'], $colorStr, $matches)) {
			
			$this->rgb = array(
				'r' => $matches[1], 
				'g' => $matches[2], 
				'b' => $matches[3], 
				'a' =>$matches[5], 
			);
			
		} else if (preg_match($this->regexes['hsl'], $colorStr, $matches)) {
			
			$this->hsl = array(
				'h' => $matches[1], 
				's' => $matches[2], 
				'l' => $matches[3], 
			);
			
		} else if (preg_match($this->regexes['hsla'], $colorStr, $matches)) {
			
			$this->hsl = array(
				'h' => $matches[1], 
				's' => $matches[2], 
				'l' => $matches[3], 
				'a' => $matches[5], 
			);
			
		} else {
			
			$additionnalMsg = '';
			
			if(empty($colorStr)) {
				
				$additionnalMsg = _('Les couleurs hexadécimales doivent être écrites sans le caractère #');
			
			} else {
				
				$additionnalMsg = sprintf(_('Vous avez écrit : %s'), htmlspecialchars($colorStr));
			}
			
			throw new Exception(_('La couleur %s n\'est pas au bon format.') . "\n" . 
								$additionnalMsg . "\n" . 
								_('Vérifiez votre syntaxe.'));
		}
	}
	
	public function getRGB () {
		
		if (isset($this->rgb)) {
			
			return $this->rgb;
			
		} elseif (isset($this->hex)) {
			
			return $this->hex2RGB($this->hex);
			
		}
	}
	
	public function getRGBa () {
		
		if (isset($this->rgba)) {
			
			return $this->rgba;
			
		}
	}
	
	public function getHSLa () {
		
		if (isset($this->hsla)) {
			
			return $this->hsla;
			
		}
	}
	
	public function getHex () {
	
		if (isset($this->hex)) {
			
			return $this->hex;
			
		} elseif (isset($this->rgb)) {
			
			return $this->RGB2hex($this->rgb);
			
		}
		
	}
	
	public function getColorAllocation ($imgRessource) {
		
		list($r, $g, $b) = $this->getRGB();
		
		return imageColorAllocate($imgRessource, $r, $g, $b);
	}

	public function RGB2hex () {
		
	}

	public function hex2RGB ($hexStr) {

		$strLen = strlen($hexStr);

		if ($strLen == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster

			$colorVal = hexdec($hexStr);

			$r = 0xFF & ($colorVal >> 0x10);
			$g = 0xFF & ($colorVal >> 0x8);
			$b = 0xFF & $colorVal;

		} elseif ($strLen == 3) { //if shorthand notation, need some string manipulations

			$r = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$g = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$b = hexdec(str_repeat(substr($hexStr, 2, 1), 2));

		} else {

			throw new Exception(_('Le paramètre %s n\'est pas une couleur.') . "\n" . _('Vérifiez votre syntaxe.'));
			
		}

		$this->rgb = array($r, $g, $b);
		
		return $this->rgb;
	}


}

