<?php

/**
 * Note : *svg.php theme files should not be encoded as UTF-8
 */

	
/* ===== Set colors ====================================================== */

$colorsHex = [];
$colorsHex['progressbarContainerBg'] = '#e9ecef';

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
	
	$colorsHex[$paramName] = '#' . $c->getHex();
}


/* ===== Set dimensions ================================================== */

$iconSize = 25;
$qrCodeSize = 111;
$qrCodeSpaceAround = 32;
$logoSize = 150;
$progressbarBorderSize = 1;
$svgBorderSize = 1;



/* ===== Set dimensions : height and Y positionning ======================= */

$verticalSpacing = 20;
$progressbarHeight = 25;
$progressbarContainerHeight = $progressbarHeight + 2*$progressbarBorderSize;

$originY = 4*$svgBorderSize + $verticalSpacing;

               $titlePosY  = $originY;

              $pubkeyPosY  = $titlePosY;
              $pubkeyPosY += $myCrowdfunding->getMustHideTitle() ? 0 : (27 + $verticalSpacing);

$progressbarContainerPosY  = $pubkeyPosY;
$progressbarContainerPosY += $myCrowdfunding->getMustDisplayPubkey() ? (15 + $verticalSpacing) : 0;


         $progressbarPosY  = $progressbarContainerPosY + $progressbarBorderSize;
               $statsPosY  = $progressbarPosY + $progressbarHeight + $verticalSpacing;

          $statNumberPosY  = 0 + $iconSize + $verticalSpacing;
           $statLabelPosY  = $statNumberPosY + 21;

$qrCodePosY =  $progressbarPosY + $progressbarBorderSize + $progressbarHeight/2- $qrCodeSpaceAround/2;

$svgHeight = $statsPosY + $statLabelPosY + 21 + $verticalSpacing;

$statsHeight = $svgHeight - $progressbarPosY - $progressbarHeight - $verticalSpacing;


if ($myCrowdfunding->getMustDisplayPubkey()){
	
	$svgHeight += 10 + $verticalSpacing;
}

if (($daysLeft = $myCrowdfunding->getDaysLeft()) AND isset($daysLeft) AND ($daysLeft > 0)) {
	
	$colNb = 4;
	
} else {

	$colNb = 3;	
}



/* ===== Set dimensions : width and X positionning ======================= */

$guttersWidth = 40;
$originX = $guttersWidth;
$progressbarContainerWidth = 500;

$svgWidth = $progressbarContainerWidth + (2 * $guttersWidth);

$colWidth = $progressbarContainerWidth / $colNb;
$iconX = $colWidth/2 - $iconSize/2;

$progressbarWidth = $progressbarContainerWidth * min(1, $myCrowdfunding->getPercentage()/100) - 2*$progressbarBorderSize;

if ($myCrowdfunding->getMustDisplayQRCode()) {
	
	$svgWidth += $qrCodeSize + $guttersWidth;
	$qrCodePosX =  $originX + $logoSize + $guttersWidth + $progressbarContainerWidth + $guttersWidth;
}

if ($myCrowdfunding->hasLogo()) {
	
	$svgWidth += $logoSize + $guttersWidth;
	
	$originX += $logoSize + $guttersWidth;
}



/* ===== SVG ====================================================== */

echo '<?xml version="1.0" encoding="utf-8"?>'; // We must display this that way because <? can be interpreted as PHP tags by some servers

