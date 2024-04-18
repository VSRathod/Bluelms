<?php

namespace local_courses;

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use stdClass;
use html_writer;
use core_course_list_element;
use moodle_url;

// use context_course;
// use context_coursecat;
// use theme_moove\util\theme_settings;
// use theme_moove\output\core_renderer;

defined('MOODLE_INTERNAL') || die();
global $activityListCount;
/**
 * @course class 
 */
global $OUTPUT, $PAGE;

class Course
{
    public $courseid;
    public $course;
    protected $activityCount;
    // protected $activityListCount;

    protected $slidercourseimages;
    protected $templateContext;
    protected $extracom;
    protected $themesettings;
    protected $instanceofCategory;

    public function __construct($courseid)
    {
        $this->courseid = $courseid;
        $this->slidercourseimages = array();
        $this->templateContext = new stdClass;
        $this->activityCount = new stdClass;
        // $this->activityListCount = new stdClass;
        echo $this->index();
    }

    public function getDuration($duration = 0)
    {
        $duration = $duration ?: 0;

        if (!$duration)
            return '0:00';

        $hours = floor($duration / 60);

        if ($hours)
            return gmdate('H:i:s', $duration * 60);

        return gmdate('i:s', $duration * 60);
    }

    public function index()
    {
        global $OUTPUT, $DB, $SESSION, $USER, $CFG;
        require_once ($CFG->libdir . "/badgeslib.php");
        require_once ($CFG->libdir . "/pagelib.php");


        $this->course = $this->courseid ? $DB->get_record('course', array('id' => $this->courseid)) : new stdClass;

        // $coursehourdetails = $DB->get_record_sql("SELECT * FROM {hpcl_coursehours} WHERE course_id = $this->courseid");
        // if ($coursehourdetails) {
        //     $coursehourdetails->hours = $this->getDuration($coursehourdetails->hours);
        // }

        $facultyname = "";
        $facultyrecord = array();
        $role = $DB->get_record('role', array('shortname' => 'editingteacher'));
        $roleStudent = $DB->get_record('role', array('shortname' => 'student'));
        $context = get_context_instance(CONTEXT_COURSE, $this->courseid);
        $teachers = get_role_users($role->id, $context);

        if (has_capability('moodle/course:update', $context)) {
            $this->templateContext->editcapability = '/course/edit.php?id=' . $this->courseid;
        }

        foreach ($teachers as $teacher) {
            $user_object = \core_user::get_user($teacher->id);
            $conditions = array('size' => '240', 'link' => false, 'class' => '');
            $person_profile_pic = $OUTPUT->user_picture($user_object, $conditions);
            $teacherdata = array(
                'id' => $teacher->id,
                'firstname' => $teacher->firstname,
                'lastname' => $teacher->lastname,
                'username' => $teacher->username,
                'phone' => $teacher->phone1,
                'email' => $teacher->email,
                'profile_url' => $person_profile_pic
            );
            array_push($facultyrecord, $teacherdata);
        }

        $students = get_role_users($roleStudent->id, $context);

        $course_tags1 = array();
        $course_tags = $DB->get_records_sql("SELECT * from mdl_tag where id IN(SELECT tagid FROM mdl_tag_instance WHERE itemtype ='course' AND contextid = ?)", array($context->id));
        foreach ($course_tags as $course_tag) {
            $course_tags_data = array(
                'id' => $course_tag->id,
                'name' => $course_tag->name,
            );
            array_push($course_tags1, $course_tags_data);
        }

        $this->templateContext->categorycoursename = "DISCOVER DIFFERENT COURSE CATEGORIES";
        $this->templateContext->categorycoursedescription = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut est nulla, pulvinar dignissim sapien eget, ultrices congue nunc. Vestibulum quam.";

        if ($this->courseid) {
            $this->templateContext->coursedetails = $this->getCourseDetails();
            $this->templateContext->instructor = $facultyrecord;
            $this->templateContext->student_count = count($students);
            $this->templateContext->course_tags = $course_tags1;


            $relatedCourses = $this->relatedCourses($this->courseid);
            $this->templateContext->relatedCourses = $relatedCourses;
            $this->templateContext->hasrelatedCourse = count($relatedCourses);

            // $this->templateContext->coursehourdetails = $coursehourdetails;
            $this->templateContext->courseratings = $this->gate_rating($this->courseid);

            $this->templateContext->activityCount = $this->activityCount;
            $dataresult = $this->courseSectionsDetails();

            $this->templateContext->sectiondetails = $dataresult->p1;
            $this->templateContext->singlecoursecategorydetails = $this->getSingleCategoryDetails($this->courseid);

            $arracounterActivity = array();
            foreach ($dataresult->p2 as $counterActivity) {
                array_push($arracounterActivity, $counterActivity);
            }
            $this->templateContext->totalcountativitywise = $arracounterActivity;

            if (count($dataresult->p1) > 0) {
                $this->templateContext->hassections = TRUE;
            } else {
                $this->templateContext->hassections = FALSE;
            }
            $this->templateContext->coursebadges = $this->coursebadges($this->courseid, $context);

            $this->templateContext->course_image = $this->course_image($this->courseid, $this->course);


            $enrolled = is_enrolled($context, $USER->id, '', true);
            if ($enrolled) {
                $this->templateContext->buttontoshow = '<a class="btn btn-primary" href="' . $CFG->wwwroot . '/course/view.php?id=' . $this->courseid . '">View Course</a>';
            } else {
                $this->templateContext->buttontoshow = '<a class="btn btn-primary" href="' . $CFG->wwwroot . '/enrol/index.php?id=' . $this->courseid . '">Enroll Me</a>';
            }


            return $OUTPUT->render_from_template('local_courses/courses', $this->templateContext);
        }
    }

