<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace mod_plugnmeet\event;

/**
 * The course_module_viewed event class.
 *
 * @package     mod_plugnmeet
 * @category    event
 * @author     Jibon L. Costa <jibon@mynaparrot.com>
 * @copyright  2022 MynaParrot
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class joined_plugnmeet_session extends \core\event\base {
    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'plugnmeet';
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return 'User with id ' . $this->userid . ' joined session with instanceid ' .
            $this->objectid;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('joined_session', 'mod_plugnmeet');
    }

    /**
     * Get URL related to the action
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/plugnmeet/conference.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Get objectid mapping
     *
     * @return array of parameters for object mapping.
     */
    public static function get_objectid_mapping() {
        return array('db' => 'plugnmeet', 'restore' => 'plugnmeet');
    }
}