?><svg width="<?php echo $svgWidth; ?>" 
	 height="<?php echo $svgHeight; ?>" 
	 style="fill:<?php echo $colorsHex['font_color']; ?>;" 
	 version="1.1" 
	 xmlns="http://www.w3.org/2000/svg" 
	 xmlns:xlink="http://www.w3.org/1999/xlink">
	
	<!-- Borders -->
	<rect
		x="<?php echo $svgBorderSize; ?>"
		y="<?php echo $svgBorderSize; ?>"
		width="<?php echo ($svgWidth - 2*$svgBorderSize); ?>"
		height="<?php echo ($svgHeight - 2*$svgBorderSize); ?>"
		style="fill:<?php echo $colorsHex['background_color']; ?>;stroke:<?php echo $colorsHex['border_color']; ?>;stroke-width:<?php echo $svgBorderSize; ?>;"/>
	<rect
		x="<?php echo 4*$svgBorderSize; ?>"
		y="<?php echo 4*$svgBorderSize; ?>"
		width="<?php echo ($svgWidth - 8*$svgBorderSize); ?>"
		height="<?php echo ($svgHeight - 8*$svgBorderSize); ?>"
		style="fill:<?php echo $colorsHex['background_color']; ?>;stroke:<?php echo $colorsHex['border_color']; ?>;stroke-width:<?php echo $svgBorderSize; ?>;"/>
	
	<!-- Campaign logo -->
	<?php 
	
	if ($myCrowdfunding->hasLogo()) { 
		
		?>

		<image xlink:href="<?php echo $myCrowdfunding->getLogoPath(); ?>" 
			   x="<?php echo $guttersWidth; ?>" 
			   y="<?php echo ($svgHeight - $logoSize) / 2; ?>" 
			   width="<?php echo $logoSize; ?>" 
			   height="<?php echo $logoSize; ?>" />
	
		<?php 
	}
	
	?>
	
	
	<g style="font-family:sans-serif;">
		
		<?php 
		if (!$myCrowdfunding->getMustHideTitle()) {
			?>

			<!-- Campaign title -->
			<text
				style="font-size:1.5rem;"
				x="50%"
				y="<?php echo $titlePosY; ?>" 
				text-anchor="middle" 
				dominant-baseline="hanging">
					<?php echo $myCrowdfunding->getTitle(); ?>
			</text>
			
			<?php
		}
		?>
		
		<!-- Pubkey -->
		<?php 
		if ($myCrowdfunding->getMustDisplayPubkey()) {
			
			?>
		
			<text
				style="font-size:.8rem;"
				x="<?php echo $originX; ?>"
				y="<?php echo $pubkeyPosY; ?>"
			    dominant-baseline="hanging">
					Pubkey : <?php echo $myCrowdfunding->getPubkey(); ?>
			</text>
			
			<?php 
		} 
		?>
		
		<!-- Progress bar container -->
		<rect
			style="fill:<?php echo $colorsHex['progressbarContainerBg']; ?>;stroke:<?php echo $colorsHex['border_color']; ?>;stroke-width:<?php echo $progressbarBorderSize; ?>;"
			width="<?php echo $progressbarContainerWidth; ?>"
			height="<?php echo $progressbarContainerHeight; ?>"
			x="<?php echo $originX; ?>"
			y="<?php echo $progressbarContainerPosY; ?>" />
		
		<!-- Progress bar -->
		<svg
			x="<?php echo $originX + $progressbarBorderSize; ?>"
			y="<?php echo $progressbarPosY; ?>"
			width="<?php echo $progressbarWidth; ?>"
			height="<?php echo $progressbarHeight; ?>">
			
			<rect style="fill:<?php echo $colorsHex['progress_color']; ?>;" width="100%" height="100%" />
			
			<!-- Percentage reached -->
			<?php 
			if ($myCrowdfunding->getPercentage() > 7) { 
				
				?>
			
				<text
					style="font-size:1rem;" 
					x="50%" 
					y="50%" 
					dominant-baseline="central" 
					text-anchor="middle">
					
					<?php echo $myCrowdfunding->getPercentage() . '%'; ?>
				</text>
			
				<?php
			}
			?>
		</svg>
	</g>
	
	<!-- Stats -->
	<svg x="<?php echo $originX; ?>" 
		 y="<?php echo $statsPosY; ?>" 
		 width="<?php echo $progressbarContainerWidth; ?>" 
		 height="<?php echo $statsHeight; ?>">
		
		<!-- Stat #1 : % reached -->
		<svg width="<?php echo $colWidth; ?>" height="100%">
			
			<!-- pie icon -->
			<svg x="<?php echo $iconX; ?>" 
				 viewBox="0 0 544 512" 
				 width="<?php echo $iconSize; ?>" 
				 height="<?php echo $iconSize; ?>">
				
				<path d="M527.79 288H290.5l158.03 158.03c6.04 6.04 15.98 6.53 22.19.68 38.7-36.46 65.32-85.61 73.13-140.86 1.34-9.46-6.51-17.85-16.06-17.85zm-15.83-64.8C503.72 103.74 408.26 8.28 288.8.04 279.68-.59 272 7.1 272 16.24V240h223.77c9.14 0 16.82-7.68 16.19-16.8zM224 288V50.71c0-9.55-8.39-17.4-17.84-16.06C86.99 51.49-4.1 155.6.14 280.37 4.5 408.51 114.83 513.59 243.03 511.98c50.4-.63 96.97-16.87 135.26-44.03 7.9-5.6 8.42-17.23 1.57-24.08L224 288z"/>
				
			</svg>
			
			<text style="font-size:1.2rem;" 
				  x="50%" 
				  y="<?php echo $statNumberPosY; ?>" 
				  dominant-baseline="hanging" 
				  text-anchor="middle" >
				
				<?php echo $myCrowdfunding->getPercentage() . '%'; ?>
				
			</text>
			
			<text style="font-size:.9rem;" 
				  x="50%" 
				  y="<?php echo $statLabelPosY; ?>" 
				  dominant-baseline="hanging" 
				  text-anchor="middle">
				
				<?php echo _('atteints') ?>
				
			</text>
		</svg>
		
		<!-- Stat #2 : number of donors -->
		<svg x="<?php echo $colWidth; ?>" width="<?php echo $colWidth; ?>">
			
			<!-- user icon -->
			<svg x="<?php echo $iconX; ?>" 
				 viewBox="0 0 448 512" 
				 width="<?php echo $iconSize; ?>" 
				 height="<?php echo $iconSize; ?>">
				
				<path d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/>
				
			</svg>
			
			<text style="font-size:1.2rem;" 
				  x="50%" 
				  y="<?php echo $statNumberPosY; ?>" 
				  dominant-baseline="hanging" 
				  text-anchor="middle">
				
				<?php echo $myCrowdfunding->getDonorsNb(); ?>
				
			</text>
			
			<text style="font-size:.9rem;" 
				  x="50%" 
				  y="<?php echo $statLabelPosY; ?>" 
				  dominant-baseline="hanging" 
				  text-anchor="middle">
				
				<?php echo _('donateurs') ?>
				
			</text>
		</svg>
		
		<!-- Stat #3 : amount collected -->
		<svg x="<?php echo 2*$colWidth; ?>" width="<?php echo $colWidth; ?>">
			
			<!-- bill icon -->
			<svg x="<?php echo $iconX; ?>" 
				 viewBox="0 0 640 512" 
				 width="<?php echo $iconSize; ?>" 
				 height="<?php echo $iconSize; ?>">
				
				<path d="M320 144c-53.02 0-96 50.14-96 112 0 61.85 42.98 112 96 112 53 0 96-50.13 96-112 0-61.86-42.98-112-96-112zm40 168c0 4.42-3.58 8-8 8h-64c-4.42 0-8-3.58-8-8v-16c0-4.42 3.58-8 8-8h16v-55.44l-.47.31a7.992 7.992 0 0 1-11.09-2.22l-8.88-13.31a7.992 7.992 0 0 1 2.22-11.09l15.33-10.22a23.99 23.99 0 0 1 13.31-4.03H328c4.42 0 8 3.58 8 8v88h16c4.42 0 8 3.58 8 8v16zM608 64H32C14.33 64 0 78.33 0 96v320c0 17.67 14.33 32 32 32h576c17.67 0 32-14.33 32-32V96c0-17.67-14.33-32-32-32zm-16 272c-35.35 0-64 28.65-64 64H112c0-35.35-28.65-64-64-64V176c35.35 0 64-28.65 64-64h416c0 35.35 28.65 64 64 64v160z"/>
				
			</svg>
			
			<text style="font-size:1.2rem;" 
				  x="50%" 
				  y="<?php echo $statNumberPosY; ?>" 
				  dominant-baseline="hanging" 
				  text-anchor="middle">
				
				<?php 
				
				echo round($myCrowdfunding->getAmountCollected()) . ' ' . $myCrowdfunding->printUnit();
				
				?>
				
			</text>
			
			<text style="font-size:.9rem;" 
				  x="50%" 
				  y="<?php echo $statLabelPosY; ?>" 
				  dominant-baseline="hanging" 
				  text-anchor="middle">
				
				<?php 
				echo sprintf(_('sur un total de %s %s'), $myCrowdfunding->getTarget(), $myCrowdfunding->printUnit());
				?>
				
			</text>
		</svg>
		
		
		<!-- Stat #4 : days left -->
		<?php 
		if ($colNb == 4) {
			
			?>
		
			<svg x="<?php echo 3*$colWidth; ?>" width="<?php echo $colWidth; ?>">
				
				<!-- calendar icon -->
				<svg x="<?php echo $iconX; ?>" viewBox="0 0 448 512" width="<?php echo $iconSize; ?>" height="<?php echo $iconSize; ?>">
					<path d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"/>
				</svg>
				
				<text style="font-size:1.2rem;" 
					  x="50%" 
				      y="<?php echo $statNumberPosY; ?>" 
					  dominant-baseline="hanging" 
					  text-anchor="middle">
					
					<?php echo $myCrowdfunding->getDaysLeft(); ?>
					
				</text>
				
				<text style="font-size:.9rem;" 
					  x="50%" 
				      y="<?php echo $statLabelPosY; ?>" 
					  dominant-baseline="hanging" 
					  text-anchor="middle">
					
					<?php echo _('jours restants'); ?>
					
				</text>
			</svg>
		
			<?php 
		}
		?>
		
	</svg>
	
	
	<?php 
	if ($myCrowdfunding->getMustDisplayQRCode()) {
		
		?>
	
		<image xlink:href="<?php echo $myCrowdfunding->getQRCodePath(); ?>" 
			   width="<?php echo $qrCodeSize; ?>" 
			   height="<?php echo $qrCodeSize; ?>"
			   x="<?php echo $qrCodePosX; ?>" 
			   y="<?php echo $qrCodePosY; ?>" 
			   />
		
		<?php
	}
	?>
	
</svg>