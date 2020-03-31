<?php

/*

-----

Ce script est basé sur la "barre de financement intégrable" développée par Pierre-Jean Chancellier.

Son travail original se trouve ici : 

https://git.duniter.org/paidge/barre-de-financement-int-grable

-----

This script is based on Pierre-Jean Chancellier's "barre de financement intégrable".

See original work at : 

https://git.duniter.org/paidge/barre-de-financement-int-grable

*/

// include('lib/phpqrcode/qrlib.php');

date_default_timezone_set('Europe/Paris');

class Crowdfunding {
	
	/**********************
	 * Constants
	 **********************/
	
	const PUBKEY_FORMAT = '#^[a-zA-Z1-9]{43,44}$#';
	
	const DATE_FORMAT = 'Y-m-d';
	
	private $units = ['quantitative','relative'];
	
	private $truePossibleValues = ['true','1', 'yes'];
	
	private $qrCodesFolder = 'img/qrcodes';
	
	private $qrCodePath = NULL;
	
	private $logosFolder = 'img/logos';
	
	private $logo = NULL;
	
	private $logoPath = NULL;
	
	private $validDisplayTypes = ['img', 'svg', 'html'];
	
	
	/**********************
	 * General parameters
	 **********************/
	
	private $pubkey;
	
	private $target = NULL;
	
	private $startDate = NULL;
	
	private $endDate = NULL;
	
	private $nodes = [
		
		'g1.duniter.org', 
		'remuniter.cgeek.fr',
		'g1.monnaielibreoccitanie.org', 
		'duniter-g1.p2p.legal', 
		'duniter.g1.1000i100.fr', 
		'g1.duniter.inso.ovh', 
		'duniter.vincentux.fr', 
		'g1.le-sou.org', 
		'g1.donnadieu.fr', 
		'g1.mithril.re'
	];
	
	private $node = NULL;
	
	private $apiNode = 'g1.duniter.fr'; // Where the web payment gateway is located
	
	private $cesiumPlusNodes = [
		
		'g1.data.duniter.fr', 
		'g1.data.le-sou.org'
	];
	
	private $cesiumPlusNode = 'g1.data.duniter.fr';
	
	private $unit = 'quantitative';
	
	private $title = 'Financement participatif en monnaie libre';
	
	
	
	/**********************
	 * Display parameters
	 **********************/
	
	private $mustDisplayButton = false;
	
	private $mustDisplayPubkey = false;
	
	private $mustDisplayGraph = false;
	
	private $mustHideTitle = false;
	
	private $mustDisplayQRCode = false;
	
	private $displayType = 'html';
	
	private $filterMinDonation = 0;
	
	private $filterMinCommentLength = 0;
	
	private $validButtonTypes = ['api', 'copy', '2-steps-copy'];
	
	private $buttonType = '2-steps-copy';
	
	/**********************
	 * Computed
	 **********************/
	
	private $daysLeft = NULL;
	
	private $amountCollected = NULL;
	
	private $monthlyAmountCollectedMean = NULL;
	
	private $donorsNb = NULL;
	
	private $periodDonorsNb = NULL;
	
	private $percentage = NULL;
	
	private $donorsList = array();
	
	private $monthsToConsider = NULL;
	
	private $defaultMonthsToConsider = 3;
	
	private $periodDonorsList = array();
	
	private $donationsList = array();
	
	private $meanDonation = NULL;
	
	private $maxDonation = NULL;
	
	private $minDonation = NULL;
	
	private $graphPoints = array();
	
	/*
	 * UD amount in quantitive, for divisions
	 */ 
	private $latestUdAmount = NULL;
	
	private $startDateUdAmount = NULL;
	
	
	
	
	/**********************
	 * Methods
	 **********************/
	
	/**
	 * 
	 * @param $unit = 'quantitative' | 'relative' 
	 * @param $displayType = NULL | 'img' | 'svg' | 'iframe'
	 */
	
	public function __construct ($pubkey, $unit = NULL, $startDate = NULL, $endDate = NULL, $displayType = NULL) {
		
		$this->setDisplayType($displayType);
		
		$this->setPubkey($pubkey);
		
		$this->setUnit($unit);
		
		
		$this->today = new DateTime();
		
		$this->handleDates($startDate, $endDate);
		
		$this->computeDaysLeft();
	}
	
