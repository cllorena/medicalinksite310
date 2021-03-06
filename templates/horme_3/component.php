<?php
/**
* @package Horme 3 template
* @author Spiros Petrakis
* @copyright Copyright (C) 2015 - 2022 Spiros Petrakis. All rights reserved.
* @license GNU General Public License version 2 or later
*
*/

defined('_JEXEC') or die;
JHtml::_('jquery.framework');
JHtml::_('bootstrap.framework');
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$view = $app->input->getCmd('view');
$option = $app->input->getCmd('option');
$tmpl = $app->input->getCmd('tmpl');
$layout = $app->input->getCmd('layout');

if ( $layout =='modal' || $option == 'com_media' ) {
  $doc->addStyleSheet(JURI::root(true).'/administrator/templates/isis/css/template.css');
} else {
  include_once JPATH_THEMES.'/'.$this->template.'/logic.php'; // load logic.php
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="robots" content="noindex, nofollow" />
	<jdoc:include type="head" />
	<?php if ($option == 'com_media') { ?>
	<style>
	body{
		padding: 0;
	}

	.row{
		margin-left: 0;
	}

	.row-fluid .span6 {
		width: 48%;
	}

	.thumbnails > li {
		float: left;
		margin-left: 5px;
	}
	</style>
	<?php } ?>

	<?php if ($app->input->getVar( 'print' ) == 1) { ?>
	<link rel="stylesheet" href="<?php echo $tpath; ?>/css/print.css" type="text/css" />
	<style>
	.back-to-category,
	.product-fields,
	.ask-a-question,
	.addthis_toolbox,
	.next-page,
	.previus-page,
	.addtocart-bar,
	.icons,
	.product-neighbours {
		display: none;
	}

	a[href^="/"]:after{
	content:"";
	}
	</style>
	<?php } ?>

	<?php if ($this->params->get('customcss')) : ?>
	<link rel="stylesheet" href="<?php echo $tpath; ?>/css/custom.css" type="text/css" />
	<?php endif; ?>
</head>
<body class="contentpane tmpl" style="background: none !important;">
	<div class="container-fluid" style="box-shadow:none !important; border:none !important; background: none !important;">
		<div class="row">
			<div class="col-md-12 span12">
			<jdoc:include type="message" />
			<jdoc:include type="component" />
			</div>
		</div>
	</div>
</body>
</html>
