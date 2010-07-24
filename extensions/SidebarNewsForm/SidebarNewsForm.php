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
	$out->addScript('<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.validate.js"></script>');
	$out->addScript('<script type="text/javascript" src="http://downloads.mailchimp.com/js/jquery.form.js"></script>');
        $out->addScript('<script type="text/javascript" src="'.$basePath.'snf.js"></script>');
	$out->addStyle($basePath . 'snf.css');
	return true;
}

function fnAddSidebarNewsFormToSidebar(&$skin, &$tpl) {
	$html = '<div id="mc_embed_signup">
<form action="http://geneabase.us1.list-manage.com/subscribe/post?u=30f13c78ab863e816fd5cf7f8&amp;id=564ae5a12a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" style="font-size: 10px;">
<div class="indicate-required" style="text-align: right;font-style: italic;overflow: hidden;color: #000;">* indicates required</div>
<div class="mc-field-group" style="clear: both;overflow: hidden;">
<label for="mce-EMAIL" style="display: block;margin: .3em 0;line-height: 1em;">Email Address <strong class="note-required">*</strong>
</label>
<input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL" style="margin-right: 1.5em;padding: .2em .3em;width: 90%;float: left;z-index: 999;">
</div>
<div class="mc-field-group" style="clear: both;overflow: hidden;">
<label for="mce-FNAME" style="display: block;margin: .3em 0;line-height: 1em;">First Name </label>
<input type="text" value="" name="FNAME" class="" id="mce-FNAME" style="margin-right: 1.5em;padding: .2em .3em;width: 90%;float: left;z-index: 999;">
</div>
<div class="mc-field-group" style="clear: both;overflow: hidden;">
<label for="mce-LNAME" style="display: block;margin: .3em 0;line-height: 1em;">Last Name </label>
<input type="text" value="" name="LNAME" class="" id="mce-LNAME" style="margin-right: 1.5em;padding: .2em .3em;width: 90%;float: left;z-index: 999;">
</div>
  <div id="mce-responses" style="float: left;top: -1.4em;padding: 0em .5em 0em .5em;overflow: hidden;width: 90%;margin: 0 5%;clear: both;">
   <div class="response" id="mce-error-response" style="display: none;margin: 1em 0;padding: 1em .5em .5em 0;font-weight: bold;float: left;top: -1.5em;z-index: 1;width: 80%;background: #FBE3E4;color: #D12F19;"></div>
   <div class="response" id="mce-success-response" style="display: none;margin: 1em 0;padding: 1em .5em .5em 0;font-weight: bold;float: left;top: -1.5em;z-index: 1;width: 80%;background: #E3FBE4;color: #529214;"></div>
  </div>
  <div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn" style="clear: both;width: auto;display: block;margin: 1em 0 1em 5%;"></div>
 <a href="#" id="mc_embed_close" class="mc_embed_close" style="display: none;">Close</a>
</form>
</div>';
	$sidebar = array('news-form-sidebar' => $html);
	# set sidebar to new thing:
	$tpl->set( 'sidebar', array_merge($tpl->data['sidebar'],$sidebar) );
	return true;
}

