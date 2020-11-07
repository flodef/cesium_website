<?php

class Avatar {

	private $content;
	
	public $contentType;
	
	public function __construct ($content, $contentType) {
		
		$this->content = $content;
		
		$this->contentType = $contentType;
	}
	
	public function getContent () {
		
		return $this->content;
	}
	
	public function getContentType () {
		
		return $this->contentType;
	}
}


