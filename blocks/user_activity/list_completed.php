<?php
require_once ('../../config.php');
require_once ($CFG -> dirroot . '/my/lib.php');
require_once ($CFG -> dirroot . '/tag/lib.php');
require_once ($CFG -> dirroot . '/user/profile/lib.php');
require_once ($CFG -> libdir . '/filelib.php');


require_once ($CFG -> dirroot . '/grade/querylib.php');
global $COURSE, $USER, $CFG, $DB, $OUTPUT, $PAGE;
require_login();
//get id user from url
$uid = required_param('uid', PARAM_INT);
//get user object
$user = $user = $DB -> get_record('user', array('id' => $uid));
$context = context_system::instance();
// $PAGE -> set_url(new moodle_url('/blocks/paradiso_teamwork/list_completed.php'));
$PAGE -> set_context($context);
// base, standard, course, mydashboard
$PAGE -> set_pagelayout('report');
$PAGE -> set_title(get_string('listcoursecompleted', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$PAGE -> set_heading(get_string('listcoursecompleted', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$PAGE -> requires -> css(new moodle_url('/blocks/user_activity/css/user_activity.css'));
$PAGE -> requires -> js(new moodle_url('/blocks/user_activity/js/common.js'));
$PAGE -> navbar -> add(get_string('listcoursecompleted', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
echo $OUTPUT -> header();
echo $OUTPUT -> heading(get_string('listcoursecompleted', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
//Build the table with the list of users
//get courses enrolled for this user
$courses = enrol_get_users_courses($uid,true);
//completed courses array
$completed = array();
//$data = array();
$tt= array();
foreach ($courses as $course) {
	// Load course.
	$course = $DB -> get_record('course', array('id' => $course -> id), '*', MUST_EXIST);
	// Load completion data.
	$info = new completion_info($course);

	if(!$info->is_enabled())
	continue ;

	// Is course complete?
	if($info -> is_course_complete($uid)){
		// Load course completion.
		$params = array('userid' => $uid, 'course' => $course -> id);
		$completion = new completion_completion($params);

		$template_data['course_link'] = new moodle_url('/course/view.php',array('id'=>$course->id));
		$template_data['course_name'] = $course->fullname;
		$template_data['enrollment_date'] = date('Y-m-d h:i',$completion->timeenrolled);
		$template_data['started_time'] = date('Y-m-d h:i', ( $completion->timestarted ? $completion->timestarted : $course->startdate ) );
		$template_data['completed_time'] = date('Y-m-d h:i',$completion->timecompleted);


		$tt[]=$template_data;
	}

	$tt[]=$template_data;
}

$data['course_listing'] = $tt;

echo $OUTPUT->render_from_template('block_user_activity/list_completed', $data);
// echo html_writer::table($table);
echo $OUTPUT -> footer();