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

class Funding
{
	private $units = ['quantitative','relative'];
	
	private $unit = 'relative';
	
	private $pubkeyFormat = '#^[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{43,44}$#';
	
	private $node = 'g1.duniter.org';
	
	private $pubkey;
	
	private $target;
	
	private $startDate;
	
	private $total = 0;
	
	private $donorsNb = 0;
	
	private $percentage;
	
	
	
	public function __construct ($pubkey, $target, $startDate, $unit = 'relative')
	{
		if (!preg_match($this->pubkeyFormat, $pubkey)) {
			
			echo "<p>La pubkey n'a pas le format attendu. Vérifiez votre syntaxe.</p>";
			exit;
			
		}
		
		$this->pubkey = $pubkey;
		
		$this->target = $target;
		
		$this->startDate = $startDate;
		
		$this->unit = $unit;
		
		$this->computeAmountDonatedAndDonorsNb();
			
		$this->percentage = round($this->total / $this->target * 100);
		
	}
	
	public function getPercentage ()
	{
		return $this->percentage;	
	}
	
	public function getAmountDonated ()
	{
		return $this->total;	
	}
	
	public function getDonorsNb ()
	{
		return $this->donorsNb;
	}
	
	private function computeAmountDonatedAndDonorsNb ()
	{
		
		$today = new DateTime();
		$format = "d/m/Y";
		function isDate(&$date, $format){
			$champsDate = date_parse_from_format($format, $date);
			$date = DateTime::createFromFormat($format, $date);
			return checkdate($champsDate["month"], $champsDate["day"], $champsDate["year"]);
		}

		// Vérification des dates et calcul du nombre de jours entre la date du jour et la date de fin
		if (!empty($this->startDate)){
			
			$start_date = $this->startDate;
			
			if (!isDate($start_date, $format)){
				echo "<p>La date de début n'est pas correcte. Vérifiez votre syntaxe.</p>";
				exit;
			}
			
			$start_date->sub(new DateInterval('P1D'));
			
		} else {
			
			echo "<p>Il manque la date de début. Vérifiez votre syntaxe.</p>";
			exit;
			
		}
		
		// Récupération des transactions entrantes entre la date de début et la date du jour
		$url_json = "https://" . $this->node . "/tx/history/" . $this->pubkey . "/times/" . $start_date->getTimestamp() . "/" . $today->getTimestamp();
		$json = file_get_contents($url_json);
		$json = json_decode($json);
		$transactions = $json->history->received;
		$donors = [];
		$current_date = $start_date->format($format);
		$array_dates = [$current_date];
		$array_montants = [];

		foreach ($transactions as $transaction){

			$donor = $transaction->issuers[0];

			if ($donor != $this->pubkey){

				if(!in_array($donor, $donors)){

					array_push($donors, $donor);

				}
				
				$outputs = $transaction->outputs;
				
				foreach ($outputs as $output){

					if (strstr($output,$this->pubkey)){

						$timestamp = $transaction->blockstampTime;
						$date_transaction = date('d/m/Y', $timestamp);

						if ($date_transaction != $current_date){

							array_push($array_dates, $date_transaction);
							array_push($array_montants, $this->total);
							$current_date = $date_transaction;
						}

						$output = explode(":", $output);
						$montant = $output[0]/100;

						$this->total += $montant;
					}
				}
			}
		}

		array_push($array_montants, $this->total);
		$this->donorsNb = count($donors);	
		
		if ($this->unit == 'relative')
		{
			$this->total = round($this->total / $this->getLastUDAmount());
		}
	}
	
	public function setNode ($node)
	{
		$this->node = $node;	
	}
	
	public function getLastUDAmount ()
	{
		// On récupère le dernier block qui contient le DU
		$url_json = "https://" . $this->node . "/blockchain/with/ud";
		$json = file_get_contents($url_json);
		$json = json_decode($json);
		$last_block_with_ud = end($json->result->blocks);

		// Puis on récupère le montant du DU
		$url_json = "https://" . $this->node . "/blockchain/block/" . $last_block_with_ud;
		$json = file_get_contents($url_json);
		$json = json_decode($json);
		$ud = $json->dividend/100;
		
		return $ud;
	}
	
	
}
