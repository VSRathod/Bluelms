<?php

/**
 * Courses catalog and filters
 */

use local_course_user\output\FilterRenderer;

require_once('../../config.php');
require_once('classes/controller.php');
require_once('classes/output/renderer.php');
require_once('classes/output/searchbar.php');
require_once('classes/output/pagination.php');
require_once('classes/output/filterRenderer.php');
require "$CFG->libdir/tablelib.php";
$course_id = optional_param('course_id', 0, PARAM_INT);
require_login($course);
$controller = new local_course_user\CatalogueController();

$PAGE->set_url('/local/course_user');
$PAGE->navbar->add(get_string('pluginname', 'local_course_user'), new moodle_url('/local/course_user'));
navigation_node::override_active_url(new moodle_url('/local/course_user'));
$systemcontext = context_system::instance();
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_course_user'));

$PAGE->set_heading(get_string('pluginname', 'local_course_user'));
$admins = get_admins();
if (array_key_exists($USER->id, $admins) || has_capability('moodle/user:create', $systemcontext)) {
    $PAGE->add_header_action(
        html_writer::link(new moodle_url('/user/editadvanced.php', ['id' => '-1']), 'Add new user', ['class' => 'btn btn-secondary']) . ' ' .
            html_writer::link(new moodle_url('/admin/tool/uploaduser/index.php'), 'Bulk upload', ['class' => 'btn btn-secondary'])
    );
}
// load css file

$PAGE->requires->css('/local/course_user/css/styles.css');

$isAdmin = is_siteadmin();

echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_course_user');

echo html_writer::start_div('row py-2');


$USER->modifiedroleadmin = 0;
if (array_key_exists($USER->id, $admins)) {
    $USER->modifiedroleadmin = 1;
    echo html_writer::start_div('col-lg-3 col-xl-2');
    echo (new FilterRenderer($controller->getFilters()))->render();
} else {
    echo html_writer::start_div('col-lg-2 col-xl-1');
}

echo html_writer::end_div();
echo html_writer::start_div('col');

// Manage enrolments. 
require_once($CFG->dirroot . '/user/renderer.php');
require_once($CFG->dirroot . '/user/lib.php');
require_once($CFG->libdir . '/tablelib.php');
require_once($CFG->libdir . '/filelib.php');
require_once($CFG->dirroot . '/enrol/locallib.php');

$PAGE->set_title("$course->shortname: " . get_string('participants'));
$PAGE->set_heading($course->fullname);
$PAGE->set_pagetype('course-view-participants');

$node = $PAGE->settingsnav->find('users', navigation_node::TYPE_CONTAINER);
if ($node) {
    $node->force_open();
}
$filtergroupids = $urlgroupid ? [$urlgroupid] : [];

echo $output->render(new \local_course_user\output\searchbar($controller));

$users = $controller->getUsers($course_id);

?>

<div class="helper-buttons">
    <!-- Select visible users button -->
    <a href="#" class="btn btn-secondary" id="select-all">
        Select visible users <span class="badge badge-light"><?= count($users) ?: 0 ?></span>
    </a>

    <!-- Unselect users button -->
    <a href="#" class="btn btn-secondary conditional-btn disabled" id="unselect-all">
        Unselect users<span class="badge badge-light selected-users-count ml-1">0</span>
    </a>

    <!-- Enrol to course button -->
    <a href="#" class="btn btn-primary conditional-btn disabled" id="enrol-to-course">
        Enrol to course<span class="badge badge-light selected-users-count ml-1">0</span>
    </a>

    <!-- Add users to cohort button (if user is admin) -->
    <?php if ($isAdmin) : ?>
        <a href="#" class="btn btn-info conditional-btn disabled" id="add-to-cohort">
            Add users to cohort<span class="badge badge-light selected-users-count ml-1">0</span>
        </a>
    <?php endif; ?>

    <!-- Recommend course button -->
    <a href="#" class="btn btn-success conditional-btn disabled" id="recommend-course">
        Recommend course<span class="badge badge-light selected-users-count ml-1">0</span>
    </a>

    <!-- Delete users button (if user is admin) -->
    <?php if ($isAdmin) : ?>
        <a href="#" class="btn btn-danger conditional-btn disabled" id="delete-users">
            Delete users<span class="badge badge-light selected-users-count ml-1">0</span>
        </a>
    <?php endif; ?>

    <!-- Clear Filters button -->
    <a href="#" class="btn btn-warning" id="clear-filters">Clear Filters</a>
</div>


<?php

$displayingData = (object) [
    'from' => (($controller->currentPage - 1) * $controller->PER_PAGE) ?: 1,
    'to' => $controller->PER_PAGE * $controller->currentPage,
    'total' => $controller->pagination['totalData'],
];