	public function setFilterMinDonation ($min) {
		
		$this->filterMinDonation = (float) $min;
	}
	
	
	public function getFilterMinDonation () {
	
		return $this->filterMinDonation;
	}
	
	public function setFilterMinCommentLength ($length) {
		
		$this->filterMinCommentLength = (int) $length;
	}
	
	
	public function getFilterMinCommentLength () {
	
		return $this->filterMinCommentLength;
	}
	
	public function getEndDate() {
		
		if (isset($this->endDate)) {
			
			return $this->endDate;
		
		} else {
			
			$this->decease(_('La date de fin n\'est pas définie.'));
		}
	}
	
	private function setUnit ($unit) {
		
		if (!empty($unit)) {
			
			if (!in_array($unit, $this->units)) {
				
				$out = [];
				$out[] = _('L\'unité renseignée n\'existe pas.');
				$out[] = _('Vérifiez votre synthaxe.');
				
				$this->decease($out);
			
			} else {
			
				$this->unit = $unit;
			}
		}
	}
	
	private function setDisplayType ($displayType) {
		
		if (!empty($displayType)) {
			
			if (in_array($displayType, $this->validDisplayTypes)) {

				$this->displayType = $displayType;

			} else {

				$this->decease(_('Ce type d\'affichage n\'existe pas.'));
			}
			
		}
	}
	
	public function decease ($errorMsgs) {
		
		if (!is_array($errorMsgs)) {
			
			$errorMsgs = explode("\n", $errorMsgs);
		}
		
		
		if ($this->displayType == 'img') {
			
			$source = imagecreatetruecolor(500, 200);
			
			$bgColor = imagecolorallocate($source, 
										  255, 255, 255);
			
			imagefill($source, 
					  0, 0, 
					  $bgColor);
			
			$txtColor = imagecolorallocate($source, 
										   0, 0, 0);
			
			$errorMsgFontSize = 3;
			$x = 5;
			$y = 5;
			
			foreach ($errorMsgs as $msg) {
			
				imagestring($source, $errorMsgFontSize, $x, $y, utf8_decode($msg), $txtColor);
				
				$y += $errorMsgFontSize + 20;
			}
			
				
			imagepng($source);
			imagedestroy($source);
			
		} else if ($this->displayType == 'svg') {
			
			echo '<?xml version="1.0" encoding="utf-8"?>
			<svg width="580" 
				 height="224" 
				 style="fill:black;" 
				 version="1.1" 
				 xmlns="http://www.w3.org/2000/svg" 
				 xmlns:xlink="http://www.w3.org/1999/xlink">
				 
				<g style="font-family:sans-serif;">';
				
				$x = 25;
				$y = 25;
				
				foreach ($errorMsgs as $msg) {
						
					echo '
					<text
						style="font-size:.8rem;"
						x="'. $x .'"
						y="'. $y . '"
						dominant-baseline="hanging">
							'. $msg . '
					</text>';
					
					$y += 25;
				}
				
				echo '
				</g>
			</svg>';
			
		} else {
			
			ob_get_clean(); // to prevent error message to display inside an HTML container (case of error generated by get method calls)
			
			echo '<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8" />
					<title>'. $this->getTitle() . '</title>
					
					<style>
						
						div {
							
							overflow: auto;
							word-wrap: break-word;
							background-color: hsl(0, 100%, 69%);
							color: hsl(0, 100%, 19%);
							margin: 1em;
							padding: 1em;
							border-radius: 1em;
							position: fixed;
							top: 0;
							left: 0;
							width: calc(100% - 4em);
						}
					</style>
				</head>
				
				<body>
					<div>';
					
			
						foreach ($errorMsgs as $msg) {
							
							echo '<p>' . $msg . '</p>';
						}
						
					echo '
					</div>
				</body>
			</html>';
		}
		
		exit;
	}
	
