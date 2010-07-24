<?php
/**
 * This script purges sidebar while using CustomNavBlocks extension.
 * 
 * Usage: put this file in crontab, so it can run once a day.
 *
 * @file
 * @ingroup Maintenance
 */

$wgUseNormalUser = true;
require_once( 'commandLine.inc' );

$wgTitle = Title::newFromText( 'PurgeSidebar.php' );

$translator = new MediaWiki_I18N();

$CustomNavBlocksRaw = $translator->translate( 'CustomNavBlocks' );
$CustomNavBlocksClean = trim( preg_replace( array('/<!--(.*)-->/s'), array(''), $CustomNavBlocksRaw ) );
$blocks = explode( "\n", $CustomNavBlocksClean );
foreach ($blocks as $block) {
	$tmp = explode( '|', $block );
        // Work only for real custom blocks
        if ( count( $tmp ) != 2 ) {
              continue;
        }

	$title = Title::newFromText( $tmp[0], NS_MEDIAWIKI );
	// If page doesn't exist, silently continue
	if ( is_null( $title ) ) {
		continue;
	}
	if ( !$title->exists() ) {
		continue;
	}
	$block = new Article( $title );
	// force purging the sidebar
	$block->doPurge();
}
