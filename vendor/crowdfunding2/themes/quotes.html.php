<?php

define('DEFAULT_FILTER_MIN_COMMENT_LENGTH', 10);
define('DEFAULT_FILTER_MIN_DONATION', (1 * $myCrowdfunding->getUdAmount($myCrowdfunding->getStartDate())));

if (isset($_GET['min_comment_length'])) {
	
	$myCrowdfunding->setFilterMinCommentLength($_GET['min_comment_length']);

} else {
	
	$myCrowdfunding->setFilterMinCommentLength(DEFAULT_FILTER_MIN_COMMENT_LENGTH);
}

if (isset($_GET['min_donation_amount'])) {
	
	$myCrowdfunding->setFilterMinDonation($_GET['min_donation_amount']);

} else {
	
	$myCrowdfunding->setFilterMinDonation(DEFAULT_FILTER_MIN_DONATION);
}





$donationsList = array_reverse($myCrowdfunding->getDonationsList());


if (empty($donationsList)) {

	echo '<p>' . _('Pas encore de citation.') . '</p>';

} else {


	foreach ($donationsList as $t) {
		
		echo '

		<blockquote>';
			
			echo $t->getComment();

			echo '

			<cite>'. $myCrowdfunding->getDonorCesiumPlusProfile($t->getDonorPubkey())->getName() .'</cite>
			
			<time datetime="'. $t->getDate()->format("Y-m-d") . '"></time>

		</blockquote>';
	}
	
}