	public function setTarget ($target) {
		
		if (empty($target)) {

			$out = [];
			$out[] = _('Il manque le montant à atteindre. Vérifiez votre syntaxe.');
			$out[] = _('Vérifiez votre syntaxe.');
			$this->decease($out);

		} else {

			$target = (int)$target;

			if (!is_int($target)){

				$out = [];
				$out[] = _('Le montant n\'est pas un nombre entier.');
				$out[] = _('Vérifiez votre syntaxe.');
				$this->decease($out);

			} else if ($target == 0) {

				$out = [];
				$out[] = _('Le montant cible est nul.');
				$out[] = _('Vérifiez votre syntaxe.');
				$this->decease($out);

			} else if ($target < 0) {

				$out = [];
				$out[] = _('La montant cible inférieur à 0.');
				$out[] = _('Vérifiez votre syntaxe.');
				$this->decease($out);

			} else { 

				$this->target = $target;

			}
		}
	}
	
	public function hasTarget() {
		
		return isset($this->target);
	}
	
	public function getTarget () {
		
		if (!isset($this->target)) {
			
			$out = [];
			$out[] = _('Il manque le montant à atteindre.');
			$out[] = _('Vérifiez votre syntaxe.');
			$this->decease($out);
		
		} else {
			
			return $this->target;
		}
		
	}
	
	public function setMustDisplayGraph ($displayGraphOrNot) {
		
		if (in_array($displayGraphOrNot, $this->truePossibleValues)) {
			
			$this->mustDisplayGraph = true;
			$this->fetchGraph();
			
		} else {
			
			$this->mustDisplayGraph = false;
		}
	}
	
	public function getMustDisplayGraph () {
		
		return $this->mustDisplayGraph;
	}
	
	public function setMustDisplayQRCode ($mustDisplayQRCode) {
		
		$this->mustDisplayQRCode = $mustDisplayQRCode;
		
		if ($mustDisplayQRCode) {
			
			$qrCodePath = $this->qrCodesFolder . '/' . $this->pubkey . '.png';
			
			if (file_exists($qrCodePath)) {
				
				$this->qrCodePath = $qrCodePath;
			
			} else {
				
				QRcode::png($this->pubkey, $qrCodePath);
				
				$this->qrCodePath = $qrCodePath;
			}
		}
	}
	
	public function getQRCodePath () {
	
		if (!file_exists($this->qrCodePath)) {
			
			return false;
			
		} else { 
			
			return $this->qrCodePath;
		}
	}
	
	public function setMustHideTitle ($mustHideTitle) {
		
		if (in_array($mustHideTitle, $this->truePossibleValues)) {
			
			$this->mustHideTitle = true;
		
		} else {
			
			$this->mustHideTitle = false;
			
		}
	}
	
	public function getMustHideTitle () {
		
		return $this->mustHideTitle;
	}
	
	public function setTitle ($title) {
		
		if (!empty($title)) {
		
			$this->title = htmlspecialchars($title);
		}
	}
	
	public function hasLogo() {
		
		return !empty($this->logoPath);
	}
	
	public function setLogo ($logoName) {
		
		if ($this->displayType == 'img') {
			
			$logoPath = $this->logosFolder . '/png/' . $logoName . '.png';
		
		} else {
			
			$logoPath = $this->logosFolder . '/svg/' . $logoName . '.svg';
		}
		
		
		if (!file_exists($logoPath)) {
			
			$this->decease(_('Ce logo n\'existe pas.'));
		
		} else {
			
			$this->logoPath = $logoPath;
		}
	}
	
	public function getLogoPath() {
		
		return $this->logoPath;
		
	}
	
	public function getTitle () {
		
		return $this->title;
	}
		
	public function getMustDisplayQRCode () {
		
		return $this->mustDisplayQRCode;
	}
	
	public function getMustDisplayButton () {
		
		return $this->mustDisplayButton;
	}
	
	public function setMustDisplayPubkey ($mustDisplayPubkey) {
			
		if (in_array($mustDisplayPubkey, $this->truePossibleValues)) {
			
			$this->mustDisplayPubkey = true;
		
		} else {
			
			$this->mustDisplayPubkey = false;
		}
	}
	
	public function getMustDisplayPubkey () {
		
		return $this->mustDisplayPubkey;
	}
	
