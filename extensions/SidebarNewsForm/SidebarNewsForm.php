<?php

if ( !defined('MEDIAWIKI')) {
 die ('Sidebar Form extension');
}

$wgExtensionCredits[''][] = array(
	'path' => __PATH__,
	'name' => 'Sidebar News Form',
	'author' => 'Mike Poltyn'
);

$wgHooks['BeforePageDisplay'][] = 'fnAddSidebarNewsFiles';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'fnAddSidebarNewsFormToSidebar';

function fnAddSidebarNewsFiles( &$out, &$skin ) {
	global $wgScriptPath;
	$basePath = $wgScriptPath .'/extensions/SidebarNewsForm/';
	$out->addScript('<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.validate.js"></script>');
	$out->addScript('<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.form.js"></script>');
        $out->addScript('<script type="text/javascript" src="'.$basePath.'snf.js"></script>');
	$out->addStyle($basePath . 'snf.css');
}

function fnAddSidebarNewsFormToSidebar(&$skin, &$tpl) {
	
}
