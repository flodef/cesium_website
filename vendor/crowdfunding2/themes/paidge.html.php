<header>
	<?php 
	if (!$myCrowdfunding->getMustHideTitle()) {

		echo '

		<h1>
			' . $myCrowdfunding->getTitle() . '
		</h1>';
	}
	?>

	<?php 

	if ($myCrowdfunding->getMustDisplayPubkey()) {

		echo '

		<p class="pubkey">
			' . sprintf(_('Clef publique du compte&nbsp;: %s'), $myCrowdfunding->getPubkey()) . '
		</p>';

	}

	if ($qrCodePath = $myCrowdfunding->getQRCodePath()) { 

		echo '<p><img src="' . $qrCodePath . '" alt="'. _('QRcode du portefeuille') .'" /></p>';

	} ?>
</header>

<div id="main">

<section class="progress-container">
	
	<div class="progress-bar" 
		 aria-valuenow="<?php echo $myCrowdfunding->getPercentage(); ?>" 
		 aria-valuemin="0" 
		 aria-valuemax="100" 
		 style="width:0%;">
		
		<span class="sr-only">
			<?php echo $myCrowdfunding->getPercentage(); ?>%
		</span>
		
	</div>
	
</section>


<section class="stats">
	
	<section class="reached">
		<p>
			<span class="count">
				<?php echo $myCrowdfunding->getPercentage();?>
			</span>&nbsp;%
			
			<span class="label">
				<?php echo _('atteints'); ?>
			</span>
		</p>
	</section>

	<section class="donorsNb">
		<p>
			<span class="count">
				<?php echo $myCrowdfunding->getDonorsNb(); ?>
			</span>
			
			<span class="label">
				<?php echo _('donateurs'); ?>
			</span>
		</p>
	</section>

	<section class="amountCollected">
		<p> 
			<span class="count">
				<?php echo round($myCrowdfunding->getAmountCollected()); ?>
			</span>
			
			<?php echo $myCrowdfunding->printUnit(); ?>
			
			<span class="label">
				<?php 
				if ($myCrowdfunding->hasTarget()) {
					
					echo sprintf(_('sur un total de %s %s'), $myCrowdfunding->getTarget(), $myCrowdfunding->printUnit());
				}
				?>
			</span>
		</p>
	</section>

	<?php 
	
	if (!$myCrowdfunding->hasStartedYet()) {
	
		?>
		<section class="daysLeft">
			<p>
				<span class="count">
					?
				</span>
				
				<span class="label">
					<?php 
						
						printf(
						
						       _('Cette campagne débutera le %s'), 
						       
						       strftime('%x', 
						                $myCrowdfunding->getStartDate()->getTimestamp()
						               )
						      ); 
					?>
				</span>
			</p>
		</section>
		<?php
	
	} else { 
		
		if ($myCrowdfunding->isEvergreen() != 'forever') {
	
			$daysLeft = $myCrowdfunding->getDaysLeft();
			
			?>
			<section class="daysLeft">
				<p>
				<?php
				
				if ($myCrowdfunding->isOver()) {
					
					$daysPassed = abs($daysLeft) + 1;
					
					?>
						<span>
							<?php echo _('Finie !'); ?>
						</span>

						<span class="label">
							<?php 
								
								printf(
									ngettext(
										_('cette campagne est terminée depuis hier soir.'), 
										_('cette campagne est terminée depuis %s jours.'), 
										$daysPassed
									), 
									$daysPassed
								); 
							?>
						</span>
					<?php


				} else {
					
					?>
						<span class="count">
							<?php echo $daysLeft; ?>
						</span>
						
						<span class="label">
							<?php 
								
								printf(
									ngettext(
										_('il reste jusqu\'à minuit pour contribuer'), 
										_('il reste %s jours pour contribuer'), 
										$daysLeft
									), 
									$daysLeft
								); 
							?>
						</span>
					<?php
				}
				?>
				</p>
			</section>
		<?php 
		}
	} 
	?>

</section>

<?php 
if ($myCrowdfunding->getMustDisplayButton()) {
	?>
	<p class="CTA-button">
		<a class="btn btn-success" 
		   href="<?php echo $myCrowdfunding->getContributionURL(); ?>"
		   target="_blank" 
		   role="button">

			<?php echo _('Contribuer maintenant !'); ?>
		</a>
	</p>
	<?php
	}
?>
	
</div>


<?php 
if (isset($chart)) {
	
	$targetGraph = new Graph($chart->getTargetLinePoints(), _('Objectif'));
	$targetGraph->setStyle('type', 'line');
	$targetGraph->setStyle('borderColor', '#FF3E3D');
	$targetGraph->setStyle('borderDash', [5, 5]);
	$targetGraph->setStyle('radius', 0);
	$targetGraph->setStyle('fill', false);
	$chart->addGraph($targetGraph);
	
	$amountDailyGraph = new Graph($chart->getAmountCollectedByDayPoints(), _('Contributions du jour'));
	$amountDailyGraph->setStyle('type', 'bar');
	$amountDailyGraph->setStyle('borderColor', 'rgba(0,200,100,0.7)');
	$amountDailyGraph->setStyle('backgroundColor', 'rgba(96,200,120,0.7)');
	$amountDailyGraph->setStyle('borderWidth', 2);
	$chart->addGraph($amountDailyGraph);
	
	$amountCumulativeGraph = new Graph($chart->getAmountCollectedByDayCumulativePoints(), _('Montant total récolté'));
	$amountCumulativeGraph->setStyle('type', 'line');
	$amountCumulativeGraph->setStyle('borderColor', '#0099FF');
	$amountCumulativeGraph->setStyle('backgroundColor', '#80CCFF');
	$amountCumulativeGraph->setStyle('lineTension', 0);
	$amountCumulativeGraph->setStyle('pointRadius', 1);
	$amountCumulativeGraph->setStyle('borderWidth', 2);
	$amountCumulativeGraph->setStyle('steppedLine', true);
	$chart->addGraph($amountCumulativeGraph);
	
	
	echo $chart->getScripts($lang, '#main');
}
?>

<script src="lib/js/jquery-3.4.1.min.js"></script>
<script src="lib/js/counter.js"></script>
<script>
$(document).ready(function(){	

	$('.progress-bar').animate({

		width: '<?php echo $myCrowdfunding->getPercentage(); ?>%'

	}, 1300, '');
});
</script>
	