    private function getCourseDetails()
    {
        global $DB, $CFG;
        if (!is_null($this->courseid)) {

            $crs = $DB->get_record_sql('SELECT * FROM {course} WHERE category != 0 AND visible = 1 AND id = ?', [$this->courseid]);
            $enrol_details = $DB->get_records_sql("SELECT enrol,cost,currency FROM {enrol} WHERE courseid=$crs->id AND status=0");
            $enrol_price = 'Free';
            foreach ($enrol_details as $key => $value) {
                if (!empty($value->cost)) {
                    $enrol_price = $value->cost . ' ' . $value->currency;
                }
            }
            $crs->course_price = $enrol_price;
            return $crs;
        }
    }

    private function instuctorsDetails($courseid)
    {
    }

    public function course_image($courseid = null, $course = null)
    {
        global $DB, $CFG, $OUTPUT;
        $courserecord = $course ?: $DB->get_record('course', array('id' => $courseid));
        $course = new core_course_list_element($courserecord);
        try {
            foreach ($course->get_course_overviewfiles() as $file) {
                if ($file->is_valid_image()) {
                    return moodle_url::make_pluginfile_url(
                        $file->get_contextid(),
                        $file->get_component(),
                        $file->get_filearea(),
                        null,
                        $file->get_filepath(),
                        $file->get_filename()
                    )->out(false);
                    // Use the first image found.
                    break;
                }
            }
        } catch (\Throwable $th) {
        }

        return $OUTPUT->get_generated_image_for_id($courseid);
    }

