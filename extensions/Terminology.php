<?php
/*
 * Copyright (C) 2007  BarkerJr and (C) 2008 Benjamin Kahn
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
 
/*
 * For nicer tooltips, download JavaScript, DHTML Tooltips from Walter Zorn at
 * http://www.walterzorn.com/tooltip/tooltip_e.htm or 
 * http://gualtierozorni.altervista.org/tooltip/tooltip_e.htm
 * and extract it to $wgScriptPath/extensions/tooltip/
 *
 * Use definition-lists in the Terminology page.  Place one definition on each line.  For example:
 * ;CS-S:CounterStrike Source, a game by Valve
 * ;HTML:HyperText Markup Language
 */
$wgExtensionCredits['parserhook'][] = array(
  'name' => 'Terminology',
  'description' => 'Provides tooltips from the [[Terminology]] defined for all instances of the given term',
  'version' => '20100729',
  'author' => 'BarkerJr modified by Benjamin Kahn (xkahn@zoned.net)'
);
 
$wgExtensionFunctions[] = 'terminologySetup';
function terminologySetup() {
  global $wgOut, $wgScriptPath;
  $wgOut->addHTML("<style text=\"text/css\" media=\"screen\"><!-- .terminologydef {border-bottom: 1px dashed green;} --></style>");
  if (is_file ('extensions/tooltip/wz_tooltip.js')) {
    $wgOut->addHTML("<script type='text/javascript' src='$wgScriptPath/extensions/tooltip/wz_tooltip.js'></script>");
  }
}
 
$wgHooks['ParserBeforeTidy'][] = 'terminologyParser';
function terminologyParser(&$parser, &$text) {
  global $wgRequest;
 
  $action = $wgRequest->getVal( 'action', 'view' );             
  if ($action=="edit" || $action=="ajax" || isset($_POST['wpPreview'])) return false;

  $rev = Revision::newFromTitle(Title::makeTitle(null, 'Terminology'));
  if ($rev) {
    $content = $rev->getText();
    if ($content != "") {
      $changed = false;
      $doc = new DOMDocument();
@     $doc->loadHTML('<meta http-equiv="content-type" content="charset=utf-8"/>' . $text);
      $c = explode("\n", $content);
      reset($c);
      while (list($key, $entry) = each($c)) { 
        $terms = explode(':', $entry, 2);
        if (@$terms[0][0] == ';') {
 
          // It's possible that the definition is on the next line
	  if (count($terms) == 1) {
	    list($k1, $e1) = each($c);
            if ($e1[0] == ':') {
	      $term = trim(substr($terms[0], 1));
	      $definition = trim(substr($e1, 1));
	    } else {
	      continue;
	    }
 
	  } elseif (count($terms) == 2) {
            $term = trim(substr($terms[0], 1));
            $definition = trim($terms[1]);
	  } else {
	    continue;
	  }
 
          if (terminologyParseThisNode($doc, $doc->documentElement, $term, $definition)) {
              $changed = true;
          }
        }
      }
      if ($changed) {
        $text = $doc->saveHTML();
      }
    }
  }
  return true;
}
 
function terminologyParseThisNode($doc, $node, $term, $definition) {
  $changed = false;
  if ($node->nodeType == XML_TEXT_NODE) {
    $texts = preg_split('/\b('.preg_quote($term).'s?)\b/u', $node->textContent, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (count($texts) > 1) {
      $container = $doc->createElement('span');
      for ($x = 0; $x < count($texts); $x++) {
        if ($x % 2) {
          $span = $doc->createElement('span', $texts[$x]);
 
	  if (!is_file ('extensions/tooltip/wz_tooltip.js')) {
	    $span->setAttribute('title', $term . ": " . $definition);
            $span->setAttribute('class', 'terminologydef');
	  } else {
            $bad = array ("\"", "'");
            $good = array ("\\\"", "\'");
	    $span->setAttribute('onmouseover', "Tip('".str_replace ($bad, $good, $definition)."', STICKY, true, DURATION, -1000, WIDTH, -600)");
	    $span->setAttribute('class', 'terminologydef');
	    $span->setAttribute('onmouseout', "UnTip()");
	  }
 
          $span->setAttribute('style', 'cursor:help');
          $container->appendChild($span);
        } else {
          $container->appendChild($doc->createTextNode($texts[$x]));
        }
      }
      $node->parentNode->replaceChild($container, $node);
      $changed = true;
    }
  } elseif ($node->hasChildNodes()) {
    // We have to do this because foreach gets confused by changing data
    $nodes = $node->childNodes;
    $previousLength = $nodes->length;
    for ($x = 0; $x < $nodes->length; $x++) {
      if ($nodes->length <> $previousLength) {
        $x += $nodes->length - $previousLength;
      }
      $previousLength = $nodes->length;
      $child = $nodes->item($x);
      if (terminologyParseThisNode($doc, $child, $term, $definition)) {
        $changed = true;
      }
    }
  }
  return $changed;
}
