<?php

class GeoPoint {

	private $longitude;
	
	public $latitude;
	
	public function __construct ($lon, $lat) {
		
		$this->longitude = $lon;
		
		$this->latitude = $lat;
	}
	
	public function getLongitude () {
		
		return $this->longitude;
	}
	
	public function getLatitude () {
		
		return $this->latitude;
	}
}