    public function courseSectionsDetails()
    {
        $courseid = $this->courseid;
        global $DB, $CFG, $USER, $PAGE, $SESSION;
        require_once ($CFG->dirroot . '/course/lib.php');
        require_once ($CFG->libdir . '/completionlib.php');
        if (is_null($courseid)) {
            return FALSE;
        }
        $totalScorms = $totalQuizzes = $totalAssignments = $totalCertification = 0;
        $userid = null;
        $ttlArt = 0;
        $nofitem = 0;
        if (isloggedin()) {
            $userid = $USER->id;
        }
        $array_of_sections = array();
        $arrnew = array(); // stdClass;
        $arrnew2 = array();
        $coursesection = $DB->get_records_sql("SELECT * FROM {course_sections} WHERE course=$courseid AND visible = 1 AND sequence != '' ");
        foreach ($coursesection as $csvalue) {
            if ($csvalue->name == "") {
                $sectionname = "Topic " . $nofitem;
            } else {
                $sectionname = $csvalue->name;
            }
            $nofitem++;
            $count = 0;
            $cnt = 0;
            $titem = $csvalue->sequence;
            $sequenceid = explode(',', $titem);
            $topic_name = $sectionname;

            $test = array();
            foreach ($sequenceid as $sequenceval) {
                if ($sequenceval) {
                    $c_modulesinfo = $DB->get_record_sql("SELECT * FROM {course_modules} WHERE visible=1 AND  course=$courseid and deletioninprogress=0  and id=$sequenceval");
                    if (@$c_modulesinfo->module) {
                        $moduleinfo = $DB->get_record_sql("SELECT * FROM {modules} WHERE id=$c_modulesinfo->module");
                        $modulename = $moduleinfo->name;

                        $s = "select * from  mdl_$modulename WHERE id=$c_modulesinfo->instance";
                        $tableinfo = $s;
                        $courseinfossss = $DB->get_records_sql($tableinfo);
                        if ($courseinfossss) {
                            foreach ($courseinfossss as $tavleRow) {
                                $count++;
                                $ttlArt++;
                                if ($csvalue->section == 0) {
                                    $topic_name = "General";
                                }
                                if ($csvalue->name) {
                                    $topic_name = $csvalue->name;
                                }
                                $tname = $tavleRow->name;
                                $completionstate = null;
                                if (!is_null($userid)) {
                                    // $curs_mdl_cmpinfo = $DB->get_records_sql("SELECT completionstate,viewed,timemodified FROM {course_modules_completion} WHERE coursemoduleid =$c_modulesinfo->id and userid=$userid and completionstate=1");

                                    // if ($curs_mdl_cmpinfo) {
                                    //     $completionstate = array();
                                    //     array_push($completionstate, array(
                                    //         'completionstate' => $curs_mdl_cmpinfo[1]->completionstate,
                                    //         'viewed' => $curs_mdl_cmpinfo[1]->viewed,
                                    //         'timemodified' => date("l, d M Y, h:i A", $curs_mdl_cmpinfo[1]->timemodified)
                                    //     ));
                                    //     $cnt = count((array)$curs_mdl_cmpinfo);
                                    // }
                                }
                                $module_url = $CFG->wwwroot . '/course/view.php?id=' . $courseid;
                                $modulename = $modulename;
                                $module_id = $c_modulesinfo->id;
                                $modulename_Name = $tname;
                                $module_activity_url = $CFG->wwwroot . '/mod/' . $modulename . '/view.php?id=' . $module_id;
                                $module_activity_logo = $CFG->wwwroot . '/theme/image.php/boost/' . $modulename . '/1665076646/monologo';
                                if ($moduleinfo->name == 'assign') {
                                    $modulename = 'assignment';
                                    $totalAssignments++;
                                }
                                if ($moduleinfo->name == 'simplecertificate') {
                                    $modulename = 'Simple Certificate';
                                    $totalCertification++;
                                }
                                if ($moduleinfo->name == 'scorm') {
                                    $modulename = 'SCORM Package';
                                    $totalScorms++;
                                }
                                if ($moduleinfo->name == 'quiz') {
                                    $totalQuizzes++;
                                }
                                $sectiondeatils = array(
                                    'modulename' => $modulename,
                                    'module_id' => $module_id,
                                    'modulename_Name' => $tname,
                                    'module_url' => $module_url,
                                    'module_activity_logo' => $module_activity_logo,
                                    'module_activity_url' => $module_activity_url,
                                    'completionstate' => $completionstate
                                );
                                array_push($test, $sectiondeatils);
                                // $arrnew2[(ucfirst($modulename))] = $arrnew2[(ucfirst($modulename))] + 1;
                                $activitycountarr = array(
                                    'name' => ucfirst($modulename),
                                    'class' => $modulename,
                                    // 'count' => $arrnew2[(ucfirst($modulename))],
                                    'image' => $CFG->wwwroot . "/theme/image.php/boost/" . $moduleinfo->name . "/" . time() . "/monologo"
                                );
                                $arrnew[(ucfirst($modulename))] = $activitycountarr;
                            }
                        }
                    }
                }
            }
            if ($cnt != 0 and $count != 0) {
                $report = $cnt / $count * 100;
            } else {
                $report = 0;
            }
            $cnt = 0;
            $coursesectionobj = new stdClass();
            $coursesectionobj->sectionid = $csvalue->id;
            $coursesectionobj->section_sequence = $csvalue->section;
            $coursesectionobj->sectionname = $topic_name;
            $coursesectionobj->progress = number_format($report);
            $coursesectionobj->summary = $csvalue->summary;
            $coursesectionobj->sectiondata = $test;

            if ($activitiesCount = count($test)) {
                $coursesectionobj->totalActivities = $activitiesCount . ' ' . ($activitiesCount > 1 ? 'Activities' : 'Activity'
                );
            } else {
                $coursesectionobj->totalActivities = null;
            }

            array_push($array_of_sections, $coursesectionobj);
        }
        unset($arrnew['Forum']);

        $SESSION->countListAll = (object) $arrnew;
        // // array_push($array_of_sections, $arr);
        $array_of_sections1 = new stdClass;
        $array_of_sections1->p1 = $array_of_sections;
        $array_of_sections1->p2 = $arrnew;
        return $array_of_sections1;
    }

