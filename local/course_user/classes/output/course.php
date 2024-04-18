<?php

/**
 * @package local_course_user
 */

namespace local_course_user\output;

use core_course_list_element;
use moodle_url;
use renderable;
use templatable;
use renderer_base;
use stdClass;

class course implements renderable, templatable
{
    public $course;
    public string $animation;

    public function __construct($course, $animation = 'appear-animate')
    {
        $this->course = $course;
        $this->animation = $animation;
    }

    public function exportData()
    {
        global $CFG, $OUTPUT;
        $data = new stdClass();
        $data->url = $CFG->wwwroot . '/local/courses/index.php?course_id=' . $this->course->id;
        $data->firstname = trim($this->course->firstname);
        $data->username = trim($this->course->username);
        $data->lastname = trim($this->course->lastname);
        $data->id = trim($this->course->id);
        $data->email = trim($this->course->email);
        $data->role = trim($this->course->shortname);
        $data->department = trim($this->course->department);
        $data->usercode = trim($this->course->username);
        $enrolledcourses = enrol_get_all_users_courses($this->course->id);
        $data->enrolled = "-";
        if (!empty($enrolledcourses)) {
            $data->enrolled = count($enrolledcourses);
        }
        // $user_object = \core_user::get_user($this->course->id);
        $conditions = array('size' => '40', 'link' => false, 'class' => 'userpicture');
        $person_profile_pic = $OUTPUT->user_picture($data, $conditions);
        $data->person_profile_pic = $person_profile_pic;
        return $data;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param \renderer_base $output
     * @return stdClass
     */
    public function export_for_template(renderer_base $output)
    {
        return $this->exportData();
    }
}
