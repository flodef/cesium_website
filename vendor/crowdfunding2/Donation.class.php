<?php

require_once('Donor.class.php');

class Donation {
	
	private $date;
	
	private $amount;
	
	private $donorPubkey;
	
	private $comment;
	
	public function __construct ($amount, $donorPubkey, $time = NULL, $comment = NULL) {
		
		$this->amount = $amount;
		
		$this->donorPubkey = $donorPubkey;
		
		$this->date = new DateTime();
		$this->date->setTimestamp($time);
		
		$this->comment = $comment;
	}
	
	public function getAmount () {
		
		return $this->amount;
	}
	
	public function setAmount ($amount) {
		
		$this->amount = $amount;
	}
	
	public function getDate () {
	
		return $this->date;
	}
	
	public function getComment () {
	
		return $this->comment;
	}
	
	public function getDonorPubkey () {
	
		return $this->donorPubkey;
	}
}



