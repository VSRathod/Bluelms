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

namespace local_openlms\output\dialog_form;

/**
 * Dialog form renderer.
 *
 * @package    local_openlms
 * @copyright  2022 Open LMS (https://www.openlms.net/)
 * @author     Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class renderer extends \plugin_renderer_base {
    protected function render_icon(icon $action) {
        if ($action->legacyformtest) {
            $img = \core\output\icon_system::instance()->render_pix_icon($this->output, $action->get_icon());
            if ($action->is_disabled()) {
                return $img;
            }
            return \html_writer::link($action->get_form_url(), $img);
        }

        $data = [
            'icon' => \core\output\icon_system::instance()->render_pix_icon($this->output, $action->get_icon()),
            'title' => $action->get_title(),
            'formurl' => $action->get_form_url()->out(false),
            'dialogname' => $action->get_dialog_name(),
            'aftersubmit' => $action->get_after_submit(),
            'class' => $action->get_class(),
            'uniqid' => uniqid(),
        ];

        if ($action->is_disabled()) {
            return $this->output->render_from_template('local_openlms/dialog_form/icon_disabled', $data);
        } else {
            return $this->output->render_from_template('local_openlms/dialog_form/icon', $data);
        }
    }

    protected function render_button(button $button) {
        $data = [
            'title' => $button->get_title(),
            'formurl' => $button->get_form_url()->out(false),
            'dialogname' => $button->get_dialog_name(),
            'aftersubmit' => $button->get_after_submit(),
            'class' => $button->get_class(),
            'uniqid' => uniqid(),
        ];
        if ($button->is_primary()) {
            $data['primary'] = 1;
        }

        $pixicon = $button->get_icon();
        if ($pixicon) {
            $data['icon'] = \core\output\icon_system::instance()->render_pix_icon($this->output, $pixicon);
        }

        if ($button->is_disabled()) {
            return $this->output->render_from_template('local_openlms/dialog_form/button_disabled', $data);
        } else if ($button->legacyformtest) {
            return $this->output->render_from_template('local_openlms/dialog_form/button_legacy', $data);
        } else {
            return $this->output->render_from_template('local_openlms/dialog_form/button', $data);
        }
    }
}
