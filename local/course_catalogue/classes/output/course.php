<?php

/**
 * @package local_course_catalogue
 */

namespace local_course_catalogue\output;

use core_course_list_element;
use moodle_url;
use renderable;
use templatable;
use renderer_base;
use stdClass;

// declare(strict_types=1);


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
        global $CFG;

        $data = new stdClass();

        $data->id = $this->course->id;

        $data->animation = $this->animation;

        $data->url = $CFG->wwwroot . '/local/courses/index.php?course_id=' . $this->course->id;
        $data->thumbnail = $this->thumbnail();


        $data->title = trim($this->course->fullname);
        // truncate the course title if it is too long
        if (strlen($data->title) > 50) {
            $data->title = substr($data->title, 0, 50) . '...';
        }

        // if coursename is too long, show tooltip
        // as the title will be truncated
        $data->tooltip = trim(strlen($this->course->fullname)) > 25 ? $this->course->fullname : null;
        $data->category = $this->course->category_name;
        // $data->duration = $this->getDuration();
        // $data->proficiency_level = $this->course->proficiency_level ?: false;
        // $data->proficiency_level = false;
        // $data->mandatory = $this->getMandatory();
        $data->progress = floor(\core_completion\progress::get_course_progress_percentage($this->course));

        //  $data->ratingImgUrl = (new moodle_url('/admin/tool/courserating/index.php', array('courseid' => $this->course->id)))->out(false);
        $data->rating = $this->gate_rating($this->course->id);
        // print_r($this->course->id);
        return $data;

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

    // public function getMandatory()
    // {
    //     $field = strtolower($this->course->mandatory ?: '');

    //     return $field && ($field == 'mandatory' || $field == 1);
    // }

    // public function getDuration()
    // {
    //     $duration = $this->course->duration ?: 0;

    //     if (!$duration) return '0:00';

    //     $hours = floor($duration / 60);

    //     if ($hours) return gmdate('H:i:s', $duration * 60);

    //     return gmdate('i:s', $duration * 60);
    // }

    public function thumbnail()
    {
        global $OUTPUT;

        $course = new core_course_list_element($this->course); //don't send the id jsut send the whole course if not you will get the stcClass Error

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

        return $OUTPUT->get_generated_image_for_id($this->course->id);
    }
}