	public function setMustDisplayButton ($mustDisplayButton) {
		
		$this->mustDisplayButton = (bool) $mustDisplayButton;
	}
	
	
	public function getContributionURL () {
		
		if (!isset($this->contributionURL)) {
			
			$this->contributionURL ='https://' . $this->apiNode . '/api/#/v1/payment/' . $this->pubkey
				. '?' . 
					'amount=10|20|50|100|1000'
				. '&amp;' . 
					'comment=don' 
				. '&amp;' . 
					'redirect_url=https://%3A%252F%252F' . $this->apiNode
				. '&amp;' . 
					'cancel_url=https%3A%252F%252F' . $this->apiNode;
		}
				
		return $this->contributionURL;
		
	}
	
	public function setPubkey ($pubkey) {
		
		if (empty($pubkey)) {
			
			$out = [];
			$out[] = _('Il manque la clé publique du compte à vérifier.');
			$out[] = _('Vérifiez votre syntaxe.');
			
			$this->decease($out);
		
		} else if (!preg_match(self::PUBKEY_FORMAT, $pubkey)) {
			
			$out = [];
			$out[] = _('La pubkey n\'a pas le format attendu.');
			$out[] = _('Vérifiez votre syntaxe.');
			$this->decease($out);
			
		} else {
			
			$this->pubkey = $pubkey;
			
		}
	}
	
	public function printUnit () {
		
		if ($this->unit == 'relative') {
			
			if ($this->displayType == 'img') {
				
				return _('DUĞ1');
			
			} else {
				
				return _('DU<sub>Ğ1</sub>');
			}
			
		} else {
			
			return _('Ğ1');
		}
	}
	
	protected function isDate ($date, $format){
		
		$a = date_parse_from_format($format, $date);
		
		return checkdate($a["month"], $a["day"], $a["year"]);
	}
	
	protected function handleDates ($startDate, $endDate) {
		
		/* Starting date handling */
		
		if (empty($startDate)) {
			
			$this->startDate = new DateTime('first day of this month');
			
		} else if (!$this->isDate($startDate, self::DATE_FORMAT)) {
				
			$out = [];
			$out[] = _('La date de début n\'est pas correcte.');
			$out[] = _('Vérifiez votre syntaxe.');
			$this->decease($out);

		} else {
			
			$d = DateTime::createFromFormat(self::DATE_FORMAT, $startDate);
			
			if ($d === false) {

				$out = [];
				$out[] = _('La date de début n\'est pas correcte.');
				$out[] = _('Vérifiez votre syntaxe.');
				$this->decease($out);
			
			} else {
			
				$this->startDate = $d;
			}
		}

		/* Ending date handling */
		
		if (empty($endDate)) {
			
			$this->endDate = new DateTime('last day of this month');
		
		} else if ($endDate != 0) {
			
			if (!$this->isDate($endDate, self::DATE_FORMAT) ) {

				$out = [];
				$out[] = _('La date de fin est incorrecte.');
				$out[] = _(' Vérifiez votre syntaxe.');
				$this->decease($out);

			} else {

				$d = DateTime::createFromFormat(self::DATE_FORMAT, $endDate);
				
				if ($d === false) {
					
					$out = [];
					$out[] = _('La date de fin est incorrecte.');
					$out[] = _('Renseignez la au format '. self::DATE_FORMAT . '.');
					$this->decease($out);

				} elseif ($d < $this->startDate) {
					
					$out = [];
					$out[] = _('La date de fin est antérieure à la date de début.');
					$out[] = _('Un crowdfunding ne peut pas se terminer avant d\'avoir commencé.');
					$out[] = _('Vérifiez vos dates :');
					$out[] = _('Date de début : ') . $this->startDate->format(self::DATE_FORMAT);
					$out[] = _('Date de fin : ') . $d->format(self::DATE_FORMAT);
					
					$this->decease($out);

				} else {
					
					$this->endDate = $d;
				}
			}
		}
		
		$this->startDate->setTime(0,0,0);
	}
	
	protected function computeDaysLeft () {
		
		if ($this->endDate < $this->today) {
			
			$dteDiff = $this->today->diff($this->endDate);
			$this->daysLeft = -1 * $dteDiff->format('%a');

		} else {
			
			$dteDiff  = $this->endDate->diff($this->today);
			$this->daysLeft = $dteDiff->format('%a');
		}
		
	}
	
