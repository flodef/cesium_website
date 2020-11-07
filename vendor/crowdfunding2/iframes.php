<?php

require_once('Crowdfunding.class.php');


$availableParams = ['donorsNb', 'amountCollected', 'daysLeft', 'donorsList', 'donationsTable'];

$wishedParam = in_array($_GET['wishedParam'], $availableParams) ? $_GET['wishedParam'] : 'amountCollected';


$GETs = ['start_date', 'end_date', 'style'];

foreach ($GETs as $get) {

	if (!isset($_GET[$get])) {
		
		$_GET[$get] = NULL;
	}
}

$unit = isset($_GET['unit']) ? $_GET['unit'] : 'relative';

$myCrowdfunding = new Crowdfunding($_GET['pubkey'], $unit, $_GET['start_date'], $_GET['end_date']);




$validStyles = ['cloud'];

if (isset($_GET['style']) AND in_array($_GET['style'], $validStyles)) {
	
	$style = $_GET['style'];

} else {
	
	$style = 'default';
}



?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>test</title>
	<style>
		body, p {
			
			margin: 0;
			padding: 0;
			/*overflow: hidden;*/
		}
		
		p {
			
			text-align: center;
		}
		
		table {
			
			border-collapse: collapse;
			margin: auto;
		}
		
		td, th {
			
			border: 1px solid #ccc;
			padding: 0.333em 0.666em;
		}
		
		td.amount {
			
			text-align: right;
		}
		
		
		.donorsList.cloud-style {

			list-style-type: none;
			margin: 0 auto;
			padding: 0;
			max-width: 500px;
			text-align: center;
		}

		.donorsList.cloud-style li {

			display: inline;
		}

		.donorsList.cloud-style li .amount, 
		.donorsList.cloud-style li .sep {

			display: none;
		}
		
		.donorsList.default-style li {
			
			font-size: 1em !important; /* We shoud find a better way than using !important */
		}
		
	</style>
</head>
<body>
	  <?php
		switch ($wishedParam) {

			case 'donorsNb':
				
				echo '<p>' . $myCrowdfunding->getDonorsNb() . '</p>';
				
				break;
				
			case 'amountCollected':
				
				echo '
				<p>
					' . $myCrowdfunding->getAmountCollected() . '  ' . $myCrowdfunding->printUnit() . '
				</p>';
				
				break;
				
				
			case 'donorsList':
				
				$donationsList = $myCrowdfunding->getDonationsList();
				
				$min = $myCrowdfunding->getMinDonation();
				$max = $myCrowdfunding->getMaxDonation();
				
				if (empty($donationsList)) {
					
					echo _('Pas encore de donateurs');
					
				} else {
				
					echo '<ul class="donorsList '. $style .'-style">';
					
					foreach ($donationsList as $t) {
					
						echo '
						
						<li data-amount="'. round($t['amount'], 2) .'" style="font-size: '.  (1 + ($t['amount'] / $max) * 2) . 'em;">
							
							<span class="pubkey">
								'. substr($t['donor'], 0, 8) .'
							</span>
							
							<span class="sep"> : </span>
							
							<span class="amount">
								' . ceil($t['amount']/$myCrowdfunding->getLatestUDAmount()) . '&nbsp;'. $myCrowdfunding->printUnit();
								echo '
							</span>
						</li>';
					}
					
					echo '</ul>';
				}
				
				break;
				
				
			case 'donationsTable':
				
				$donationsList = $myCrowdfunding->getDonationsList();
				
				if (empty($donationsList)) {
					
					echo _('Pas encore de dons');
					
				} else {
				
					echo '<table>
					
					<tr>
						<th>Clef</th>
						<th>Commentaire</th>
						<th>Montant</th>
					</tr>';
					
					foreach ($donationsList as $t) {
					
						echo '
						
						<tr>
							<td>'. substr($t['donor'], 0, 8) . '</td>
							<td>';
								if (!empty($t['comment'])) {
									
									echo '<q>'. $t['comment'] .'</q>';
								}
								echo '
							</td>
							<td class="amount">
								' . ceil($t['amount']) . '&nbsp;'. $myCrowdfunding->printUnit() . '
							</td>
						</li>';
					}
				}
				
				echo '</table>';
				
				break;
			case 'daysLeft':
				break;
		}
	  ?>
</body>
</html>