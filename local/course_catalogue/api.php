<?php

/**
 * Courses catalog and filters APIs
 * 
 * URL params:
 * `page`: page number (default: 1) (int)
 * `search`: search query (default: null) (string)
 * `tag`: tag search query (default: null) (string)
 * `response`: response type (default: json) [json|html] (string)
 * `pagination_type`: type of pagination (default: simple) [simple|full] (string)
 * `per_page`: number of courses per page (default: 6) (int) (max: 20, min: 1)
 */

use local_course_catalogue\output\pagination;

require_once('../../config.php');
require_once('../../course/lib.php');
require_once('classes/controller.php');
require_once('classes/output/course.php');
require_once('classes/output/pagination.php');

require_login();

$responseType = optional_param('response', 'json', PARAM_TEXT);
$paginationType = optional_param('pagination_type', 'simple', PARAM_TEXT);
$perPage = optional_param('per_page', 6, PARAM_INT);
$animation = optional_param('animation', 'appear-animate', PARAM_TEXT);

if ($perPage > 20) {
    $perPage = 20;
}

if ($perPage < 1) {
    $perPage = 1;
}

$controller = new local_course_catalogue\CatalogueController([
    'per_page' => $perPage,
]);

$pagination = new pagination($controller);

// set json header
header('Content-Type: application/json');

if ($responseType === 'html') {
    $output = $PAGE->get_renderer('local_course_catalogue');

    $html = '<div class="card-deck dashboard-card-deck" id="catalogue-card-deck">';
    foreach ($controller->getCourses() as $course) {
        $html .= $output->render(new \local_course_catalogue\output\course($course, $animation));
    }
    $html .= '</div>';

    echo json_encode([
        'data' => $html,
        'pagination' => ($paginationType == 'simple'
            ? $pagination->simplePagination()
            : $pagination->fullPagination()
        )->toArray()
    ]);

    exit;
}

$data = [];

foreach ($controller->getCourses() as $course) {
    $data[] = (new \local_course_catalogue\output\course($course, $animation))->exportData();
}

echo json_encode([
    'data' => $data,
    'pagination' => ($paginationType == 'simple'
        ? $pagination->simplePagination()
        : $pagination->fullPagination()
    )->toArray(),
]);
