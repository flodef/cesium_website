<?php
textdomain('legal-notice');

$pageTitle = _("Mentions légales");
$pageDescription = _("");

include('head.php');

?>


<article id="legal-notice">
	<h1><?php echo _("Mentions légales"); ?></h1>
	
	<section class="text-box">
		<dl>
			<dt><?php echo _('Éditeur'); ?></dt>
			<dd>
				<p><?php echo _('Ce site est édité par&nbsp;:'); ?></p>
				
				<p><?php echo $legalNotice['editor']; ?></p>
			</dd>
			
			<dt><?php echo _('Responsable de la publication'); ?></dt>
			<dd>
				<p><?php echo $legalNotice['publisher']; ?></p>
			</dd>
			
			<dt><?php echo _('Hébergeur'); ?></dt>
			<dd>
				<p><?php echo $legalNotice['host']; ?></p>
			</dd>
		</dl>
	</section>
</article>

<?php


include('foot.php');