if ($displayingData->to > $displayingData->total) {
    $displayingData->to = $displayingData->total;
}

echo "<h4 class='mb-3'>Displaying {$displayingData->from}-{$displayingData->to} of {$displayingData->total} users</h4>";

$table = new html_table();

$table->head = [
    "<input name='user0' type='checkbox' value='select_all' class='select-all-checkbox' >",
    '#',
    'User Name',
    'Avatar',
    'Full Name',
    'Email',
    'Department',
    'Courses<br><small class="text-muted">Completed/Enrolled</small>',
    'Actions',
];

if (count($users) == 0) {
    $table->attributes['class'] = 'table';

    $cell = new html_table_cell();
    $cell->colspan = count($table->head);
    $cell->attributes['class'] = 'text-center';

    $cell->text = '<i class="fa fa-info-circle fa-3x mb-2 text-muted"></i><h4 class="mb-0">No users found</h4>';

    // $cell->text .= html_writer::link(new moodle_url('/user/editadvanced.php', ['id' => '-1']), 'Add new user', ['class' => 'btn btn-primary mt-2']);
    // $cell->text .= html_writer::link(new moodle_url('/admin/tool/uploaduser/index.php'), 'Bulk upload users', ['class' => 'btn btn-secondary ml-2 mt-2']);

    $filters = $controller->routeParams();

    // remove page param
    unset($filters['page']);

    if (count($filters)) {
        $cell->text .= html_writer::link(new moodle_url('/local/course_user/index.php'), 'Clear filters', ['class' => 'btn btn-light ml-2 mt-2']);
    }

    $table->data[] = new html_table_row([$cell]);
} else {
    foreach ($users as $index => $user) {
        $deletenoshow = '';
        if ($user->auth == 'ldap') {
            $deletenoshow = 'hidethis';
        }
        $completedCount = 0;
        $completedCourse = "select count(*) as completion_count from {course_completions} where userid = ? AND timecompleted > ?";
        $completedCourse1 = $DB->get_record_sql($completedCourse, array($user->id, 0));
        if ($completedCourse1) {
            $completedCount = $completedCourse1->completion_count;
        }

        $links = '<a href="' . new moodle_url('/user/profile.php', ['id' => $user->id]) . '" class="dropdown-item">View profile</a>';
        $links .= '<a href="' . new moodle_url('/user/editadvanced.php', ['id' => $user->id]) . '" class="dropdown-item">Edit profile</a>';

        if ($isAdmin) {
            $nameSm = $user->firstname . " " .  $user->lastname;

            if (strlen($nameSm) > 20) {
                $nameSm = substr($nameSm, 0, 20) . '...';
            }

            $links .= '<a href="' . new moodle_url('/course/loginas.php', ['id' => 1, 'user' => $user->id, 'sesskey' => sesskey()]) . '" class="dropdown-item text-info">Login as <b>' . $nameSm . '</b></a>';
        }

        $table->data[] = [
            '<input id="user' . $user->id . '" name="user' . $user->id . '" type="checkbox" class="selectusercheckbox" value="' . $user->id . '">',
            $index + 1 + ($controller->currentPage - 1) * $controller->PER_PAGE,
            $user->username,
            $OUTPUT->user_picture($user, ['size' => '40', 'link' => false, 'class' => 'userpicture']),
            '<a href="/user/profile.php?id=' . $user->id . '">' . $user->firstname . " " .  $user->lastname . '</a>',
            $user->email,
            $user->department,
            '<b>' . $completedCount . '/' . count(enrol_get_all_users_courses($user->id)) . '</b> <small class="text-dim">courses</small>',
            // html_writer::link(new moodle_url('/user/editadvanced.php', ['id' => $user->id]), '<i class="icon fa fa-cog"></i>', []) . ' ' .
            //     html_writer::link('#', '<i class="icon fa fa-trash"></i>', ['data-id' => $user->id, 'class' => 'delete-user text-danger ' . $deletenoshow,]),
            '<a href="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-cog"></i>
            </a>
            <div class="dropdown-menu">' . $links . '</div>',
        ];
    }
}

echo html_writer::table($table);

echo $output->render(new \local_course_user\output\pagination($controller));

// end .col
echo html_writer::end_div();

// end .row
echo html_writer::end_div();

?>

<div class="modal fade" id="userActionModal" tabindex="-1" role="dialog" aria-labelledby="userActionModalTitle" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userActionModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center py-4 px-1">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo html_writer::script('
    const courseCatalogueRouteParams = ' . json_encode($controller->routeParams()) . ';
    const totalVisibleUsers = parseInt(' . count($users) . ');
');

// require js file
$PAGE->requires->js('/local/course_user/js/main.js');

echo $OUTPUT->footer();
