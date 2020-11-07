<?php


/**
 * Note : *image.php theme files should not be encoded as UTF-8
 */


/* ===== Set fonts ====================================== */

$fonts = [];
$fonts['sans'] = FONTS_FOLDER . '/LiberationSans-Regular.ttf';
$fonts['faSolid'] = FONTS_FOLDER . '/fontawesome/900/fa-solid-900.ttf';
$fonts['faRegular'] = FONTS_FOLDER . '/fontawesome/400/fa-regular-400.ttf';




/* ===== Set dimensions ====================================== */

$gutter = 25;
$verticalSpacing = 25;

$content_x = $gutter;
$content_y = $verticalSpacing + 5;

$font_size = 15;
$iconFontSize = 20;
$errorMsgFontSize = 2;

$imgHeight = 200;
$imgWidth = 500;
$progressbarContainerWidth = 450;
$progressbarContainerHeight = 25;

if ($myCrowdfunding->hasLogo()) {

	$logoRessource = imageCreateFromPNG($myCrowdfunding->getLogoPath());

	$logoSize = imagesX($logoRessource);

	$imgWidth += $logoSize + $gutter;

	$content_x += $logoSize + $gutter;
}

if ($myCrowdfunding->getMustDisplayQrCode()) {
	
	$qrCodeRessource = imageCreateFromPNG($myCrowdfunding->getQrCodePath());

	$qrCodeSize = imagesX($qrCodeRessource);

	$qrCodePosX = $imgWidth;
	$qrCodePosY = 42;
	
	$imgWidth += $qrCodeSize + $gutter;
}



/* ===== Create image ====================================== */

$imgRessource = imageCreateTrueColor($imgWidth, $imgHeight);
imageAlphaBlending($imgRessource, false);



/* ===== Set colors ====================================== */

$transparent = imageColorAllocateAlpha($imgRessource, 
                                       255, 255, 255, 
                                       127);

$colorsAllocs = [];
$colorsAllocs['progressbarContainerBg'] = imageColorAllocate($imgRessource, 233, 236, 239); // #e9ecef

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
	
	$colorsAllocs[$paramName] = $c->getColorAllocation($imgRessource);
}





/* ===== Create background ====================================== */

imageFill(
          $imgRessource, 
          0, 0, 
          $colorsAllocs['background_color']
         );

imageFilledRectangle(
                     $imgRessource, 
                     0, 0, 
                     $imgWidth, $imgHeight, 
                     $transparent
                    );

imageAlphaBlending($imgRessource, true);

imageSaveAlpha($imgRessource, true);

imageFill(
          $imgRessource, 
          0, 0, 
          $colorsAllocs['background_color']
         );





/* ===== Create borders ====================================== */

ImageRectangle(
               $imgRessource, 
               0, 0, 
               ($imgWidth-1), ($imgHeight-1), 
               $colorsAllocs['border_color']
              );

ImageRectangle(
               $imgRessource, 
               2, 2, 
               ($imgWidth-3), ($imgHeight-3), 
               $colorsAllocs['border_color']
              );



/* ===== Create logo ====================================== */

if ($myCrowdfunding->hasLogo()) {

	imagecopy(
	          $imgRessource, 
	          $logoRessource, 
	          $gutter, $verticalSpacing, 
	          0, 0, 150, 150
	         );
	
	imagedestroy($logoRessource);
}





/* ===== Create QR Code ====================================== */


if ($myCrowdfunding->getMustDisplayQrCode()) {
	
	imagecopymerge(
	               $imgRessource, 
	               $qrCodeRessource, 
	               $qrCodePosX, 
	               $qrCodePosY, 
	               0,  0, 
	               $qrCodeSize, $qrCodeSize, 
	               100
	              );

	imagedestroy($qrCodeRessource);
}



/* ===== Create title ====================================== */

if (!$myCrowdfunding->getMustHideTitle()) {

	$title_y = ($myCrowdfunding->getMustDisplayPubkey()) ? 23 : $content_y;
	
	$title = $myCrowdfunding->getTitle();
	
	imagettftext(
	             $imgRessource, 
	             $font_size, 
	             0, 
	             ($imgWidth - computeTextWidth($font_size, $fonts['sans'], $title)) / 2, 
	             $title_y, 
	             $colorsAllocs['font_color'], 
	             $fonts['sans'], 
	             $title
	            );
}


/* ==== Create pubkey ====================================== */

if ($myCrowdfunding->getMustDisplayPubkey()) {

	imagettftext(
	             $imgRessource, 
	             $font_size - 5, 
	             0, 
	             $content_x, 
	             $content_y + 15, 
	             $colorsAllocs['font_color'], 
	             $fonts['sans'], 
	             sprintf(_('Clef publique : %s'), $myCrowdfunding->getPubkey())
	            );
}




/* ===== Create progress bar ====================================== */

$progressbarWidth = $progressbarContainerWidth * min(100, $myCrowdfunding->getPercentage()) / 100;

