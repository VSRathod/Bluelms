<?php
require_once ('../../config.php');
require_once ($CFG -> dirroot . '/my/lib.php');
require_once ($CFG -> dirroot . '/tag/lib.php');
require_once ($CFG -> dirroot . '/user/profile/lib.php');
require_once ($CFG -> libdir . '/filelib.php');


//require_once ($CFG -> dirroot . '/user/profile/field/multiselect/field.class.php');
// require_once ($CFG -> dirroot . '/grade/querylib.php');
global $COURSE, $USER, $CFG, $DB, $OUTPUT, $PAGE;
require_login();
//get id user from url
$uid = required_param('uid', PARAM_INT);
//get user object
$user = $user = $DB -> get_record('user', array('id' => $uid));
$context = context_system::instance();
$PAGE -> set_url(new moodle_url('/blocks/user_activity/list_notstarted.php'));
$PAGE -> set_context($context);
// base, standard, course, mydashboard
$PAGE -> set_pagelayout('report');
$PAGE -> set_title(get_string('listnotstartedcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$PAGE -> set_heading(get_string('listnotstartedcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
$PAGE -> requires -> css(new moodle_url('/blocks/user_activity/css/
user_activity
.css'));
$PAGE -> requires -> js(new moodle_url('/blocks/user_activity/js/common.js'));
$PAGE -> navbar -> add(get_string('listnotstartedcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));
echo $OUTPUT -> header();
echo $OUTPUT -> heading(get_string('listnotstartedcourses', 'block_user_activity', ($user->firstname.' '.$user->lastname)));

//get courses enrolled for this user
$courses = enrol_get_users_courses($uid,true);

//completed courses array
$completed = array();
$tt= array();
foreach ($courses as $course) {

	$course = $DB -> get_record('course', array('id' => $course -> id), '*', MUST_EXIST);
	
	
	$sql = "SELECT 
		DATE_FORMAT(FROM_UNIXTIME(ue.timecreated), '%Y-%m-%d') as user_enrolment_date 
		FROM {course} as c 
		INNER JOIN {enrol} as e ON c.id = e.courseid 
		INNER JOIN {user_enrolments} as ue ON e.id = ue.enrolid 
		INNER JOIN {user} as u ON ue.userid = u.id WHERE c.id = ".$course->id." and u.id = ".$USER->id;

	$CEnrolment = $DB -> get_record_sql($sql);
	// Load completion data.
	$info = new completion_info($course);

	
	if(!$info->is_enabled())
	continue ;
	
	// Is course complete?
	$coursecomplete = $info -> is_course_complete($uid);
	// Has this user completed any criteria?
	$criteriacomplete = $info -> count_course_user_data($uid);
	// Load course completion.
	// $params = array('userid' => $uid, 'course' => $course -> id);
	$ccompletion = new completion_completion($params);
	//is not the current course net started 
	if(!$criteriacomplete && !$ccompletion->timestarted && !$coursecomplete){

		$template_data['course_link'] = new moodle_url('/course/view.php',array('id'=>$course->id));
		$template_data['course_name'] = $course->fullname;

		if($ccompletion->timeenrolled > 0)
		{
		 	$template_data['timeenrolled'] = date('Y-m-d',$ccompletion->timeenrolled);
		}else 
		{
			$template_data['timeenrolled'] = $CEnrolment->user_enrolment_date;
		}
		$tt[]=$template_data;
	}
	//$tt[]=$template_data;
}
$data['course_listing'] = $tt;

echo $OUTPUT->render_from_template('block_user_activity/list_notstarted', $data);
echo $OUTPUT -> footer();