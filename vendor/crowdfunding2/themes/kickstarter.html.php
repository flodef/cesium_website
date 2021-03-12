<section class="progress-container">
	
	<div class="progress-bar" 
		 aria-valuenow="<?php echo $myCrowdfunding->getPercentage(); ?>" 
		 aria-valuemin="0" 
		 aria-valuemax="100" 
		 style="width:0%;">
		
		<span class="sr-only">
			<?php echo $myCrowdfunding->getPercentage(); ?>
		</span>
		
	</div>
	
</section>


<section class="stats">

	<section class="amountCollected">
		<p> 
			<span class="count">
				<?php echo round($myCrowdfunding->getAmountCollected()); ?>
			</span>
			
			<?php echo $myCrowdfunding->printUnit(); ?>
			
			<span class="label">
				<?php 
				echo sprintf(_('déjà donnés sur un total de %s %s'), $myCrowdfunding->getTarget(), $myCrowdfunding->printUnit());
				?>
			</span>
		</p>
	</section>

	<section class="donorsNb">
		<p>
			<span class="count">
				<?php echo $myCrowdfunding->getDonorsNb(); ?>
			</span>
			
			<span class="label">
				<?php echo _('donateurs') ?>
			</span>
		</p>
	</section>

	<?php 
	if (($daysLeft = $myCrowdfunding->getDaysLeft()) !== NULL) { 
		?>
		<section class="daysLeft">
			<p>
				<?php
				if ($daysLeft < 0) {
					
					$daysPassed = abs($daysLeft);
					?>
						<span>
							<?php echo _('Finie !'); ?>
						</span>

						<span class="label">
							<?php 
								printf(
									ngettext(
										_('Cette campagne est terminée depuis hier.'), 
										_('Cette campagne est terminée depuis %d jours.'), 
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
						<?php echo _('jours restants'); ?>
					</span>
					<?php
				}
				?>
			</p>
		</section>
		<?php 
	} 
	?>

</section>

<?php 
if ($myCrowdfunding->getMustDisplayButton()) {
	?>
	<p class="CTA-button btn btn-success">
		<a href="<?php echo $myCrowdfunding->getContributionURL(); ?>"
		   target="_blank" 
		   role="button">

			<?php echo sprintf(_('Je soutiens %s !'),  $myCrowdfunding->getTitle()); ?>
		</a>
	</p>
	<?php
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

