<?php

require_once('Avatar.class.php');
require_once('GeoPoint.class.php');

class Donor {
	
	private $pubkey;
	
	private $name;
	
	private $avatar;
	
	private $city;
	
	private $geoPoint;
	
	
	public function __construct ($pubkey) {
		
		$this->pubkey = $pubkey;
	}
	
	public function setName ($name) {
		
		$this->name = $name;
	}
	
	public function getName () {
		
		if (isset($this->name)) {
		
			return $this->name;
		
		} else {
		
			return substr($this->pubkey, 0, 8);
		}
		
	}
	
	public function setAvatar ($content, $contentType) {
		
		$this->avatar = new Avatar($content, $contentType);
	}
	
	public function getAvatar () {
	
		return $this->avatar;
	}
	
	public function setCity ($city) {
		
		$this->city = $city;
	}
	
	public function getCity () {
	
		return $this->city;
	}
	
	public function setGeoPoint ($lon, $lat) {
		
		$this->geoPoint = new GeoPoint($lon, $lat);
	}
	
	public function getGeoPoint () {
	
		return $this->geoPoint;
	}
	
	
}