	public function getDaysLeft () {
	
		return $this->daysLeft;
	}
	
	public function getMeanDonation () {
		
		if (empty($this->meanDonation)) {
			
			$this->meanDonation = $this->amountCollected / $this->donorsNb;
		}
		
		return $this->meanDonation;
	}
	
	public function getMaxDonation () {
		
		if (empty($this->maxDonation)) {

			$max = 0;

			foreach ($this->donationsList as $d) {
				
				$max = max($max, $d['amount']);
		   }
			
			$this->maxDonation = $max;
		}
		
		return $this->maxDonation;
	}
	
	public function getPubkey () {
		
		return $this->pubkey;
	}
	
	public function getMinDonation () {
		
		if (empty($this->minDonation)) {

			$min = 666666;

			foreach ($this->donationsList as $d) {
				
				$min = min($min, $d['amount']);
		   }
			
			$this->minDonation = $min;
		}
		
		return $this->minDonation;
	}
			
	protected function computePercentage () {
		
		$this->percentage = $this->getAmountCollected() / $this->getTarget() * 100;
		
	}
	
	public function getPercentage () {
		
		if (!isset($this->percentage)) {
			
			$this->computePercentage();
		
		}
		
		return round($this->percentage);
	}
	
	public function getAmountCollected () {
		
		if (isset($this->amountCollected)) {
			
			return $this->amountCollected;
		
		} else {
			
			return $this->fetchAmountCollected();
		}
	}
	
	public function getDonors () {
		
		return $this->donorsList;
	}
	
	public function getDonorsNb () {
		
		if (isset($this->donorsNb)) {
			
			return $this->donorsNb;
		
		} else {
			
			return $this->fetchDonorsNb();
		}
	}
	
	public function fetchMonthlyMean ($monthsToConsider) {
		
		$nMonths = new DateInterval('P'. $monthsToConsider . 'M');
		$dateMonthsAgo = clone $this->today;
		$dateMonthsAgo->sub($nMonths);
		$dateMonthsAgo = DateTime::createFromFormat('Y-m-d', 
													$dateMonthsAgo->format('Y') . '-' . 
													$dateMonthsAgo->format('m') . '-' . 
													'01');
		
		$oneMonth = new DateInterval('P1M');
		$dateFirstDayTodaysMonth = DateTime::createFromFormat('Y-m-d',
															  $this->today->format('Y') . '-' . 
															  $this->today->format('m') . '-' . 
															  '01');
		$dateLastDayOfPreviousMonth = clone $dateFirstDayTodaysMonth;
		$aDay = new DateInterval('P1D');
		$dateLastDayOfPreviousMonth->sub($aDay);
		
		$periodTotalCollected = 0;
		
		$tx = $this->getTransactions($this->pubkey, 
									 $dateMonthsAgo->getTimestamp(), 
									 $dateLastDayOfPreviousMonth->getTimestamp());
		
		$previousMonth = $dateMonthsAgo->format('Y-m');
		$monthlyDonors[$previousMonth] = [];
		$monthlyDonorsNb[$previousMonth] = 0;
		
		foreach ($tx as $t) {
			
			if ($t->issuers[0] != $this->pubkey) {
				
				foreach ($t->outputs as $o) {
					
					if (strstr($o, $this->pubkey)) {
							
						$transactionDate = new DateTime();
						$transactionDate->setTimestamp($t->time);
						
						$currentMonth = $transactionDate->format('Y-m');
						
						if ($currentMonth != $previousMonth) {
							
							$monthlyDonors[$currentMonth] = [];
							$monthlyDonorsNb[$currentMonth] = 0;
						}
						
						$donor = $t->issuers[0];
						
						if (!in_array($donor, $monthlyDonors[$currentMonth])) {
							
							$monthlyDonors[$currentMonth][] = $donor;
							++$monthlyDonorsNb[$currentMonth];
						}
						
						$this->addPeriodDonor($donor);
						
						$o = explode(':', $o);
						$transactionAmount = $o[0] / 100;
						
						$periodTotalCollected += $transactionAmount;
						
						$previousMonth = $currentMonth;
					}
				}
			}
		}
		
		$this->periodDonorsMean = ceil(array_sum($monthlyDonorsNb) / $monthsToConsider);
			
		$this->monthlyAmountCollectedMean = $this->convertIntoChosenUnit($periodTotalCollected / $monthsToConsider);
		
		return $this->monthlyAmountCollectedMean;	
	}
	