    private function getAllCategory()
    {
        global $DB;
        $coursecategoriesss = array();
        $coursecategories = $DB->get_records("course_categories", array("parent" => 0, "visible" => 1));
        if (!empty($coursecategories)) {
            foreach ($coursecategories as $value) {
                $value->image = $this->getCategoryImage($value->id);
                $value->cat_name = $value->name;
                $value->cat_id = $value->id;
                array_push($coursecategoriesss, $value);
            }
        }
        return $coursecategoriesss;
    }

    private function getSingleCategoryDetails($courseid)
    {
        global $DB;
        $singlecoursecategory = array();
        $getcoursecat = $DB->get_record("course", array("visible" => 1, 'id' => $courseid));
        if (!empty($getcoursecat)) {
            $categoryid = $getcoursecat->category;
            $getcoursecat1 = $DB->get_record("course_categories", array("visible" => 1, 'id' => $categoryid));
            return $getcoursecat1;
        }
    }

    private function relatedCourses($courseid)
    {
        global $DB;
        $courseReturn = array();
        $value = $DB->get_record_sql("SELECT parent as category from mdl_course_categories WHERE id = (SELECT category FROM mdl_course WHERE id = ?)", array($courseid));
        if ($value) {
            if (!is_null($value->category)) {
                $categoryid = $value->category;
                $allcourses = $DB->get_records_sql("SELECT * FROM {course} WHERE category = $categoryid AND visible = 1 ORDER BY id desc");
                $courselevel = '';

                foreach ($allcourses as $course) {
                    // $coursehourdetails1 = $DB->get_record_sql("SELECT * FROM {hpcl_coursehours} WHERE course_id = $course->id");
                    $course->courseimage = $this->course_image($course->id);

                    $courseD = array(
                        'fullname' => $course->fullname,
                        'shortname' => $course->shortname,
                        'id' => $course->id,
                        'summary' => $course->summary,
                        'courseimage' => $course->courseimage,
                        'category' => $course->category,
                        // 'coursehourdetails1' => $coursehourdetails1,
                        'getSingleCategoryDetails1' => $this->getSingleCategoryDetails($course->id)
                    );
                    array_push($courseReturn, $courseD);
                }
            }
        }
        return $courseReturn;
    }

    private function getCategoryImage($categoryid = null)
    {
    }

