<?php

$donors = $myCrowdfunding->getDonors();

if (empty($donors)) {

	echo _('Pas encore de donateurs');

} else {
	
	echo '<ul class="donorsList">';

	foreach ($donors as $donor) {
		
		$donorProfile = $myCrowdfunding->getDonorCesiumPlusProfile($donor);
		
		echo '

		<li>';
			echo '
			<a href="https://demo.cesium.app/#/app/wot/'. $donor .'/">';
				
				$avatar = $donorProfile->getAvatar();
				
				if (!empty($avatar)) {
					
					echo '<img src="data:'. $avatar->getContentType(). ';base64, '. $avatar->getContent() .'" />';
				
				} else {
					
					echo '<img src="'. DEFAULT_AVATAR .'" />';
				}
				
				
				echo '
				<span class="name">
					<span>
						'. $donorProfile->getName() .'
					</span>
				</span>
			</a>
			
		</li>';
	}

	echo '</ul>';
}

