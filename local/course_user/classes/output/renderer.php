<?php

/**
 * Renderer class for local_course_user
 *
 * @package    local_course_user
 */

namespace local_course_user\output;

defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;
use renderable;

/**
 * Renderer class for local_course_user
 *
 * @package    local_course_user
 */
class renderer extends plugin_renderer_base
{


    /**
     * Output a nofication.
     *
     * @param string $message the message to print out
     * @return string HTML fragment.
     * @see \core\output\notification
     */
    public function notify_message($message)
    {
        $n = new \core\output\notification($message, \core\output\notification::NOTIFY_INFO);
        return $this->render($n);
    }

    /**
     * Output an error notification.
     *
     * @param string $message the message to print out
     * @return string HTML fragment.
     * @see \core\output\notification
     */
    public function notify_problem($message)
    {
        $n = new \core\output\notification($message, \core\output\notification::NOTIFY_ERROR);
        return $this->render($n);
    }

    /**
     * Output a success notification.
     *
     * @param string $message the message to print out
     * @return string HTML fragment.
     * @see \core\output\notification
     */
    public function notify_success($message)
    {
        $n = new \core\output\notification($message, \core\output\notification::NOTIFY_SUCCESS);
        return $this->render($n);
    }
}