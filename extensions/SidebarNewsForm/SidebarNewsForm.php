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
$wgHooks['SkinBuildSidebar'][] = 'fnAddSidebarNewsFormToSidebar';

function fnAddSidebarNewsFiles( &$out, &$skin ) {
	global $wgScriptPath;
	$basePath = $wgScriptPath .'/extensions/SidebarNewsForm/';
	$out->addScript('<script type="text/javascript" src="/mailchimp/jquery.validate.js"></script>');
	$out->addScript('<script type="text/javascript" src="/mailchimp/jquery.form.js"></script>');
        $out->addScript('<script type="text/javascript" src="'.$basePath.'snf.js"></script>');
	$out->addStyle($basePath . 'snf.css');
	return true;
}

function fnAddSidebarNewsFormToSidebar(&$skin, &$bar) {
	$html = '<div id="mc_embed_signup">
<form action="http://geneabase.us1.list-manage.com/subscribe/post?u=30f13c78ab863e816fd5cf7f8&amp;id=564ae5a12a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
<div class="indicate-required">* indicates required</div>
<div class="mc-field-group">
<label for="mce-EMAIL">Email Address <strong class="note-required">*</strong>
</label>
<input type="text" value="" name="EMAIL" class="required email" id="mce-EMAIL" onfocus="document.getElementById(\'toggle-mailinglist\').style.display = \'block\';">
</div>
<div id="toggle-mailinglist" style="display: none;">
<div class="mc-field-group">
<label for="mce-FNAME">First Name </label>
<input type="text" value="" name="FNAME" class="" id="mce-FNAME">
</div>
<div class="mc-field-group">
<label for="mce-LNAME">Last Name </label>
<input type="text" value="" name="LNAME" class="" id="mce-LNAME">
</div>
<div class="mc-field-group">
    <label class="input-group-label" style="display: block;margin-top: .4em 0; margin-bottom: 0;">Keep me updated on: </label>
    <div class="input-group" style="padding: .7em .7em .7em 0;font-size: .9em;margin: 0 0 1em 0;">
      <ul style="margin: 0;padding: 0;"><li style="list-style: none;overflow: hidden;padding: .2em 0;clear: left;display: block;margin: 0; font-size: 1.2em;"><input type="radio" value="1" name="group" id="mce-group-1-0" style="margin-right: 2%;padding: .2em .3em;width: auto;float: left;z-index: 999;"><label for="mce-group-1-0" style="display: block;margin: .4em 0 0 0;line-height: 1em;width: auto;float: left;text-align: left;">product releases only</label></li>
<li style="list-style: none;overflow: hidden;padding: .2em 0;clear: left;display: block;margin: 0; font-size: 1.2em;"><input type="radio" value="2" name="group" id="mce-group-1-1" style="margin-right: 2%;padding: .2em .3em;width: auto;float: left;z-index: 999;"><label for="mce-group-1-1" style="display: block;margin: .4em 0 0 0;width: auto;float: left;text-align: left;">all project news</label></li>
     </ul>
    </div>
</div>
</div>
  <div id="mce-responses">
   <div class="response" id="mce-error-response"></div>
   <div class="response" id="mce-success-response"></div>
  </div>
  <div><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="btn"></div>
 <a href="#" id="mc_embed_close" class="mc_embed_close" style="display: none;">Close</a>
</form>
</div>';
	$bar['news-form-sidebar'] = $html;
	return true;
}

