<?php
	include('lib/phpqrcode/qrlib.php');
	$api_node = "g1.duniter.fr";
	$format_pubkey = "#^[123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz]{43,44}$#";
	$units = ["quantitative","relative"];
	$today = new DateTime();
	$format = "d/m/Y";
	function isDate(&$date, $format){
		$champsDate = date_parse_from_format($format, $date);
		$date = DateTime::createFromFormat($format, $date);
		return checkdate($champsDate["month"], $champsDate["day"], $champsDate["year"]);
	}
	
	$buttonLabel = !empty($_GET['buttonLabel']) ? urldecode($_GET['buttonLabel']) : "Je soutiens le projet !";

	// Vérification du node et des couleurs
	$node = (!empty($_GET["node"])) ? $_GET["node"] : "g1.duniter.org";
	$font_color = (!empty($_GET["font_color"])) ? "#" . $_GET["font_color"] : "#212529";
	$background_color = (!empty($_GET["background_color"])) ? "#" . $_GET["background_color"] : "transparent";
	$border_color = (!empty($_GET["border_color"])) ? "#" . $_GET["border_color"] : "transparent";
	$progress_color = (!empty($_GET["progress_color"])) ? "#" . $_GET["progress_color"] : "#ffc107";
	
	// Vérification des dates et calcul du nombre de jours entre la date du jour et la date de fin
	if (!empty($_GET["start_date"])){
		$start_date = $_GET["start_date"];
		$classcol = "col-4";
		if (!isDate($start_date, $format)){
			echo "<div>La date de début n'est pas correcte. Vérifiez votre syntaxe.</div>";
			exit;
		}
		$start_date->sub(new DateInterval('P1D'));
	}else{
		echo "<div>Il manque ladate de début. Vérifiez votre syntaxe.</div>";
		exit;
	}
	
	if (!empty($_GET["end_date"])){
		if ($_GET["end_date"] !=0){
			$end_date = $_GET["end_date"];
			$classcol = "col-3";
			if (!isDate($end_date, $format)){
				echo "<div>La date de fin n'est pas correcte. Vérifiez votre syntaxe.</div>";
				exit;
			}elseif ($end_date < $start_date) {
				echo "<div>La date de fin est antérieure à la date de début. Vérifiez votre syntaxe.</div>";
				exit;
			}elseif ($end_date < $today){
				$days_left = 0;
			}else{
				$dteDiff  = $end_date->diff($today);
				$days_left = $dteDiff->format("%a");
			}
		}
	}
	
	// Vérification du format de la pubkey
	if (!empty($_GET["pubkey"])){
		if (preg_match($format_pubkey, $_GET["pubkey"])){
			$pubkey = $_GET["pubkey"];
			$display_pubkey = (!empty($_GET["display_pubkey"]));
			$display_button = (!empty($_GET["display_button"]));
			$display_graph = (!empty($_GET["display_graph"]));
			// Génération du QRcode
			$display_qrcode = (!empty($_GET["display_qrcode"]));
			$qrcode_path = "qrcodes/" . $pubkey . ".png";
			if (($display_qrcode) && (!file_exists($qrcode_path))) {
				QRcode::png($pubkey, $qrcode_path);
			}
		}
		else {
			echo "<div>La pubkey n'a pas le format attendu. Vérifiez votre syntaxe.</div>";
			exit;
		}
	}else{
		echo "<div>Il manque la pubkey du compte à vérifier. Vérifiez votre syntaxe.</div>";
		exit;
	}

	// Vérification du format de la valeur cible à atteindre
	if (!empty($_GET["target"])){
		$target = (int)$_GET["target"];
		if (!is_int($target)){
			echo "<div>La cible n'est pas un entier. Vérifiez votre syntaxe.</div>";
			exit;
		}elseif ($target<=0){
			echo "<div>La cible est un entier négatif ou nul. Vérifiez votre syntaxe.</div>";
			exit;
		}
	}else{
		echo "<div>Il manque le montant à atteindre. Vérifiez votre syntaxe.</div>";
		exit;
	}

	// Récupération des transactions entrantes entre la date de début et la date du jour
	$url_json = "https://" . $node . "/tx/history/" . $pubkey . "/times/" . $start_date->getTimestamp() . "/" . $today->getTimestamp();
	$json = file_get_contents($url_json);
	$json = json_decode($json);
	$transactions = $json->history->received;
	$total = 0;
	$donneurs = [];
	$current_date = $start_date->format($format);
	$array_dates = [$current_date];
	$array_montants = [];
	foreach ($transactions as $transaction){
		$donneur = $transaction->issuers[0];
		if ($donneur != $pubkey){
			if(!in_array($donneur, $donneurs)){
				array_push($donneurs, $donneur);
			}
			$outputs = $transaction->outputs;
			foreach ($outputs as $output){
				if (strstr($output,$pubkey)){
					$timestamp = $transaction->blockstampTime;
					$date_transaction = date('d/m/Y', $timestamp);
					if ($date_transaction != $current_date){
						array_push($array_dates, $date_transaction);
						array_push($array_montants, $total);
						$current_date = $date_transaction;
					}
					$output = explode(":", $output);
					$montant = $output[0]/100;
					$total += $montant;
				}
			}
		}
	}
	array_push($array_montants, $total);
	$donors = count($donneurs);
	
	// Vérification de l'unité
	$unit = (!empty($_GET["unit"])) 
	    ? ((!in_array($_GET["unit"], $units)) ? "quantitative" : $_GET["unit"])
		: "quantitative";
	
	// Si l'unité est relative
	if ($unit == "relative"){
		// On récupère le dernier block qui contient le DU
		$url_json = "https://" . $node . "/blockchain/with/ud";
		$json = file_get_contents($url_json);
		$json = json_decode($json);
		$last_block_with_ud = end($json->result->blocks);
		
		// Puis on récupère le montant du DU
		$url_json = "https://" . $node . "/blockchain/block/" . $last_block_with_ud;
		$json = file_get_contents($url_json);
		$json = json_decode($json);
		$ud = $json->dividend/100;
		$total = round($total/$ud);
	}
	
	$percentage = round($total/$target*100);
	$contribution_url = "https://" . $api_node . "/api/#/v1/payment/" . $pubkey . "?amount=10|20|50|100|1000&amp;comment=don&amp;redirect_url=https%3A%252F%252F" . $api_node . "&amp;cancel_url=https%3A%252F%252F" . $api_node;

	if (!empty($_GET["addedStyles"])){
	
		$addedStyles = htmlspecialchars(urldecode($_GET["addedStyles"]));
		
	} else {
	
		$addedStyles = '';
		
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php if (!empty($_GET["title"])){echo $_GET["title"];}else{echo "Financement participatif en monnaie libre";} ?></title>
	<link rel="stylesheet" href="style.css">
	<style>
		body
		{
			color: <?php echo $font_color; ?>;
			background-color:<?php echo $background_color; ?>;	
		}
		
		input#pubkey
		{
			color: <?php echo $font_color; ?>;	
		}

		input#pubkey::selection
		{
			color: <?php echo $font_color; ?>;	
		}
		
		#progressbar
		{
			 border-color:<?php echo $border_color; ?> !important;
		}
		
		#progressbar .progress-bar
		{
			width:0%;
			background:<?php echo $progress_color; ?> !important;
		}
		
		#supportButton, 
		#copyButton
		{
			background-color: <?php echo $progress_color; ?>;
			color: black;
		}
		
		<?php
		
		echo $addedStyles;
		
		?>
	</style>
</head>
<body>
	<section class="wrapper-numbers">
		<div class="container">
			<div id="projectStatus">
				<div class="row">
					<div class="col">
						<?php if (!empty($_GET["title"])){echo "<h1>" . $_GET["title"] . "</h1>";} ?>
						<?php if ($display_qrcode){echo "<img src='" . $qrcode_path . "' alt='QRcode'>";} ?>
						<div id="progressbar" class="progress rounded-0">
							<div class="progress-bar progress-bar-animated" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only">0%</span>
								<!--<span class="number count replay" style="color: black; font-size: 1rem;"><?php echo $percentage?></span>%-->
							</div>
						</div>
					</div>
				</div>
				<div class="countup">
					<div>
						<p>
							<span class="number count replay"><?php echo $total; ?></span>
							<span class="number"><?php if ($unit == "relative"){echo " DU";} ?><span class="sub">Ğ1</span></span>
						</p>
						<p>déjà donnés sur un total de <?php echo $target; if ($unit == "relative"){echo " DU";} ?><span class="sub">Ğ1<br></span></p>
					</div>
					<div>
						<p><span class="number count replay"><?php echo $donors; ?></span></p>
						<p>donateurs</p>
					</div>
					<?php if (isset($end_date)){ ?>
					<div>
						<p><i class="far fa-calendar-alt" aria-hidden="true"></i></p>
						<p> <span class="number count replay"><?php echo $days_left; ?></span></p>
						<h3>jours restants</h3>
					</div>
					<?php } ?>
				</div>
			</div>
			
			<?php
			if ($display_pubkey) {
				?>
				<div id="supportButtonContainer">
					<button id="supportButton">
						<?php echo $buttonLabel; ?>
					</button>
				</div>
			
				<div id="pubkey-and-copy-button">
					<p class="pubkey">
						Pour faire un don copiez la clef suivante :

						<input id="pubkey" type="text" value="<?php echo $pubkey; ?>" size="8" />...
					</p>
					
					<p>
						<button id="copyButton">
							Copier la clef
						</button>
					</p>

					<p id="successMsg">
						Clef copiée dans le presse-papier ! Collez-la maintenant dans Cesium afin de faire votre don 😉<br />
						<span style="display: block; text-align: center;">Merci pour votre générosité ❤️</span>
						<span style="display: block; text-align: right;">Axiom-Team</span>
					</p>
				</div>
				<?php
			}
			?>
			
			<?php if ($display_button){ ?>
			<div class="row">
				<div class="col">
					<a class="btn btn-success" href="<?php echo $contribution_url; ?>" target="_blank" role="button" style="width: 100%;">
						<i class="fas fa-check"></i><span>&nbsp;Contribuez maintenant</span>
					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</section>
	<?php if ($display_graph){ ?>
	<script src="lib/js/chart.min.js"></script>
	<script>	
	window.onload = function() {
		var container = document.querySelector('.container');
		var data = <?php echo json_encode($array_montants); ?>;
		var div = document.createElement('div');
		div.classList.add('chart-container');
		var canvas = document.createElement('canvas');
		div.appendChild(canvas);
		container.appendChild(div);
		new Chart(canvas.getContext('2d'), {
			type: 'line',
			data: {
				labels: <?php echo json_encode($array_dates); ?>,
				datasets: [{
					label: 'Evolution du financement',
					steppedLine: false,
					data: data,
					borderColor: '#0099FF',
					fill: false,
				},
				{
					label: 'Objectif',
					steppedLine: false,
					data: Array.apply(null, new Array(<?php echo count($array_dates); ?>)).map(Number.prototype.valueOf, <?php echo $target; ?>),
					borderColor: 'rgb(255, 99, 132)',
					radius: 0,
					fill: false,
				}]
			},
			options: {
				responsive: true,
				animation: {
					duration: 1800,
					easing: 'easeInCubic'
				},
				title: {
					display: true
				}
			}
		});
	}
	</script>
	<?php } ?>
	<script src="lib/js/jquery-3.4.1.min.js"></script>
	<script src="lib/js/counter.js"></script>
	<script>
	$(document).ready(function(){	
		$(".progress-bar").animate({
			width: "<?php echo $percentage; ?>%"
		}, 1300, "");
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
		var pubkeyAndCopyButton = document.querySelector("#pubkey-and-copy-button");
		var projectStatus = document.querySelector("#projectStatus");
		var supportButtonContainer = document.querySelector("#supportButtonContainer");
		projectStatus.style.opacity = "0";
		projectStatus.style.height = "0";
		supportButtonContainer.style.opacity = "0";
		supportButtonContainer.style.height = "0";
		pubkeyAndCopyButton.style.height = "100%";
		pubkeyAndCopyButton.style.opacity = "1";
		
		/*successMsg.style.height = "3em";*/
	}

	document.querySelector("#copyButton").addEventListener("click", copy);
	document.querySelector("#supportButton").addEventListener("click", support);
	</script>
</body>
</html>