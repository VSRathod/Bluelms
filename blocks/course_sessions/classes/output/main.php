<?php

namespace block_course_sessions\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;

class main implements renderable, templatable {

    public function export_for_template(renderer_base $output) {
        global $USER, $OUTPUT, $DB, $CFG;

        $data = self::get_activity_data();

        $defaultvariables = [
            'sessioncontent' => $data,
        ];
        return $defaultvariables;
    }

    public static function get_activity_data() {
        global $USER, $OUTPUT, $DB, $CFG;
        $currentdate = strtotime(date('d-m-Y'));
        
        $fivedaysbeforedate = strtotime(date('d-m-Y', strtotime("+5 days", $currentdate)));
        $course_modules = $DB->get_records_sql("SELECT z.* FROM {enrol} e 
        INNER JOIN {user_enrolments} ue ON e.id = ue.enrolid 
        INNER JOIN {zoom} z ON z.course = e.courseid 
        WHERE ue.userid = $USER->id AND z.start_time <= $fivedaysbeforedate GROUP BY ue.userid ORDER BY e.courseid" );
     
        $dataget = array();
        foreach ($course_modules as $keyalue) {
            $getact = $DB->get_record('zoom', array('id' => $keyalue->id));
            $modulesid = $DB->get_record('modules', array('name' => 'zoom'));
            
            // Fetch user details
            $userdetail = $DB->get_record('user', array('id' => $keyalue->userid));
            if ($userdetail) {
                $username = $userdetail->firstname . ' ' . $userdetail->lastname;
            } else {
                // Handle case where user details are not found
                $username = 'Unknown User';
            }

            if ($getact && $modulesid) {
                $current = date('Y-m-d H:i:s'); // Corrected line
                $instanceid = $DB->get_record('course_modules', array('instance' => $getact->id, 'course' => $getact->course,  'module' => $modulesid->id));
                $courseName = get_course($getact->course);
              
                $dataget[] = array(
                    // add this course
                    'course'=> $courseName->fullname,
                    'activityname' => $getact->name,
                    'module' => $modulesid->id,
                    'starttime' => date("d-M-Y, H:i a", $getact->start_time),
                    'url' => $CFG->wwwroot."/mod/zoom/view.php?id=".$instanceid->id,
                    'username' => $username  // Use the fetched username
                );
            }
        }
        return $dataget;
    }
}

