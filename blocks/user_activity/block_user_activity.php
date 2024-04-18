<?php
defined('MOODLE_INTERNAL') || die();

class block_user_activity extends block_base {

	function init() {
		$this -> title = get_string('pluginname', 'block_user_activity');
	}

	function instance_allow_multiple() {
		return false;
	}

	function has_config() {
		return true;
	}

	function applicable_formats() {
		return array('all' => true);
	}

	function instance_allow_config() {
		return true;
	}

	public function specialization() {
		if (empty( $this->config->title )) {
			$this->title = get_string('pluginname', 'block_user_activity');
		} else {
			$this->title = $this -> config -> title;
		}
	}

	function get_content() {
		global $COURSE, $USER, $CFG, $DB, $OUTPUT, $PAGE,$SESSION;
		
		$this->content = new stdClass();

		$PAGE->requires->css(new moodle_url('/blocks/user_activity/css/
user_activity
.css'));

		//get user
		$uid = $USER->id;
		$user = $DB->get_record('user', array('id' => $USER -> id));

		if ( isset($this->config) && ! isset($this->config->numberofrecords) ) {
			$this->config->numberofrecords = 2;
		}

		// Get courses percent : not started, in progress and completed
		//get courses enrolled for this user
		$courses = enrol_get_users_courses($USER -> id);

	
		if (count($courses) > 0){

			$ccompleted = 0;
			$cnoyetstarted = 0;
			$cinprogress = 0;
            require_once($CFG->dirroot . '/lib/completionlib.php');
			foreach ($courses as $course) {
				// Load course.
				$course = $DB->get_record('course', array('id' => $course -> id), '*', MUST_EXIST);

				// Load completion data.
				$info = new completion_info($course);
				
				

				if(!$info->is_enabled())
					continue ;

				// Is course complete?
				$coursecomplete = $info->is_course_complete($uid);

				// Has this user completed any criteria?
				$criteriacomplete = $info->count_course_user_data($uid);

				// Load course completion.
				$params = array('userid' => $uid, 'course' => $course -> id);

				$ccompletion = new completion_completion($params);

				if ($coursecomplete) {
					$ccompleted++;
				} else if (!$criteriacomplete && !$ccompletion -> timestarted) {
					$cnoyetstarted++;
				} else {
					$cinprogress++;
				}
			}
			//===================================================

			//get courses enrolled for this user
			$courses = count(enrol_get_users_courses($uid));

			if ($courses > 0) {
				$progress = ($ccompleted / $courses) * 100;
			} else {
				$progress = 0;
			}

			//user data array
			$userdata = array();

			$userdata[] = $OUTPUT->user_picture($user, array('size' => 50));

			//user info
			$userdata[] = '<a target="_blank" href="' . new moodle_url('/user/profile.php', array('id' => $user -> id)) . '">' . $user -> firstname . ' ' . $user -> lastname . '</a>';

			//data
			$per1 = number_format(($ccompleted / $courses) * 100, 2);
			$per2 = number_format(($cnoyetstarted / $courses) * 100, 2);
			$per3 = number_format(($cinprogress / $courses) * 100, 2);
			
			//color
			$color0 = get_config('block_user_activity', 'backgroundcolor');
			$color1 = get_config('block_user_activity', 'completedcolor');
			$color2 = get_config('block_user_activity', 'notyetstartedcolor');
			$color3 = get_config('block_user_activity', 'inprogresscolor');

			
			if($color1 == '#04EB62' && $color2 == '#C60300' && $color3 == '#FF950A'){
				$sql = "UPDATE {config_plugins} SET value = '#8fb644' WHERE plugin = 'block_user_activity' AND name = 'completedcolor' ";
	            $DB->execute($sql);
				$color1 = '#8fb644';	
				$sql = "UPDATE {config_plugins} SET value = '#cf6284' WHERE plugin = 'block_user_activity' AND name = 'notyetstartedcolor' ";
	            $DB->execute($sql);
				$color2 = '#cf6284';		
				$sql = "UPDATE {config_plugins} SET value = '#3f9ddb' WHERE plugin = 'block_user_activity' AND name = 'inprogresscolor' ";
	            $DB->execute($sql);
	            $color3 = '#3f9ddb';
			}

			$user_id = $USER->id;
			$PAGE->requires->jquery();

			
			
			
			$brandarr = $DB->get_record('config_plugins', array('name' => 'theme_bluelms', 'name' => 'brandprimary') );
			
			$brandcolor = ( isset($brandarr->value) && $brandarr->value != "") ? $brandarr->value : "#1ba2dd";
			$second_color = $this->adjustBrightness_second($brandcolor,'0.2');
			$third_color = $this->adjustBrightness_third($brandcolor,'0.6');
			// END
			$this -> content -> text = '';

			$data['userid'] = $USER->id;
			//$data['brandcolor'] = $brandcolor;
			$data['ccompleted'] = $ccompleted;
			$data['cnoyetstarted'] = $cnoyetstarted;
			$data['cinprogress'] = $cinprogress;
			$data['per1'] = $per1;
			$data['per2'] = $per2;
			$data['per3'] = $per3;
			//$data['second_color'] = $second_color;
			//$data['third_color'] = $third_color;

			// $data['comletedtxt'] = $comletedtxt;
			// $data['inprogresstxt'] = $inprogresstxt;
			// $data['notyetstartedtxt'] = $notyetstartedtxt;

			$list_completed_url = new moodle_url('/blocks/user_activity/list_completed.php',array('uid'=>$USER->id));
			$data['list_completed_url'] = $list_completed_url;
				
			$list_notstarted_url = new moodle_url('/blocks/user_activity/list_notstarted.php',array('uid'=>$USER->id));
			$data['list_notstarted_url'] = $list_notstarted_url;

			$list_inprogress = new moodle_url('/blocks/user_activity/list_inprogress.php',array('uid'=>$USER->id));
			$data['list_inprogress'] = $list_inprogress;

			$highchart_url = new moodle_url('/blocks/user_activity/js/highcharts.js');
			$data['highchart_url'] = $highchart_url;

			$this->content->text = $OUTPUT->render_from_template('block_user_activity/user_activity', $data);
			// end code
       	}
	}


	function adjustBrightness_second($hexCode, $adjustPercent) {
		$hexCode = ltrim($hexCode, '#');
		if (strlen($hexCode) == 3) {
			$hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
		}
		$hexCode = array_map('hexdec', str_split($hexCode, 2));
		foreach ($hexCode as & $color) {
			$adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
			$adjustAmount = ceil($adjustableLimit * $adjustPercent);
	
			$color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
		}
		return '#' . implode($hexCode);
	}

	function adjustBrightness_third($hexCode, $adjustPercent) {
		$hexCode = ltrim($hexCode, '#');
		if (strlen($hexCode) == 3) {
			$hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
		}
		$hexCode = array_map('hexdec', str_split($hexCode, 2));
		foreach ($hexCode as & $color) {
			$adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
			$adjustAmount = ceil($adjustableLimit * $adjustPercent);
	
			$color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
		}
		return '#' . implode($hexCode);
	}
	// END
  
}
