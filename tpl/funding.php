<?php

if (FUNDING_ALT) {
	
	include('tpl/funding-alt-1.php');	
	
} else {
	
	include('tpl/funding-orig.php');
	
}


?>



<script src="<?php echo $rootURL; ?>/lib/jquery-3.4.1.min.js"></script>

<?php

include('foot.php');

