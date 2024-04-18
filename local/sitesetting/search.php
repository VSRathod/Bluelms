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
 * @author : VaibhavG
 * @since  : 19th March 2021
 * @desc   : search page
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
$PAGE->set_url(new moodle_url('/local/sitesetting/search.php'));

// Output header
echo $OUTPUT->header();

// Find the root node to show all the settings navigation tree
$node = $PAGE->settingsnav->find('root', navigation_node::TYPE_SITE_ADMIN);

$search = new search();

echo $search->local_search_view();

// Output footer
echo $OUTPUT->footer();