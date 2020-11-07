<?php

class Graph {
	
	/* Data */
	
	private $dataPoints = NULL;
	
	private $label = NULL;
	
	/* Style */

	private $styles = [
	
		'type' => NULL, 
		'borderColor' => NULL, 
		'backgroundColor' => NULL, 
		'borderDash' => NULL, 
		'radius' => NULL, 
		'fill' => NULL, 
		'borderWidth' => NULL, 
		'lineTension' => NULL, 
		'pointRadius' => NULL, 
		'steppedLine' => NULL
	];
	
	
	public function __construct ($dataPoints, $label) {
		
		$this->dataPoints = $dataPoints;
		
		$this->label = $label;
	}
	
	public function setStyle ($param, $value) {
		
		switch (gettype($value)) {
		
			case 'boolean': 
				$this->styles[$param] = $value ? 'true' : 'false';
				break;
			case 'array':
				$this->styles[$param] = json_encode($value);
				break;
			case 'string': 
				$this->styles[$param] = '\''. $value . '\'';
				break;
			default: 
				$this->styles[$param] = $value;
		}
	}
	
	public function getGraph () {
		
		$out = '';
		
		$out .= '
		{
			data: '. $this->dataPoints .', 
			label: "'. $this->label .'", ';
			
			foreach ($this->styles as $k => $v) {
				
				if ($v !== NULL) {
					
					$out .= $k . ': ' . $v . ', ';
				}
			}
			
			$out .= '
		}';
		
		return $out;
	}
}
