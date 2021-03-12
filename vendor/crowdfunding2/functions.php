<?php

function base64_encode_image ($filename, $filetype) {
	
    if ($filename) {
		
        $imgbinary = fread(fopen($filename, "r"), filesize($filename));
        return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
    }
}


function computeTextWidth ($fontSize, $fontFile, $text) {
	
	
	list($leftCornerX, $null, $rightCornerX) = imageTTFbBox($fontSize, 0, $fontFile, $text);
	
	return ($rightCornerX - $leftCornerX);
}
