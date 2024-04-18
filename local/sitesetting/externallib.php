<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Web service declarations
 *
 * @package    local_sitesetting
 * @copyright  2020 Akash Uphade (akash.u@paradisosolutions.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/externallib.php');


class local_sitesetting_external extends external_api {

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function getsettings_parameters() {
        return new external_function_parameters(
            array(
                'roleid' => new external_value(PARAM_TEXT, 'ID of user role')
            )
        );
    }

    /** 
     * Returns description of method result
     * @return external_description
     */
    public static function getsettings_returns() {
        return new external_multiple_structure(
            new external_single_structure(
                array(
                      'id' => new external_value(PARAM_INT, 'settingkey'),
                      'setting' => new external_value(PARAM_TEXT, 'setting')
                )
            )
        );
    }

    /**
     * Get saved settings
     * @param int $roleid 
     * @return settings array
     * @throws invalid_parameter_exception
     */
    public static function getsettings($roleid) {
        global $DB;

        // Validate params
        $params = self::validate_parameters(self::getsettings_parameters(), ['roleid' => $roleid]);

        // Get child settings for provided role
        $records = $DB->get_records_menu('local_sitesetting', ['role_id' => $params['roleid'], 'level' => 3], 'id', 'id, setting');

        // Just the bits we need
        $settings = [];
        foreach ($records as $key => $record) {
            $settings[] = [
                'id' => $key,
                'setting' => $record
            ];
        }

        return $settings;
    }
}