	public function setButtonType ($type) {
		
		if (in_array($type, $this->validButtonTypes)) {
			
			$this->buttonType = $type;
		}
	}
	
	public function getButtonType () {
		
		return $this->buttonType;
	}
	
	public function getPeriodDonorsMean ($monthsToConsider) {
		
		return $this->periodDonorsMean;
	}
	
	private function addPeriodDonor ($donor) {
		
		if (!in_array($donor, $this->periodDonorsList)) {
			
			$this->periodDonorsList[] = $donor;
			++$this->periodDonorsNb;
		}
	}
	
	public function getPeriodDonorsNb ($monthsToConsider) {
		
		if (!isset($this->periodDonorsNb)) {
			
			$this->fetchMonthlyMean($monthsToConsider);
		}
		
		return $this->periodDonorsNb;
	}
	
	public function getMonthlyAmountCollectedMean ($monthsToConsider) {
		
		if (!isset($this->monthlyAmountCollectedMean)) {
			
			$this->fetchMonthlyMean($monthsToConsider);
		}
		
		return $this->monthlyAmountCollectedMean;
	}
	
	private function getTransactions ($pubkey, $startTimestamp, $endTimestamp) {
		
		$json = $this->getJson('/tx/history/' . $pubkey . "/times/" . $startTimestamp . "/" . $endTimestamp);
		
		$transactions = json_decode($json);
		
		return $transactions->history->received;
	}
	
	
	public function keepOnlyHighestDonations () {
		
		
	}
	
	public function getDonationsList () {
		
		if (empty($this->donationsList)) {
			
			$this->fetchDonationsList();
		
		}
		
		return $this->donationsList;
			
	}
	
	public function getFilteredDonationsList () {
		
		if (($this->getFilterMinDonation() <= 0) AND ($this->getFilterMinCommentLength() <= 0)) {
			
			return $this->getDonationsList();
		
		} else {

			return array_filter($this->getDonationsList(), function ($v) {

				return (
					($v['amount'] >= $this->getFilterMinDonation())
					 AND 
					(strlen($v['comment']) >= $this->getFilterMinCommentLength())
				);
			});
		}
	}
	
	public function setMonthsToConsider ($m) {
	
		$this->monthsToConsider = (int) $m;
	}
	
	public function getMonthsToConsider () {
		
		if (isset($this->monthsToConsider)) {
			
			return $this->monthsToConsider;
		
		} else {
			
			return $this->defaultMonthsToConsider;
		}
	}
	
	
	private function addDonor ($donor) {
		
		if (!in_array($donor, $this->donorsList)) {
			
			$this->donorsList[] = $donor;
			++$this->donorsNb;
		}
	}
	
	
	private function fetchDonationsList () {
		
		$this->donorsNb = 0;
		
		$tx = $this->getTransactions($this->pubkey, 
									 $this->startDate->getTimestamp(), 
									 $this->endDate->getTimestamp());
		
		foreach ($tx as $t) {
			
			// Filter only incoming transactions
			if ($t->issuers[0] != $this->pubkey) {
			
				$donor = $t->issuers[0];
				
				foreach ($t->outputs as $o) {
					
					if (strstr($o, $this->pubkey)) {
						
						$o = explode(':', $o);
						
						$transactionAmount = $this->convertIntoChosenUnit($o[0] / 100);
						
						$this->amountCollected += $transactionAmount;
				
						$this->addDonor($donor);
						
						$plusProfile = $this->getCesiumPlusProfile($donor);
						
						if (isset($plusProfile->_source->title)) {
							
							$name = $plusProfile->_source->title;
						
						} else {
						
							$name = substr($name, 0, 8);
						}
						
						$this->donationsList[] = [
							
							'donor' => $donor, 
							'name' => $name, 
							'amount' => $transactionAmount, 
							'comment' => $t->comment
						];
					}
				}
			}
		}
		
		return $this->donationsList;
	}
	
