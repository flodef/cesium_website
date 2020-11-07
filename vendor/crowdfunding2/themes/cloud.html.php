<?php

$donationsList = $myCrowdfunding->getDonationsList(true);

$min = $myCrowdfunding->getMinDonation();
$max = $myCrowdfunding->getMaxDonation();

if (empty($donationsList)) {

	echo _('Pas encore de donateurs');

} else {
	
	echo '<ul class="donorsList">';

	foreach ($donationsList as $donation) {

		echo '

		<li style="font-size: '.  (1 + ($donation->getAmount() / $max) * 2) . 'em;">
		
			<span>
				<a href="https://demo.cesium.app/#/app/wot/'. $donation->getDonorPubkey() .'/">
					'. $myCrowdfunding->getDonorCesiumPlusProfile($donation->getDonorPubkey())->getName() .'
				</a>
			</span>
			
		</li>';
	}

	echo '</ul>';
}

