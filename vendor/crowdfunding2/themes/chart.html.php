<div id="chart"></div>
<?php 
if (isset($chart)) {
	
	$targetGraph = new Graph($chart->getTargetLinePoints(), _('Objectif'));
	$targetGraph->setStyle('type', 'line');
	$targetGraph->setStyle('borderColor', 'green');
	$targetGraph->setStyle('borderDash', [5, 5]);
	$targetGraph->setStyle('radius', 0);
	$targetGraph->setStyle('fill', false);
	$chart->addGraph($targetGraph);
	
	$amountCumulativeGraph = new Graph($chart->getAmountCollectedByDayCumulativePoints(), _('Montant total récolté'));
	$amountCumulativeGraph->setStyle('type', 'line');
	$amountCumulativeGraph->setStyle('borderColor', '#301873');
	$amountCumulativeGraph->setStyle('backgroundColor', '#301873');
	$amountCumulativeGraph->setStyle('lineTension', 0);
	$amountCumulativeGraph->setStyle('pointRadius', 1);
	$amountCumulativeGraph->setStyle('borderWidth', 2);
	$amountCumulativeGraph->setStyle('steppedLine', false);
	$chart->addGraph($amountCumulativeGraph);
	
	
	echo $chart->getScripts($lang, '#chart');
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
	
