<div>

	<section class="stat amountCollected">
		<p> 
			<span class="count"><?php 
				
				echo round($myCrowdfunding->getMonthlyAmountCollectedMean($myCrowdfunding->getMonthsToConsider())); 
				
			?></span><span class="unit"><?php 
			
				echo '&nbsp;' . $myCrowdfunding->printUnit(); 
			
			?></span>
			
			<span class="label">
				<?php 
				echo sprintf(_('collectés en moyenne par mois'), $myCrowdfunding->getMonthsToConsider());
				?>
			</span>
		</p>
	</section>

	<section class="stat donorsMean">
		<p>
			<span class="count">
				<?php echo $myCrowdfunding->getPeriodDonorsMean($myCrowdfunding->getMonthsToConsider()); ?>
			</span>
			
			<span class="label">
				<?php 
					printf(_('mécènes réguliers chaque mois'), $myCrowdfunding->getMonthsToConsider());
				?>
			</span>
		</p>
	</section>

	<section class="stat donorsNb">
		<p>
			<span class="count">
				<?php 
					echo $myCrowdfunding->getPeriodDonorsNb($myCrowdfunding->getMonthsToConsider());
				?>
			</span>
			
			<span class="label">
				<?php 
					printf(_('mécènes au total sur les %s deniers mois'), $myCrowdfunding->getMonthsToConsider());
				?>
			</span>
		</p>
	</section>
</div>

<?php 
if ($myCrowdfunding->getMustDisplayButton()) {
	
	if ($myCrowdfunding->getButtonType() == 'api') {
		
	?>
	<p class="CTA-button">
		<a href="<?php echo $myCrowdfunding->getContributionURL(); ?>"
		   target="_blank" 
		   role="button">

			<?php echo sprintf(_('Je soutiens %s !'),  $myCrowdfunding->getTitle()); ?>
		</a>
	</p>

	<?php
		
	} else if ($myCrowdfunding->getButtonType() == 'copy') {
		
	} else {
		
		?>
		<p class="CTA-button" id="supportButtonContainer">
			<button id="supportButton">
				Encourager!
			</button>
		</p>

		<div id="pubkey-and-copy-button">
			<p class="pubkey">
				Pour faire un don copiez la clef suivante :

				<input id="pubkey" type="text" value="<?php echo $myCrowdfunding->getPubkey(); ?>" size="8" />...
			</p>

			<p class="CTA-button">
				<button id="copyButton">
					Copier la clef
				</button>
			</p>

			<p id="successMsg">
				Clef copiée dans le presse-papier ! Collez-la maintenant dans Cesium afin de faire votre don 😉<br>
			</p>
		</div>
		<?php
	}
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
<script>
	function copy() {
		
		var copyText = document.querySelector("#pubkey");
		copyText.select();
		document.execCommand("copy");
		
		var successMsg = document.querySelector("#successMsg");
		successMsg.style.opacity = "1";
		/*successMsg.style.height = "3em";*/
	}
	
	function support() {
		
		$(".stat, #supportButtonContainer").each(function( index ) {
 			
			console.log( index + ": " + $( this ).text() );
			this.style.opacity = "0";
			this.style.height = "0";
		});
		
		var pubkeyAndCopyButton = document.querySelector("#pubkey-and-copy-button");
		pubkeyAndCopyButton.style.height = "100%";
		pubkeyAndCopyButton.style.opacity = "1";
	}

	document.querySelector("#copyButton").addEventListener("click", copy);
	document.querySelector("#supportButton").addEventListener("click", support);
</script>
	