    protected function getcourseRating($courseid = 0, $comment = 0)
    {
        global $CFG, $DB, $OUTPUT;
        require_once("$CFG->libdir/outputcomponents.php");

        $sql = "SELECT AVG(custom_field_value) AS avg,   COUNT(*) AS total
        FROM {customfield_field}
        WHERE course = $courseid";
        $conditions = array('size' => '40', 'link' => false, 'class' => '');

        $avg = -1;
        $ratedby = 0;
        $totalRatedBy = 0;
        if ($avgrec = $DB->get_record_sql($sql)) {
            $avg = $avgrec->avg;
            $totalRatedBy = $avgrec->total;
            $avg = round($avg, 2);
        }
        // $numstars = $avg;
        // if ($numstars == -1) {
        //     $alt = '';
        // } else if ($numstars == 0) {
        //     $alt = get_string('rating_alt0', 'block_rate_course');
        // } else {
        //     $alt = get_string('rating_altnum', 'block_rate_course', $numstars);
        // }
        // $res = '<img title="' . $alt . '" src="' . $CFG->wwwroot . '/blocks/rate_course/pix/rating_graphic.php?courseid=' . $courseid . '" alt="' . $alt . '"/>';
        $result = new stdClass();
        // $result->rating =  $avg;
        $result->imgurl =  $res;
        $result->totalratedby =  $totalRatedBy;
        $arrayComment = array();
        if ($comment) {
            $comments = $DB->get_records_sql("SELECT userid, rating, r.added_time, comment, u.firstname, u.lastname, u.email, u.username FROM mdl_customfield_field r
            LEFT JOIN mdl_user u ON r.userid = u.id WHERE course = ?", array($courseid));
            foreach ($comments as $student) {
                $user = new stdClass();
                $user = $DB->get_record('user', array('id' => $student->userid));
                $user_picture = $OUTPUT->user_picture($user, $conditions);
                $student->picurl  = $user_picture;
                $student->dateadded  = date('d M Y', $student->added_time);

                // rating image
                // $numstars = $student->rating;
                // if ($numstars == -1) {
                //     $alt = '';
                // } else if ($numstars == 0) {
                //     $alt = get_string('rating_alt0', 'block_rate_course');
                // } else {
                //     $alt = get_string('rating_altnum', 'block_rate_course', $numstars);
                // }
                // // $rers = '<img title="' . $alt . '" src="' . $CFG->wwwroot . '/blocks/rate_course/pix/rating_graphic.php?ratingpoint=' . ($numstars * 2) . '" alt="' . $alt . '"/>';
                // $data->rating = $this->gate_rating($this->course->id);
                // $student->rateurl  = $rers;
                // array_push($arrayComment, $student);
                
            }
            
            $result->comments = $arrayComment;
        }
        return $result;
    }
    
    function gate_rating($course)
    {
        global $DB;

        // Define the SQL query
        $sql = "
        SELECT
            cd.value AS custom_field_value
        FROM
            {customfield_field} cf
        INNER JOIN
            {customfield_data} cd
        ON
            cf.id = cd.fieldid
        WHERE
            cf.shortname = :shortname AND cd.instanceid = :courseid
        ORDER BY
            cd.value ASC";

        // Define parameters
        $params = array('shortname' => 'tool_courserating', 'courseid' => $course);


        // Execute the SQL query
        $results = $DB->get_records_sql($sql, $params);
        $rating = [];


        // Output the results
        foreach ($results as $result) {
            $rating[] = $result->custom_field_value;
        }

        // Check if rating is available
        if (!empty($rating)) {
            // Generate HTML for star icons based on rating value
            $stars_html = '';

            if ($rating[0] != "") {
                $rating_value = substr($rating[0], 33, 3); // Assuming the rating is a numeric value

                $stars_html .= $rating[0];

            } else {
                $rating_value = 0;
                    $stars_html .= '<i class="fa fa-star-o" style="color: #e59819;"> </i> <i class="fa fa-star-o" style="color: #e59819;"> </i> <i class="fa fa-star-o" style="color: #e59819;"> </i> <i class="fa fa-star-o" style="color: #e59819;"> </i> <i class="fa fa-star-o" style="color: #e59819;"> </i>  '; // Yellow outline star

            }

            // $ecount=0;
            // Assuming you want full yellow star icons for each whole number rating
            // for ($i = 0; $i < 5; $i++) {
            //     if ($rating_value > $i) {
            //         // $rating[0];

            //     } else {
                   
            //         // $stars_html .= '<i class="fa fa-star-o" style="color: #e59819;"> </i>  '; // Yellow outline star
            //     }
            // }
        // echo $stars_html."<br>";
            return $stars_html;

        }


    }



    function sliderImages($courseid)
    {
    }

    public function coursebadges($courseId = 0, $context = null)
    {
        $listOfBadges = badges_get_badges(2, $courseId);
        if (empty($context)) {
            $context = get_context_instance(CONTEXT_COURSE, $courseId);
        }
        // $url = new moodle_url('/badges/badge_json.php', array('id' => 161));
        $badges = array();
        foreach ($listOfBadges as $badge) {
            $urlimage = moodle_url::make_pluginfile_url($context->id, 'badges', 'badgeimage', $badge->id, '/', 'f3')->out(false);
            $data = new stdClass();
            $data->id = $badge->id;
            $data->name = $badge->name;
            $data->urlimage = $urlimage;
            array_push($badges, $data);
        }
        return $badges;
    }

    function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