	private function fetchDonorsNb () {
		
		$this->fetchDonors();
		
		return $this->donorsNb;
	}
		
	
	private function fetchDonors () {
		
		$this->donorsNb = 0;
		
		$donationsList = $this->donationsList;
		
		if (!empty($donationsList)) {
			
			foreach ($donationsList as $donation) {
				
				$this->addDonor($donation['donor']);
			}
			
		} else {

			$tx = $this->getTransactions($this->pubkey, 
										 $this->startDate->getTimestamp(), 
										 $this->endDate->getTimestamp());

			foreach ($tx as $t) {

				if ($t->issuers[0] != $this->pubkey) {

					$this->addDonor($t->issuers[0]);
				}
			}
		}
		
		return $this->donors;
	}
	
	public function convertIntoChosenUnit ($amountInQuantitative) {
		
		if ($this->unit == 'quantitative') {
			
			return $amountInQuantitative;
		
		} else { 
			
			return $amountInQuantitative / $this->getStartDateUdAmount();
		}
	}
	
	public function getCesiumPlusProfile ($pubkey) {
		
		$json = $this->getJson('/user/profile/' . $pubkey, true);
		
		return json_decode($json);
	}
	
	private function fetchAmountCollected () {
		
		$this->amountCollected = 0;
		$this->donorsNb = 0;
		
		$donationsList = $this->donationsList;
		
		if (!empty($donationsList)) {
			
			foreach ($donationsList as $donation) {
				
				$this->amountCollected += $donation['amount'];
			}
		
		} else {

			$tx = $this->getTransactions($this->pubkey, 
										 $this->startDate->getTimestamp(), 
										 $this->endDate->getTimestamp());

			foreach ($tx as $t) {

				// Filter incoming transactions
				if ($t->issuers[0] != $this->pubkey) {

					foreach ($t->outputs as $o) {

						if (strstr($o, $this->pubkey)) {

							$donor = $t->issuers[0];

							$this->addDonor($donor);

							$o = explode(':', $o);
							$transactionAmount = $o[0] / 100;

							$this->amountCollected += $transactionAmount;
						}
					}
				}
			}
			$this->amountCollected = $this->convertIntoChosenUnit($this->amountCollected);
		}
		
		
		
		return $this->amountCollected;
		
	}
	
	
	
	private function fetchGraph () {
		
		$this->donorsNb = 0;
		
		$dailyAmount = 0;
		$dailyAmountCumulative = 0;
		
		$startTimestamp = $this->startDate->getTimestamp();
		$todayTimestamp = $this->today->getTimestamp();
		
		$dayBefore = $startTimestamp;
		
		$tx = $this->getTransactions($this->pubkey, $startTimestamp, $todayTimestamp);
		
		$hours12 = 43200;
		$hours24 = 86400;
			
		foreach ($tx as $t) {
			
			// Filter incoming transactions
			if ($t->issuers[0] != $this->pubkey) {
				
				foreach ($t->outputs as $o) {
					
					if (strstr($o, $this->pubkey)) {

						$donor = $t->issuers[0];

						$this->addDonor($donor);
						
						$o = explode(':', $o);
						$transactionAmount = $o[0] / 100;
						
						$dailyAmount += $transactionAmount;
						$dailyAmountCumulative += $transactionAmount;
						
						$currentDay = $t->time - $t->time%$hours12 + $hours24;
						
						if ($currentDay != $dayBefore) {

							$this->graphPoints['amountCollectedByDay'][] = [

								't' => $dayBefore * 1000, 
								'y' => (string) round($this->convertIntoChosenUnit($dailyAmount), 2)
							];

							$this->graphPoints['amountCollectedByDayCumulative'][] = [

								't' => $dayBefore * 1000, 
								'y' => (string) round($this->convertIntoChosenUnit($dailyAmountCumulative), 2)
						   ];

							$dailyAmount = 0;
						}

						$dayBefore = $currentDay;
					}
				}
			}
			
			$lastTimestamp = $t->time;
		}
		
		
		$this->amountCollected = $this->convertIntoChosenUnit($dailyAmountCumulative);
			
		// On complète le tableau avec la derniere transaction et pour la date de visualisation du graph
		$this->graphPoints['amountCollectedByDayCumulative'][] = [
					   't' => $lastTimestamp * 1000, 
					   'y' => (string) round($this->amountCollected, 2)
		];

		$this->graphPoints['amountCollectedByDayCumulative'][] = [
					   't' => $todayTimestamp * 1000, 
					   'y'=> (string) round($this->amountCollected, 2)
		];
		
		if (isset($this->target)) {
			
			// On trace la droite de l'objectif
			$this->graphPoints['targetLine'] = [

				[
					't' => $startTimestamp * 1000, 
					'y' => (string) round($this->getTarget(), 2)
				],
				[
					't' => $todayTimestamp * 1000, 
					'y' => (string) round($this->getTarget(), 2)
				]
			];
		}
	}
	
	
	public function getGraphAmountCollectedByDayPoints () {
		
		if (empty($this->graphPoints)) {
			
			$this->fetchGraph();
		
		} else {
			
			return json_encode($this->graphPoints['amountCollectedByDay']);
		}
		
	}
	
