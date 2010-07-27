<?php

if ( !defined('MEDIAWIKI')) {
 die ('Sidebar Form extension');
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Sidebar News Form',
	'author' => 'Mike Poltyn'
);

$wgHooks['BeforePageDisplay'][] = 'fnAddSidebarNewsFiles';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'fnAddSidebarNewsFormToSidebar';

function fnAddSidebarNewsFiles( &$out, &$skin ) {
	global $wgScriptPath;
	$basePath = $wgScriptPath .'/extensions/SidebarNewsForm/';
	$out->addScript('<script type="text/javascript" src="/mailchimp/jquery.validate.js"></script>');
	$out->addScript('<script type="text/javascript" src="/mailchimp/jquery.form.js"></script>');
        $out->addScript('<script type="text/javascript" src="'.$basePath.'snf.js"></script>');
	$out->addStyle($basePath . 'snf.css');
	return true;
}

function fnAddSidebarNewsFormToSidebar(&$skin, &$tpl) {
	$html = '<div id="mc_embed_signup">
<form action="http://geneabase.us1.list-manage.com/subscribe/post?u=30f13c78ab863e816fd5cf7f8&amp;id=564ae5a12a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" style="font-size: 10px;">
<div class="indicate-required">* indicates required</div>
<div class="mc-field-group">
<label for="mce-EMAIL">Email Address <strong class="note-required">*</strong>
</label>
<input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL">
</div>
<div class="mc-field-group">
<label for="mce-FNAME">First Name </label>
<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
</div>
<div class="mc-field-group">
<label for="mce-LNAME">Last Name </label>
<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
</div>
  <div id="mce-responses">
   <div class="response" id="mce-error-response"></div>
   <div class="response" id="mce-success-response"></div>
  </div>
  <div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn"></div>
 <a href="#" id="mc_embed_close" class="mc_embed_close" style="display: none;">Close</a>
</form>
</div>';
	$sidebar = array('news-form-sidebar' => $html);
	# set sidebar to new thing:
	$tpl->set( 'sidebar', array_merge($tpl->data['sidebar'],$sidebar) );
	return true;
}

