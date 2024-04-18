<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Handle settings navigation items
 *
 * @package local_sitesetting
 * @copyright 2020 Akash Uphade (akash.u@paradisosolutions.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @paradiso 
 */

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once(dirname(__FILE__) . '/locallib.php');

redirect_if_major_upgrade_required();

// Force login
if (!empty($CFG->forcelogin)) {
    require_login();
}

$context = context_system::instance();

// Set page context.
$PAGE->set_context($context);

$hassiteconfig = has_capability('moodle/site:config', $context);

if ($hassiteconfig && moodle_needs_upgrading()) {
    redirect(new moodle_url($CFG->wwwroot . '/admin/index.php'));
}

// If site registration needs updating, redirect.
\core\hub\registration::registration_reminder($CFG->wwwroot . '/admin/search.php');


// Save the settings
if ($data = data_submitted() and confirm_sesskey() and isset($data->action) and $data->action == 'save-sitesetting') {
//print_object($data);exit;
	
	// Initialise the arrays
	$supersettingarray = [];
	$parentsettingarray = [];

	$roleid = $data->role;

	$counter = 0;

	// Loop through submitted data and form required structure
	foreach ($data as $key => $value) {
		

		// Skip session key, action and role field
		if (in_array($key, ['sesskey', 'action', 'role']) || $value === 'on') {
			continue;
		}

		// This array will have three values
		// 1 - setting name with link
		// 2 - settings parent name with link
		// 3 - main tab of the settings
		$elementmetadata = explode('--', $value);
		
		$setting = $elementmetadata[0];
		$parentsetting = $elementmetadata[1];
		$superparent = $elementmetadata[2];
		

		// Create tree structure
		if ( !array_key_exists($superparent, $supersettingarray) || !in_array($parentsetting, $supersettingarray[$superparent]) ) {
			$supersettingarray[$superparent][] = $parentsetting;	
		}

		if ( !array_key_exists($parentsetting, $parentsettingarray) || !in_array($setting, $parentsettingarray[$parentsetting]) ) {
			$parentsettingarray[$parentsetting][] = $setting;
		}

	}


	// First delete all the setting items before inserting new settings for role
	$DB->delete_records('local_sitesetting', ['role_id' => $roleid]);

	// Insert the records for the settings in the table
	foreach ($supersettingarray as $superparent => $parent) {
		
		// Object for superparent element
		$settingobj = new stdClass();
		$settingobj->role_id = $roleid;
		$settingobj->setting = $superparent;
		$settingobj->parent_id = 0;
		$settingobj->level = 1;

		// Insert super parent element
		$superparentid = $DB->insert_record('local_sitesetting', $settingobj);


		foreach ($parent as $key => $value) {
			
			$settingparentarr = explode("__", $value);
			
			// Object for parent element
			$settingobj = new stdClass();
			$settingobj->role_id = $roleid;
			$settingobj->setting = $settingparentarr[0];
			$settingobj->parent_id = $superparentid;
			$settingobj->level = 2;

			if ( isset($settingparentarr[1]) ) {
				$settingobj->url = str_replace($CFG->wwwroot, '', $settingparentarr[1]);
			}
			
			// Insert parent element
			$parentid = $DB->insert_record('local_sitesetting', $settingobj);

			// Insert child elements
			$childitemarr = $parentsettingarray[$value];
			
			foreach ($childitemarr as $key => $child) {
					
				$settingchildarr = explode("__", $child);

				// Object for child element
				$settingobj = new stdClass();
				$settingobj->role_id = $roleid;
				$settingobj->setting = $settingchildarr[0];
				$settingobj->parent_id = $parentid;
				$settingobj->level = 3;

				if ( isset($settingchildarr[1]) ) {
					$settingobj->url = str_replace($CFG->wwwroot, '', $settingchildarr[1]);
				}		

				$DB->insert_record('local_sitesetting', $settingobj);
			}	
		}

	}

}

// Load full admin navigation tree
navigation_node::require_admin_tree();

// Set page layout.
$PAGE->set_pagelayout('standard');

// Get title for the page
$title = get_string('pluginname', 'local_sitesetting');

// Set page title
$PAGE->set_title($title);

// Include javascript
$PAGE->requires->js_call_amd('local_sitesetting/custom', 'init');

// Set page url
$PAGE->set_url(new moodle_url('/local/sitesetting/customise.php'));

$customise = new customise();

$rolelabel = get_string('selectrole', 'local_sitesetting');

$roles = $customise->local_sitesetting_get_roles();
$rolesarray = [];

foreach ($roles as  $value) {
	$rolesarray[] = $value;
	
}

// Output header
echo $OUTPUT->header();

// Find the root node to show all the settings navigation tree
$node = $PAGE->settingsnav->find('root', navigation_node::TYPE_SITE_ADMIN);


if ($node) {

	// Some require form parameters
	$data = (object) [
		'actionurl' => $PAGE->url->out(false),
		'sesskey' => sesskey(),
		'roles' => $rolesarray,
		'rolelabel' => $rolelabel
	];

	// Show settings menus to configure
	echo $OUTPUT->render_from_template('local_sitesetting/customise', ['node' => $node, 'data' => $data]); 

}

// Output footer
echo $OUTPUT->footer();