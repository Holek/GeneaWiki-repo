<?php

/*
 * Sidebar Fixes
 *
 * This extension works with CustomNavBlocks to add sidebar blocks CustomNavBloxks deletes
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the SidebarFixes extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/SidebarFixes/SidebarFixes.php" );
EOT;
	exit( 1 );
}

$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Sidebar Fixes',
	'author' => 'Mike Poltyn'
);

# ============================================================

# Hooks

if ( isset( $wgCollectionVersion ) ) {
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'fnAddCollectionSidebarBlock';
}

function fnAddCollectionSidebarBlock( &$out, &$skin ) {
	$tpl->set( 'sidebar', array_merge($tpl->data['sidebar'],array('coll-print_export'=> CollectionHooks::getPortlet())));
}

