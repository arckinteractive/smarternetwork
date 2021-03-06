<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne
 * @copyright slyhne 2010-2011
 * @link www.zurf.dk/elgg
 * @version 1.8
 *
 * Modified by Kevin Jardine for arckinteractive.com
 */

// Make sure we're logged in
gatekeeper();

// Get input data
$guid = get_input('guid');
$h = get_input('h');
$level = get_input('level');
$item = get_input('item');

$entity = get_entity($guid);

if (elgg_instanceof($entity,'object','market') && $entity->canEdit()) {
	
  // process custom actions first
  // allows for error checking, relationships etc.
  if (file_exists(dirname(__FILE__) . "/custom/{$entity->marketcategory}/{$level}.php")) {
	  include dirname(__FILE__) . "/custom/{$entity->marketcategory}/{$level}.php";
  }

 // TODO: this won't work for some field types, eg. files, and tags
  foreach ($item as $key => $value) {
		$entity->$key = $value;
  }

  $new_h = $h . '/' . $item[$level];

  system_message(elgg_echo('market:edit_more:response'));

  if (elgg_view_exists("forms/market/edit".$new_h)) {
    forward("market/edit_more/{$entity->guid}{$new_h}");
  } else {
    // Forward to the main market page
    forward("market");
  }
} else {
  register_error(elgg_echo('market:edit_more:invalid_guid'));
  forward("market/edit_more/{$entity->guid}{$h}");
}
