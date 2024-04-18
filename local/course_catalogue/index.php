<?php

/**
 * Courses catalog and filters
 */

use local_course_catalogue\output\FilterRenderer;

require_once('../../config.php');
require_once('../../course/lib.php');
require_once('classes/controller.php');
require_once('classes/output/renderer.php');
require_once('classes/output/searchbar.php');
require_once('classes/output/course.php');
require_once('classes/output/pagination.php');
require_once('classes/output/filterRenderer.php');

require_login();

$controller = new local_course_catalogue\CatalogueController([
    'filters' => [
        'sort' => 'relevance',
    ]
]);

// $controller->getCourses();

// dd($controller->routeParams());

$PAGE->set_url('/local/course_catalogue');
$PAGE->navbar->add(get_string('pluginname', 'local_course_catalogue'), new moodle_url('/local/course_catalogue'));
navigation_node::override_active_url(new moodle_url('/local/course_catalogue'));

$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_course_catalogue'));

// load css file
$PAGE->requires->css('/local/course_catalogue/css/styles.css');

echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_course_catalogue');

echo html_writer::start_div('row py-2');

echo html_writer::start_div('col-lg-3 col-xl-2');

echo html_writer::tag('h1', 'Catalogue', ['class' => 'catalogue-title mb-3 mb-lg-4']);

$rp = $controller->routeParams();

unset($rp['page']);

if (isset($rp['sort']) && $rp['sort'] == 'relevance') {
    unset($rp['sort']);
}

if (count($rp) > 0) {
    // count deep array
    $filtersCount = 0;
    foreach ($rp as $key => $value) {
        if (is_array($value)) {
            $filtersCount += count($value);
        } else {
            $filtersCount++;
        }
    }

    echo html_writer::start_div('filters-header d-flex justify-content-between align-items-center mb-1');
    echo html_writer::tag('span', "<b class='text-dark'>{$filtersCount}</b> filters applied", ['class' => 'text-muted']);
    echo html_writer::link(new moodle_url('/local/course_catalogue'), 'Clear all', ['class' => 'btn btn-secondary btn-sm']);
    echo html_writer::end_div();
}

echo (new FilterRenderer($controller->getFilters()))->render();

// require_once 'templates/filters.php';

// end .col-lg-3.col-xl-2
echo html_writer::end_div();

echo html_writer::start_div('col');

echo $output->render(new \local_course_catalogue\output\searchbar($controller));

if (count($controller->getCourses()) > 0) {
    echo html_writer::start_div('card-deck dashboard-card-deck', ['id' => 'catalogue-card-deck']);
    foreach ($controller->getCourses() as $course) {
        echo $output->render(new \local_course_catalogue\output\course($course));
        
    }
    // end .card-deck.dashboard-card-deck
    echo html_writer::end_div();
} else
 {
    echo '<div class="text-center px-2 py-4"><i class="fa fa-search fa-2x mb-1 text-muted"></i><h3>No courses found</h3></div>';
}

echo $output->render(new \local_course_catalogue\output\pagination($controller));


// end .col
echo html_writer::end_div();

// end .row
echo html_writer::end_div();

echo html_writer::script('
    const courseCatalogueRouteParams = ' . json_encode($controller->routeParams()) . ';
');

// require js file
$PAGE->requires->js('/local/course_catalogue/js/main.js');

echo $OUTPUT->footer();
