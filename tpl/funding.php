<?php

if (FUNDING_ALT) {
	
	include('tpl/funding-alt-1.php');	
	
} else {
	
	include('tpl/funding-orig.php');
	
}


?>


<script>
function copy() {
	
	var copyText = document.querySelector("#pubkey");
	copyText.select();
	document.execCommand("copy");

	var successMsg = document.querySelector("#successMsg");
	successMsg.style.opacity = "1";
	/*successMsg.style.height = "3em";*/

	var copyButton = document.querySelector("#copyButton");
	copyButton.style.animation = "none";
	
}

function support() {
	
	var pubkeyAndCopyButton = document.querySelector("#pubkey-and-copy-button");
	var supportButtonContainer = document.querySelector("#supportButtonContainer");
	supportButtonContainer.style.opacity = "0";
	supportButtonContainer.style.height = "0";
	pubkeyAndCopyButton.style.height = "100%";
	pubkeyAndCopyButton.style.opacity = "1";
	
	var supportButton = document.querySelector("#supportButton");
	$(this).style.animation = "none";
}

document.querySelector("#copyButton").addEventListener("click", copy);
document.querySelector("#supportButton").addEventListener("click", support);
</script>

<script src="<?php echo $rootURL; ?>/lib/jquery-3.4.1.min.js"></script>
<script>
$(document).ready(function(){	

	$('.progress-bar').animate({

		width: '<?php echo $portionReached; ?>%'

	}, 1300, '');
});
</script>

<?php

include('foot.php');