ImageFilledRectangle(
                     $imgRessource, 
                     $content_x + 1,
                     $content_y + $verticalSpacing+1,
                     $content_x + $progressbarContainerWidth,
                     $content_y + $verticalSpacing + $progressbarContainerHeight,
                     $colorsAllocs['progressbarContainerBg']
                    );

ImageFilledRectangle(
                     $imgRessource, 
                     $content_x + 1,
                     $content_y + $verticalSpacing + 1 ,
                     $content_x + $progressbarWidth,
                     $content_y + $verticalSpacing + $progressbarContainerHeight,
                     $colorsAllocs['progress_color']
                    );

ImageRectangle(
               $imgRessource, 
               $content_x,
               $content_y + $verticalSpacing,
               $content_x + $progressbarContainerWidth + 1,
               $content_y + $verticalSpacing + $progressbarContainerHeight + 1,
               $colorsAllocs['border_color']);

imagettftext(
             $imgRessource, 
             $font_size, 
             0, 
             $content_x + $progressbarWidth/2, 
             $content_y + $verticalSpacing + $progressbarContainerHeight/2 + 9, 
             $colorsAllocs['font_color'], 
             $fonts['sans'], 
             $myCrowdfunding->getPercentage() . '%'
            );



/* ===== Create stats ====================================== */

$iconFontSize = 20;
$statFontSize = 15;
$labelFontSize = 10;
$iconBottomMargin = 12;
$statBottomMargin = 3;

$columns = [];

$columns[0] = [
	
	[
		'text' => '"&#xF200;"', 
		'fontFile' => $fonts['faSolid'], 
		'fontSize' => $iconFontSize, 
		'bottomMargin' => $iconBottomMargin
		
	], [
		
		'text' => $myCrowdfunding->getPercentage() . '%',
		'fontFile' => $fonts['sans'], 
		'fontSize' => $statFontSize, 
		'bottomMargin' => $statBottomMargin
		
	], [
		
		'text' => utf8_decode(_('atteints')), 
		'fontFile' => $fonts['sans'], 
		'fontSize' => $labelFontSize, 
		'bottomMargin' => 0
	]
];

$columns[1] = [
	
	[
		'text' => '"&#xF007;"', 
		'fontFile' => $fonts['faRegular'], 
		'fontSize' => $iconFontSize, 
		'bottomMargin' => $iconBottomMargin
		
	], [
		
		'text' => $myCrowdfunding->getDonorsNb(), 
		'fontFile' => $fonts['sans'], 
		'fontSize' => $statFontSize, 
		'bottomMargin' => $statBottomMargin
		
	], [
		
		'text' => utf8_decode(_('donateurs')), 
		'fontFile' => $fonts['sans'], 
		'fontSize' => $labelFontSize, 
		'bottomMargin' => 0
	]
];

$columns[2] = [
	
	[
		'text' => '"&#xF3D1;"', 
		'fontFile' => $fonts['faRegular'], 
		'fontSize' => $iconFontSize, 
		'bottomMargin' => $iconBottomMargin
		
	], [
		
		'text' => round($myCrowdfunding->getAmountCollected()) . ' ' . $myCrowdfunding->printUnit(), 
		'fontFile' => $fonts['sans'], 
		'fontSize' => $statFontSize, 
		'bottomMargin' => $statBottomMargin
		
	], [
		
		'text' => sprintf(_('sur %s %s'), $myCrowdfunding->getTarget(), $myCrowdfunding->printUnit()), 
		'fontFile' => $fonts['sans'], 
		'fontSize' => $labelFontSize, 
		'bottomMargin' => 0
	]
];

if (($daysLeft = $myCrowdfunding->getDaysLeft()) > 0) {

	$columns[3] = [

		[
			'text' => '"&#xF073;"',
			'fontFile' => $fonts['faRegular'], 
			'fontSize' => $iconFontSize, 
			'bottomMargin' => $iconBottomMargin

		], [

			'text' => $daysLeft, 
			'fontFile' => $fonts['sans'], 
			'fontSize' => $statFontSize, 
			'bottomMargin' => $statBottomMargin

		], [

			'text' => _('jours restants'), 
			'fontFile' => $fonts['sans'], 
			'fontSize' => $labelFontSize, 
			'bottomMargin' => 0
		]
	];

}

$columnWidth = $progressbarContainerWidth / count($columns);
$columnMid = $columnWidth / 2;
$icone_pos_y = $content_y + $verticalSpacing + $progressbarContainerHeight + $verticalSpacing + $iconFontSize;

foreach ($columns as $colNum => $cells) {

	$x = $content_x + $colNum * $columnWidth + $columnMid;
	$y = $icone_pos_y;
	$angle = 0;
	
	foreach ($cells as $cell) {

		imageTTFtext(
		             $imgRessource, 
		             $cell['fontSize'], 
		             $angle, 
		             $x - (computeTextWidth($cell['fontSize'], $cell['fontFile'], $cell['text']) / 2), 
		             $y, 
		             $colorsAllocs['font_color'], 
		             $cell['fontFile'], 
		             $cell['text']
		            );
		
		$y += $cell['fontSize'] + $cell['bottomMargin']; 
	}
}

imagepng($imgRessource);
imagedestroy($imgRessource);

