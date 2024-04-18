<?php

require_once('../../../config.php');
global $CFG, $DB, $USER;

require_login();
require_once($CFG->dirroot . '/local/course_user/classes/controller.php');

$controller = new local_course_user\CatalogueController();

$action = optional_param('action', '', PARAM_RAW);
if ($action == 'delete') {
    $userid =  $_REQUEST['userid'];
    $sitecontext = context_system::instance();
    if (!has_capability('moodle/user:update', $sitecontext) and !has_capability('moodle/user:delete', $sitecontext)) {
        // print_error('nopermissions', 'error', '', 'edit/delete users'); die;
        echo 'Access Denied!';
        die;
    }
    if ($controller->updateuser($userid)) {
        echo 'User has been deleted successfully.';
        die;
    } else {
        return 'Failed';
    }
} else if ($action == 'saveCourseEnrolmentData') {
    $userids  = optional_param('assignId', false, PARAM_RAW);
    $courses  = optional_param('elementList', false, PARAM_RAW);
    require_once($CFG->dirroot . '/enrol/manual/locallib.php');
    require_once($CFG->dirroot . '/lib/enrollib.php');

    $useridsArr  = explode(',', $userids);
    $coursesArr  = explode(',', $courses);

    foreach ($useridsArr as $useru) {
        foreach ($coursesArr as $course) {
            // loop through the enrollment...
            if (!enrol_is_enabled('manual')) {
                // return false;
            }
            if (!$enrol = enrol_get_plugin('manual')) {
                // return false;
            }
            if (!$instances = $DB->get_records('enrol', array('enrol' => 'manual', 'courseid' => $course, 'status' => ENROL_INSTANCE_ENABLED), 'sortorder,id ASC')) {
                return false;
            }
            $instance = reset($instances);
            $timestart = time();
            $timeend = 0;
            $enrol->enrol_user($instance, $useru, 5, $timestart, $timeend);
        }
    }
    return 'Success';
} else if ($action == 'saveCohortElementData') {
    $userids  = optional_param('assignId', false, PARAM_RAW);
    $cohorts  = optional_param('elementList', false, PARAM_RAW);
    require_once($CFG->dirroot . '/enrol/manual/locallib.php');
    require_once($CFG->dirroot . '/lib/enrollib.php');

    $useridsArr  = explode(',', $userids);
    $cohortsArr  = explode(',', $cohorts);

    foreach ($useridsArr as $useru) {
        foreach ($cohortsArr as $cohort) {
            if ($instances = $DB->get_records('cohort_members', array('cohortid' => $cohort, 'userid' => $useru))) {
                continue;
            }
            $instanceInst = new stdClass;
            $instanceInst->timeadded = time();
            $instanceInst->userid = $useru;
            $instanceInst->cohortid = $cohort;
            $DB->insert_record('cohort_members', $instanceInst);
        }
    }
    return 'Success';
} else if ($action == 'getcourses') {

    $coursecat_element_list  = optional_param('coursecat_element_list', 0, PARAM_RAW);
    $where  = "";
    if ($coursecat_element_list) {
        $where .= " AND category = $coursecat_element_list";
    }

    $cate = "select id, fullname as name from {course} where visible = 1 $where order by fullname asc";
    $cateArr = $DB->get_records_sql($cate);

    $optionHtml = "";
    foreach ($cateArr as $cat) {
        $optionHtml .= '<option rel = "' . $cat->id . '"> ' . $cat->name . '</option>';
    }
    echo $optionHtml;
    die;
} else if ($action == 'saveCourseRecommendData') {
    $userids  = optional_param('assignId', false, PARAM_RAW);
    $courses  = optional_param('elementList', false, PARAM_RAW);

    $useridsArr  = explode(',', $userids);
    $coursesArr  = explode(',', $courses);

    foreach ($useridsArr as $useru) {
        foreach ($coursesArr as $course) {
            if ($instances = $DB->get_records('local_recommendation', array('userid' => $useru, 'courseid' => $course))) {
                continue;
            }
            $instanceInst = new stdClass;
            $instanceInst->timeadded = time();
            $instanceInst->userid = $useru;
            $instanceInst->recommended_by = $USER->id;
            $instanceInst->courseid = $course;
            $DB->insert_record('local_recommendation', $instanceInst);
        }
    }
    echo 'Success';
    die;
}
