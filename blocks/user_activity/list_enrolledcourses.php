<?php
require_once ('../../config.php');
require_once ($CFG->dirroot . '/my/lib.php');
require_once ($CFG->dirroot . '/tag/lib.php');
require_once ($CFG->dirroot . '/user/profile/lib.php');
require_once ($CFG->libdir . '/filelib.php');


//require_once ($CFG->dirroot . '/user/profile/field/multiselect/field.class.php');
require_once ($CFG->dirroot . '/grade/querylib.php');
global $COURSE, $USER, $CFG, $DB, $OUTPUT, $PAGE;
require_login();
//get id user from url
$uid = optional_param('uid','', PARAM_INT);
//get user object
$user = $user = $DB ->get_record('user', array('id' => $uid));
$context = context_system::instance();
$PAGE->set_url(new moodle_url('/blocks/user_activity/list_notstarted.php'));
$PAGE->set_context($context);
// base, standard, course, mydashboard
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('enrolledcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$PAGE->set_heading(get_string('enrolledcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$PAGE->requires->css(new moodle_url('/blocks/user_activity/css/
user_activity
.css'));
$PAGE->requires->js(new moodle_url('/blocks/user_activity/js/common.js'));
$PAGE->navbar->add(get_string('enrolledcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('enrolledcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$userid = $uid ;
if(!$userid) $userid = $USER->id ;
//get courses enrolled for this user
$sql = "SELECT c.id as courseid , DATE_FORMAT(FROM_UNIXTIME(ue.timecreated), '%Y-%m-%d') as user_enrolment_date 
	FROM {course} as c 
	INNER JOIN {enrol} as e ON c.id = e.courseid 
	INNER JOIN {user_enrolments} as ue ON e.id = ue.enrolid 
	INNER JOIN {user} as u ON ue.userid = u.id WHERE u.id = ".$userid ." AND c.visible=1 " ;
	$CEnrolment = $DB ->get_records_sql($sql);
$tt= array();

foreach ($CEnrolment as $key => $enrollment ) {
	$course = $DB ->get_record('course', array('id' => $enrollment->courseid), '*', MUST_EXIST);

	$template_data['course_link'] = new moodle_url('/course/view.php',array('id'=>$course->id));
	$template_data['course_name'] = $course->fullname;
	$template_data['enrollment_date'] = $enrollment->user_enrolment_date;

	$tt[]=$template_data;
}
$data['course_listing'] = $tt;

if ($enrollment == ''){
	$data['no_data'] = true;
}

echo $OUTPUT->render_from_template('block_user_activity/list_enrolledcourses', $data);

echo $OUTPUT->footer();