	public function getGraphAmountCollectedByDayCumulativePoints () {
		
		if (empty($this->graphPoints)) {
			
			$this->fetchGraph();
		
		} else {
			
			return json_encode($this->graphPoints['amountCollectedByDayCumulative']);
		}
	}
	
	public function getGraphTargetLinePoints () {
		
		if (empty($this->graphPoints)) {
			
			$this->fetchGraph();
		
		} else {
			
			return json_encode($this->graphPoints['targetLine']);
		}
	}
	
	
	
	public function setNode ($node) {
	
		$this->node = htmlspecialchars($node);	
	}
	
	public function getStartDateUDAmount () {
		
		if (!isset($this->startDateUdAmount)) {
			
			if ($this->startDate > $this->today) {

				return $this->getLatestUdAmount();

			} else {
				
				// On récupère les numéros de chaque blocks de DU journalier
				$json = $this->getJson('/blockchain/with/ud');
				$blocks = json_decode($json)->result->blocks;

				// On calcule le nombre de jours écoulés entre aujourd'hui et la date de début
				$diff = $this->today->diff($this->startDate)->format("%a");
				
				// On récupère le bloc de la date qui nous intéresse
				$blockNum = $blocks[count($blocks) - $diff - 1];

				// Puis on récupère le montant du DU
				$json = $this->getJson('/blockchain/block/' . $blockNum);
				$block = json_decode($json);

				$this->startDateUdAmount = $block->dividend / 100;
			}
		}
		
		return $this->startDateUdAmount;
	}
	
	
	public function getJson ($uri, $cesiumPlus = false) {
		
		
		if ($cesiumPlus) {
			
			$node = $this->cesiumPlusNode;
			$nodes = $this->cesiumPlusNodes;
		
		} else {
			
			
			$node = $this->node;
			$nodes = $this->nodes;
		}
		
		if (isset($node)) {
			
			$json = @file_get_contents("https://" . $node . $uri);
		}

		if (!isset($json)) {

			// If node was not found, we fallback to a responding node

			$nodesNb = count($nodes);

			for ($i = 0; (!isset($json) AND ($i < $nodesNb)); ++$i) {

				$json = @file_get_contents("https://" . $nodes[$i] . $uri);


				if (isset($json)) {
					
					if ($cesiumPlus) {
					
						$this->cesiumPlusNode = $nodes[$i];	
					
					} else {
					
						$this->node = $nodes[$i];
					}
				}

			}

			if (!isset($json)) {

				$this->decease(_('Aucun noeud Duniter n\'a été trouvé.'));
				
			} 
		}
		
		return $json;
	}
	
	
	public function getLatestUdAmount () {
		
		if (!isset($this->latestUdAmount)) {
			
			// On récupère les numéros de chaque blocks de DU journalier
			$json = $this->getJson('/blockchain/with/ud');
			$blocks = json_decode($json)->result->blocks;
			
			// On récupère le dernier block qui contient le DU
			$blockNum = end($blocks);

			// Puis on récupère le montant du DU
			$json = $this->getJson('/blockchain/with/ud');
			$block = json_decode($json);

			$this->latestUdAmount = $block->dividend / 100;
		}
		
		return $this->latestUdAmount;
	}
	
	
}
