<?php
defined('MOODLE_INTERNAL') || die();

class block_course_sessions extends block_base {
 
    public function init() {
        global $CFG;
        require_once("{$CFG->libdir}/completionlib.php");
        $this->title = get_string('pluginname', 'block_course_sessions');
    }

    public function get_content() {
        global $OUTPUT,$USER,$DB;

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->instance)) {
            $this->content = '';
            return $this->content;
        }

        $course = $this->page->course;
        
        $context = context_course::instance($course->id);
        $courses = $DB->get_record('course', array('id' => $course->id));
        $info = new completion_info($courses);

        $renderable = new \block_course_sessions\output\main($course->id, $USER->id,$info);
        $renderer = $this->page->get_renderer('block_course_sessions');
        


        $this->content = new stdClass();
        $this->content->text = $renderer->render($renderable);
        $this->content->footer = '';

        return $this->content;
    }
  
    public function applicable_formats() {
        if (is_siteadmin()) {
            return array('all' => true);
        } else {
            return array('site' => true);
        }
    }
   
    public function instance_allow_multiple() {
        return false;
    }

    function has_config() {
        return false;
    }
}
